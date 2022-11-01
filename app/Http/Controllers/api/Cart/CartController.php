<?php

namespace App\Http\Controllers\api\Cart;

use App\Http\Controllers\Controller;
use App\Models\CartProductModel;
use App\Models\OrderModel;
use App\Models\OrderProductModel;
use App\Models\PacketModel;
use App\Models\TransactionModel;
use App\Models\User;
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
            CartProductModel::findOrFail($id);
            CartProductModel::where('id', $id)
                ->update(['is_delete' => 1]);
            return response()->json(['success' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Có lỗi xảy ra vui lòng liên hệ quản trị viên']);
        }
    }

    public function cartCheckout(Request $request)
    {
        // try {
        $is_inventory = $request->inventory ? true : false;
        $product_id = array_keys($request->ids);
        $data['product_quantity'] = $request->quantity;
        $data['note'] = $request->note;
        $data['total_money_product'] = 0;
        $data['total_money_product_byShop'] = [];
        $data['fee'] = [];
        $data['request'] = json_encode($request->input());
        $data['total_money'] = 0;
        $data['money_deposit'] = 0;
        $idShop = [];
        $purchase_fee = [];


        $data['cart_products'] = DB::table('cart_products')
            ->select(
                'cart_products.id',
                'cart_products.product_name',
                'cart_products.image',
                'cart_products.properties',
                'unit_price_cn',
                'unit_price_vn',
                'cart_id'
            )
            ->whereIn("cart_products.id", $product_id)
            ->orderByDesc("created_at")
            ->get()->toArray();


        // dd($data['cart_products'][0]->unit_price_vn);
        // dd([$data['cart_products'][0]->id]);




        $data['cart_Shop'] = DB::table('carts')->whereIn('id', $idShop)->get();
        $totalByShopProduct = [];
      
        foreach ($data['cart_Shop'] as $index => $item) {

            $idShop[] = $item->id;
            $totalByShopProduct[$item->id] = 0;
            foreach ($data['cart_products'] as $it) {
                if ($item['id'] == $it->cart_id) {
                    $totalByShopProduct[$item->id] += $it->unit_price_vn * $data['product_quantity'][$it->id];
                    $data['total_money_product_byShop'][$item->id] = $totalByShopProduct[$item['id']];
                }
            }
            // foreach($data['cart_products'] as $item){

            // }
            // dd($data['cart_products'],$idShop);
            array_push($data['fee'], (object) ([
                'name' => 'Tổng tiền hàng',
                'value' => $data['total_money_product_byShop']
            ]));
            if ($is_inventory) {
                $total_quantity = array_sum(
                    $data['product_quantity']
                );
                $invetory_fee = getFeeConfig(config('const.config.CHECKING_FEE'), $total_quantity);
                array_push($data['fee'], (object) ([
                    'name' => 'Phí kiểm hàng',
                    'value' => $invetory_fee * $total_quantity
                ]));
            }
            $purchase_fee[$item->id] = getFeePurchase(
                config('const.config.PURCHASE_FEE'),
                $data['total_money_product_byShop'][$item->id]
            ) *  $data['total_money_product_byShop'][$item->id] / 100;
            $data['fee'][$item->id] = (array)[
                [
                    'name' => 'Phí mua hàng',
                    'value' => $purchase_fee[$item->id]
                ], [
                    'name' => 'Phí cố định',
                    'value' => 5000
                ]
            ];
        }
        foreach ($data['fee'] as $value) {
            // dd($value);
            foreach ($value as $vl) {
                if ($vl) {
                    $data['total_money'] += $vl;
                }
            }
        }
        $data['money_deposite'] = $data['total_money'] / 2;

        return response()->json([
            'data'   => $data
        ], 200);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'error' => true,
        //         'message'   => $th->getMessage()
        //     ], 500);
        // }
    }

    public function cartCreate(Request $request)
    {
        $deposite_money = $request->money_deposite;
        $data_order = $request->data;
        $input = [];
        foreach ($data_order["ids"] as $key => $value) {
            if ($value) {
                $input[$key] = $value;
            }
        }
        $inventory = isset($data_order["inventory"]) ? true : false;
        $wood_packing = true;
        $separately_wood_packing = false;
        if (isset($data_order->opt_wood_packing)) {
            $wood_packing = false;
            $separately_wood_packing = true;
        }
        $note = $data_order["note"] ? $data_order["note"] : '';
        $quantityArray = [];
        foreach ($data_order["quantity"] as $key => $value) {
            $quantityArray[$key] = $value;
        }
        $point_user = Auth()->user()->point;
        if ($deposite_money > $point_user) {
            return response()->json([
                'error' => true,
                'message'   => "Tài khoản không đủ vui lòng nạp thêm!"
            ], 500);
        }
        if ($input === null) {
            return response()->json([
                'error' => true,
                'message'   => "Không có sản phẩm"
            ], 500);
        } else {
            // lấy ra những sản phẩm được chọn
            $keyInput = array_keys($input);
        }
        // dd($keyInput);
        // Lẫy dữ liệu cartProducts
        $cartProducts = DB::table('cart_products')
            ->select(
                'cart_products.id',
                'cart_products.user_id',
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
        // if ($wood_packing) {
        //     $wood_packing_fee = getFeeConfigNumber(config('const.config.wood_fee'));
        // }
        // if ($separately_wood_packing) {
        //     $separately_wood_packing_fee = getFeeConfigNumber(config('const.config.own_wood_fee'));
        // }
        if ($inventory) {
            $inventory_fee = getFeeConfig(config('const.config.CHECKING_FEE'), $total_quantity) * $total_quantity;
        }
        $order = OrderModel::create([
            'user_id' => Auth::id(),
            'partner_id' => 1,
            'order_status_id' => config('const.order_status.deposited'),
            'shop_id' => $cartProducts[0]->shop_id,
            'shop_name' => $cartProducts[0]->shop_name,
            'shop_url' => $cartProducts[0]->shop_url,
            'wood_packing_fee' => isset($wood_packing_fee) && $wood_packing_fee ? $wood_packing_fee : 0,
            'separately_wood_packing_fee' => isset($separately_wood_packing_fee) && $separately_wood_packing_fee
                ? $separately_wood_packing_fee : 0,
            'inventory_fee' => isset($inventory_fee) && $inventory_fee ? $inventory_fee : 0,
            'deposit_amount' => - ($deposite_money),
            'note' => $note,
        ]);
        $items_price_vn = 0;
        foreach ($cartProducts as $key => $value) {
            //tao orderProducts
            $orderProducts = OrderProductModel::create([
                'user_id' => Auth::id(),
                'partner_id' => 1,
                'order_id' => $order->id,
                'product_id' => $value->product_id,
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
            ]);
            $items_price_vn += $orderProducts->price;
        }
        $purchase_fee = getFeePurchase(
            config('const.config.PURCHASE_FEE'),
            $items_price_vn
        ) * $items_price_vn / 100;
        $order->items_price_vnd = $items_price_vn;
        $order->purchase_fee = $purchase_fee;
        $order->save();

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

        // xóa sản phẩm đã chọn
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
            'order_id' => $order->id,
            'status' => 0,
            'price_unit' => config('const.price.price_unit'),
            'opt_order_checking' => $inventory,
            'opt_wood_packing' => $wood_packing,
            'opt_separate_wood_packing' => $separately_wood_packing,
        ]);

        // sub point user and create transaction

        User::where('id', Auth::id())
            ->update([
                'point' => $point_user - $deposite_money
            ]);
        TransactionModel::create([
            'partner_id' => 1,
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'type_id' => config('const.type_transaction.deposited'),
            'content' => 'Đặt cọc cho đơn hàng ' . formatId($order->id, 4),
            'point' => -$deposite_money,
        ]);

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
}
