<?php

namespace App\Http\Controllers\api\Cart;

use App\Http\Controllers\api\Log\AppLogController;
use App\Http\Controllers\Controller;
use App\Http\GenerateCodeOrder\GenerateCode;
use App\Models\CartModel;
use App\Models\CartProductModel;
use App\Models\OrderDetail;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\PacketModel;
use App\Models\TransactionModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function getCart()
    {
        try {
            $carts = DB::table("carts")
                ->select(
                    "id",
                    "source",
                    "shop_name",
                    "shop_id",
                    "shop_url",
                    "user_id",
                    "total_price",
                    'opt_wood_pack',
                    'opt_checking',
                    'opt_private_wood_pack'
                )
                ->where("carts.user_id", Auth::id())
                ->where("carts.is_delete", false)
                ->orderByDesc('carts.created_at')
                ->get();
            $cartIds = $carts->pluck("id");
            $cartProducts = DB::table("cart_products")
                ->select(
                    "id",
                    "cart_id",
                    "product_name",
                    "user_id",
                    "image",
                    "price",
                    "price_cn",
                    "quantity",
                    "quantity_min",
                    "properties",
                    "stock",
                    "url",
                    "unit_price_cn",
                    "unit_price_vn",
                    "created_at"
                )
                ->where("cart_products.user_id", Auth::id())
                ->where("cart_products.is_delete", false)
                ->whereIn("cart_products.cart_id", $cartIds)
                ->orderByDesc('cart_products.created_at')
                ->get();
            $newCartProducts = [];
            foreach ($cartProducts as $key => $value) {
                $cartId = $value->cart_id;
                if (!isset($newCartProducts[$cartId])) {
                    $newCartProducts[$cartId] = [];
                }
                $newCartProducts[$cartId][] = (array)$value;
            }
            $newCarts = [];
            foreach ($carts as $key => $value) {
                $cartId = $value->id;
                $newCarts[$key] = (array)$value;
                $newCarts[$key]["cart_products"] = [];
                if (isset($newCartProducts[$cartId])) {
                    $newCarts[$key]["cart_products"] = $newCartProducts[$cartId];
                }
            }
            // $result["newCarts"] = $newCarts;
            return response()->json([
                'data' => $newCarts,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    public function removeProduct($id)
    {
        try {
            $data =  CartProductModel::findOrFail($id);
            CartProductModel::where('id', $id)->update(['is_delete' => 1]);
            $countCartProducts = DB::table('cart_products')
                ->select('cart_products.id', 'cart_products.cart_id')
                ->where('cart_products.cart_id', $data->cart_id)
                ->where('cart_products.is_delete', false)
                ->count();

            //xóa cart nếu trong cart k còn cartProduct
            if ($countCartProducts == 0) {
                DB::table('carts')
                    ->where('carts.id', $data->cart_id)
                    ->update(['carts.is_delete' => true]);
            }
            return response()->json(['success' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Có lỗi xảy ra vui lòng liên hệ quản trị viên']);
        }
    }
    public function cartCheckByProduct(Request $request)
    {
        $product_id = [];
        $quantityArr = [];
        $inventoryArr = [];
        $quantity = $request->quantity;
        $inventory = $request->inventory;
        $data['feeCheckOrder'] = 0;
        $dataQuantity = array_filter($request->ids, function ($item) {
            if ($item) {
                return $item;
            }
        });
        $arrQuantity = [];
        foreach ($quantity as $item) {
            $arrQuantity[$item['id']] = $item['quantity'];
        }
        foreach ($dataQuantity as $index => $item) {
            if ($item) {
                $product_id[$index] = $index;
                $quantityArr[$index] = $arrQuantity[$index];
            }
        }

        $data['cart_products'] = DB::table('cart_products')->select('*')->whereIn("cart_products.id", $product_id)->orderByDesc("created_at")
            ->get()->toArray();
        $data['totalMoney'] = 0;
        $data['quantity'] = 0;
        foreach ($data['cart_products'] as $item) {

            $data['totalMoney'] += $item->unit_price_vn * $quantityArr[$item->id];
            $data['quantity'] += $quantityArr[$item->id];
            if ($inventory[$item->cart_id]) {
                $data['feeCheckOrder'] += getFeeConfig(config('const.config.CHECKING_FEE'), $quantityArr[$item->id]);
            }
        }
        $data['feePurchase'] = getFeePurchase(
            config('const.config.PURCHASE_FEE'),
            $data['totalMoney']
        ) *  $data['totalMoney'] / 100;
        $data["feeAll"] = $data["feeCheckOrder"] + $data["feePurchase"];
        $data['money_deposite'] = ($data['totalMoney'] + $data['feeCheckOrder'] + $data['feePurchase']) / 2;
        return response()->json($data);
    }
    public function cartCheckout(Request $request)
    {
        try {
            $is_inventory = $request->inventory;
            $is_wood_packing = $request->wood_packing;
            $is_wood_working  = $request->woodWorking;
            $product_id = array_keys($request->ids);
            $product_id = [];
            foreach ($request->quantity as $it) {
                $product_id[$it['id']] = $it['quantity'];
            }
            $data['product_quantity'] = $product_id;
            $data['stock_product']  = [];

            $data['note'] = $request->note;
            $data['total_money_product'] = 0;
            $data['total_money_product_byShop'] = [];
            $data["feebyShop"] = [];
            $data['fee'] = [];
            $data['totalFee'] = 0;
            $data['request'] = json_encode($request->input());
            $data['total_money'] = 0;
            $data['money_deposit'] = 0;
            $data['money_deposite_byShop'] = [];
            $idShop = [];
            $purchase_fee = [];
            $invetory_fee = [];
            foreach ($request->data as $item) {
                $idShop[] = $item['id'];
            }
            $data['cart_products'] = DB::table('cart_products')
                ->select(
                    'cart_products.id',
                    'cart_products.product_name',
                    'cart_products.image',
                    'cart_products.properties',
                    'unit_price_cn',
                    'unit_price_vn',
                    'cart_id',
                    'stock'
                )
                ->whereIn("cart_products.id",  array_keys($data['product_quantity']))
                ->orderByDesc("created_at")
                ->get()->toArray();
            $data['cart_Shop'] = DB::table('carts')->whereIn('id', $idShop)->get();
            $totalByShopProduct = [];
            $total_quantity_byShop = [];
            $data['totalQuantityOrder'] = 0;
            foreach ($data['cart_Shop'] as $index => $item) {
                $totalByShopProduct[$item->id] = 0;
                $total_quantity_byShop[$item->id] = 0;
                foreach ($data['cart_products'] as $it) {

                    if ($item->id == $it->cart_id) {
                        $data['stock_product'][$it->id] = [
                            "",
                            ""
                        ];
                        if ($data['product_quantity'][$it->id] >= $it->stock) {
                            // return response()->json(["message" => ""]);
                            $data["stock_product"][$it->id] = [
                                "Chúng tôi sẽ cố gắng mua đủ số lượng sản phẩm quý khách yêu cầu, tuy nhiên việc này không được đảm bảo.",
                                "Sản phẩm tồn kho " . $it->stock
                            ];
                        }
                        $totalByShopProduct[$item->id] += $it->unit_price_vn * $data['product_quantity'][$it->id];
                        $total_quantity_byShop[$item->id] += $data['product_quantity'][$it->id];
                        $data['totalQuantityOrder'] += $data['product_quantity'][$it->id];
                    }
                }

                $purchase_fee[$item->id] = getFeePurchase(
                    config('const.config.PURCHASE_FEE'),
                    $totalByShopProduct[$item->id]
                ) *  $totalByShopProduct[$item->id] / 100;
                $data['fee'][$item->id] = (array)[
                    [
                        'name' => 'Tiền hàng',
                        'value' =>   $totalByShopProduct[$item->id]
                    ],
                    [
                        'name' => 'Phí mua hàng',
                        'value' => $purchase_fee[$item->id]
                    ]
                ];
                if ($is_inventory[$item->id]) {
                    $invetoryfeeItem = getFeeConfig(config('const.config.CHECKING_FEE'), $total_quantity_byShop[$item->id]);
                    $invetory_fee[$item->id] = $invetoryfeeItem *  $total_quantity_byShop[$item->id];
                    array_push($data['fee'][$item->id], (array) [
                        'name' => 'Phí kiểm hàng',
                        'value' => $invetory_fee[$item->id]
                    ]);
                }
                // dd($is_wood_packing,$is_wood_working);
                if ($is_wood_packing[$item->id]) {
                    array_push($data['fee'][$item->id], (array) [
                        'name' => 'Đóng gỗ riêng',
                        'value' => 0
                    ]);
                }
                if ($is_wood_working[$item->id]) {
                    array_push($data['fee'][$item->id], (array) [
                        'name' => 'Đóng gỗ ',
                        'value' => 0
                    ]);
                }
                // if()
                $inventorytotal = isset($invetory_fee[$item->id]) ? $invetory_fee[$item->id] : 0;
                $data['totalFee'] += +$purchase_fee[$item->id]  + $inventorytotal;
                $data["feebyShop"][$item->id] = 0;

                $data["feebyShop"][$item->id] += $purchase_fee[$item->id]  + $inventorytotal;
                $data['total_money_byShop'][$item->id] = $totalByShopProduct[$item->id] + $purchase_fee[$item->id]  + $inventorytotal;
            }

            foreach ($data['fee'] as $index => $value) {
                $data['money_deposite_byShop'][$index] = 0;
                foreach ($value as $vl) {
                    if ($vl) {
                        $data['total_money'] += $vl['value'];
                        $data['money_deposite_byShop'][$index] += $vl['value'] / 2;
                    }
                }
            }
            $data['money_deposite'] = $data['total_money'] / 2;

            return response()->json([
                'data'   => $data
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message'   => $th->getMessage()
            ], 500);
        }
    }

    public function cartCreate(Request $request)
    {
        // try {
        $deposite_money = $request->money_deposite;
        $data_order = $request->data;
        $input = [];
        $idShop  = [];
        $id_Address = $request->data['id_address'];

        foreach ($request['data']['data'] as $item) {
            $idShop[] = $item['id'];
        }
        foreach ($data_order["ids"] as $key => $value) {
            if ($value) {
                $input[$key] = $value;
            }
        }
        $inventory = $data_order['option']['inventory'];
        $wood_packing = $data_order['option']['goodWorking'];
        $separately_wood_packing = $data_order['option']['ownGood'];

        $checkedwoods = [];
        $checkedwoodPacking = [];
        $note = [];
        $inventory = [];
        foreach ($wood_packing as $key => $item) {
            if ($item) {
                $checkedwoods[$key] = $item;
            }
        }
        foreach ($separately_wood_packing as $key => $item) {
            if ($item) {
                $checkedwoodPacking[$key] = $item;
            }
        }
        foreach ($data_order['note'] as $key => $item) {
            if ($item) {
                $note[$key] = $item;
            }
        }
        foreach ($data_order["option"]["inventory"] as $key => $item) {
            $inventory[$key] = $item;
        }


        $quantityArray = [];
        $idProduct = [];

        foreach ($data_order["quantity"] as $key => $value) {
            foreach (array_keys($input) as $it) {

                if ($value && $it == $value["id"]) {
                    $quantityArray[$value["id"]] = $value["quantity"];
                    $idProduct[$key] = $value["id"];
                }
            }
        }
        $point_user = Auth()->user()->point;
        if ($deposite_money > $point_user) {
            return response()->json([
                'error' => true,
                'message'   => "Tài khoản không đủ vui lòng nạp thêm!"
            ], 500);
        }
        if (empty($input)) {
            return response()->json([
                'error' => true,
                'message'   => "Không có sản phẩm"
            ], 500);
        } else {
            // lấy ra những sản phẩm được chọn
            $keyInput = $idProduct;
        }
        // Lẫy dữ liệu cartProducts
        $cartProducts = DB::table('cart_products')
            ->select(
                'cart_products.id',
                'cart_products.user_id',
                'cart_products.source',
                'cart_products.cart_id',
                'cart_products.product_id',
                'cart_products.product_name',
                'cart_products.propertiesId',
                'cart_products.properties',
                'cart_products.price_cn',
                'cart_products.price',
                'cart_products.note',
                'cart_products.quantity_min',
                'cart_products.original_price',
                'cart_products.promotion_price',
                'cart_products.price_table',
                'cart_products.stock',
                'cart_products.url',
                'cart_products.image',
                'cart_products.image_detail',
                'carts.shop_id',
                'carts.shop_name',
                'carts.shop_url',
                'cart_products.unit_price_cn',
                'cart_products.unit_price_vn'
            )
            ->join('carts', 'cart_products.cart_id', 'carts.id')
            ->whereIn("cart_products.id", $keyInput)
            ->get()->toArray();
        //tao order
        $total_quantity = array_sum($quantityArray);
        $wood_packing_fee = 0;
        $separately_wood_packing_fee = 0;
        // foreach ($checkedwoods as $item) {
        //     if ($item) {
        //         $wood_packing_fee += getFeeConfigNumber(config('const.config.WOOD_FEE'));
        //     }
        // }
        // foreach ($checkedwoodPacking as $item) {
        //     if ($item) {
        //         $separately_wood_packing_fee += getFeeConfigNumber(config('const.config.OWN_WOOD_FEE'));
        //     }
        // }

        $Shop = CartModel::whereIn("id", $idShop)->get();
        // dd($inventory);
        foreach ($inventory as $item) {
            foreach ($item as $it) {
                if (isset($item)) {
                    if ($it['name'] == 'Phí kiểm hàng') {
                        $inventory_fee = getFeeConfig(config('const.config.CHECKING_FEE'), $total_quantity) * $total_quantity;
                    }
                }
            }
        }
        $dataShopInsert = [];
        $generateCode = new GenerateCode();
        $orderCode = $generateCode->generateCodeOrder();

        $order = OrderModel::create([
            'user_id' => Auth::id(),
            'partner_id' => 1,
            'order_status_id' => config('const.order_status.deposited'),
            'wood_packing_fee' => isset($wood_packing_fee) && $wood_packing_fee ? +$wood_packing_fee : 0,
            'separately_wood_packing_fee' => isset($separately_wood_packing_fee) && +$separately_wood_packing_fee
                ? $separately_wood_packing_fee : 0,
            'inventory_fee' => isset($inventory_fee) && $inventory_fee ? +$inventory_fee : 0,
            'deposit_amount' => - ($deposite_money),
        ]);
        foreach ($Shop as $key => $item) {
            $dataShopInsert[] = [
                'shop_id' => $item->shop_id,
                'shop_name' => $item->shop_name,
                'shop_url' => $item->shop_url,
                'order_id' => $order->id,
                'note' => isset($note[$item->id]) ? $note[$item->id] : "",
                'source' => $item->source
            ];
        }
        OrderDetail::insert($dataShopInsert);
        $total_price = 0;
        foreach ($cartProducts as $key => $value) {
            //tao orderProducts
            $orderProducts = OrderProductModel::create([
                'user_id' => Auth::id(),
                'partner_id' => 1,
                'order_id' => $order->id,
                'product_id' => $value->product_id,
                'source' => $value->source,
                'product_name' => $value->product_name,
                'propertiesId' => $value->propertiesId,
                'properties' => $value->properties,
                'price' => $value->unit_price_vn * $quantityArray[$value->id],
                'quantity_min' => $value->quantity_min,
                'price_table' => $value->price_table,
                'original_price' => $value->original_price,
                'promotion_price' => $value->promotion_price,
                'quantity_bought' => $quantityArray[$value->id],
                'stock' => $value->stock,
                'url' => $value->url,
                'image_link' => $value->image,
                'image_detail' => $value->image_detail,
                'order_status_id' => 1,
                'shop_id' => $value->shop_id
            ]);
            $total_price += $orderProducts->price;
        }
        $purchase_fee = getFeePurchase(
            config('const.config.PURCHASE_FEE'),
            $total_price
        ) * $total_price / 100;

        $order->purchase_fee = $purchase_fee;
        $order->order_code = $orderCode;
        $order->address_id = $id_Address['id'];
        $order->total_price = $total_price;
        $order->id_warehouse = $id_Address['region_id'];
        $order->save();
        $totalPriceOrder = $order->total_price + $order->total_price_order + $order->inventory_fee + $order->wood_packing_fee + $order->separately_wood_packing_fee;
        $remaining_amount = $totalPriceOrder - $deposite_money;
        DB::table('orders')->where('id', $order->id)->update([
            'remaining_amount' => $remaining_amount,
            'total_price_order' => $totalPriceOrder
        ]);
        // lấy cartId trùng với những sản phẩm được chọn trong cart
        $getCartId = DB::table('cart_products')
            ->select('cart_products.cart_id')
            ->whereIn('cart_products.id', $keyInput)
            ->get();
        $carId = $getCartId;
        $cartId = [];
        foreach ($carId as $car) {
            $cartId[] = $car->cart_id;
        }
        // xóa cartId phẩm đã chọn
        DB::table('cart_products')
            ->whereIn("cart_products.id", $keyInput)
            ->update(['cart_products.is_delete' => true]);


        // tính số lượng sản phẩm trong cart
        $countCartProducts = DB::table('cart_products')
            ->select('cart_products.id', 'cart_products.cart_id')
            ->whereIn('cart_products.cart_id', $cartId)
            ->where('cart_products.is_delete', false)
            ->count();
        //xóa cart nếu trong cart k còn cartProduct
        if ($countCartProducts === 0) {
            DB::table('carts')
                ->whereIn('carts.id', $cartId)
                ->update(['carts.is_delete' => true]);
        }
        //tao packet
        PacketModel::create([
            'user_id' => Auth::id(),
            'partner_id' => 1,
            'order_id' =>  $order->id,
            'status' => 0,
            'price_unit' => config('const.price.price_unit'),
            'opt_order_checking' => isset($inventory) ? true : false,
            'opt_wood_packing' => collect($checkedwoods)->count() != 0 ? true : false,
            'opt_separate_wood_packing' => collect($checkedwoodPacking)->count() != 0 ? true : false,
        ]);
        // checkedwoodPacking
        // checkedwoods
        // sub point user and create transaction
        User::where('id', Auth::id())
            ->update([
                'point' => $point_user - $deposite_money
            ]);
        TransactionModel::create([
            'partner_id' => 1,
            'user_id' => Auth::id(),
            'order_id' =>  $order->id,
            'type_id' => config('const.type_transaction.deposited'),
            'content' => 'Đặt cọc cho đơn hàng ' . $orderCode,
            'point' => -$deposite_money,
        ]);
        $log = new AppLogController();
        $log->insertLog(Auth::id(), "Đặt đơn hàng $orderCode thành công");
        // Send noti in telegram group
        sendMessageTeleGroup($orderCode);
        return response()->json([
            'error' => false,
            'message'   => "Đặt hàng Thành công",
            'data' => ''
        ], 200);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'error' => true,
        //         'message'   => $th->getMessage()
        //     ], 500);
        // }
    }
    public function getAddressUser($id)
    {
        $address = DB::table('user_addresses')->where('user_id', $id)->get();

        return response()->json($address);
    }
    public function deleteAllCart(Request $request)
    {
        try {
            $data =  CartProductModel::whereIn('id', $request->Id)->get();
            CartProductModel::whereIn('id', $request->Id)->update(['is_delete' => true]);
            $countCartProducts = DB::table('cart_products')
                ->select('cart_products.id', 'cart_products.cart_id')
                ->whereIn('cart_products.cart_id', $request->Id)
                ->where('cart_products.is_delete', false)
                ->count();

            $dataCart = [];
            foreach ($data as $item) {
                $dataCart[] = $item->cart_id;
            }
            //xóa cart nếu trong cart k còn cartProduct
            DB::table('carts')
                ->whereIn('carts.id', $dataCart)
                ->update(['carts.is_delete' => true]);
            return response()->json(['success' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Có lỗi xảy ra vui lòng liên hệ quản trị viên']);
        }
    }
}
