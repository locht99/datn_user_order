<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ExtensionController extends Controller
{
    /**
     * @throws ValidationException
     */
//     public function login(Request $request): object
//     {
//         $validator = Validator::make($request->all(), [
//             "username" => "required",
//             "password" => "required"
//         ], [
//             "username.required" => "Tài khoản không được để trống",
//             "password.required" => "Mật khẩu không được để trống",
//         ]);
//         if ($validator->fails()) {
//             return response()->json([
//                 'message' => $validator->errors()->first()
//             ], ResponseAlias::HTTP_BAD_REQUEST);
//         }

//         $credentials = request(['username', 'password']);
//         if (!Auth::attempt($credentials)) {
//             return response()->json([
//                 'message' => 'Tài khoản hoặc mật khẩu không đúng.'
//             ], ResponseAlias::HTTP_UNAUTHORIZED);
//         }

//         $user = Auth::user();
//         $tokenResult = $user->createToken('Personal Access Token ' . Str::random(10));
//         $token = $tokenResult->token;
// //        if ($request->remember_me) {
// //            $token->expires_at = Carbon::now()->addWeeks(10);
// //        }
//         $token->save();

//         return response()->json([
//             'access_token' => $tokenResult->accessToken,
//             'token_type' => 'Bearer',
//             'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
//         ]);
    // }

    public function createCart(Request $request)
    {
        // $uid = auth('api')->id();
        $data = isset($request->all()["data"]) ? (array)json_decode($request->all()["data"]) : array();
        
        return response()->json($data);
        // Validate
        // $validator = Validator::make($data, [
        //     "source" => "required",
        //     "seller_id" => "required",
        //     "item_id" => "required",
        // ], [
        //     "seller_id.required" => "Không tìm thấy Shop Id",
        // ]);
        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => $validator->errors()->first()
        //     ], ResponseAlias::HTTP_BAD_REQUEST);
        // }
        // // Check cart
        // $cart = Cart::where("user_id", $uid)
        //     ->where("shop_id", $data["seller_id"])
        //     ->where("is_delete", false)
        //     ->first();
        // // Create cart
        // if (!$cart) {
        //     $cart_data = [
        //         "partner_id" => 1,
        //         "user_id" => $uid,
        //         "source" => $data["source"],
        //         "shop_id" => $data["seller_id"],
        //         "shop_name" => $data["seller_nick"] ?? null,
        //         "shop_url" => null,
        //         "total_price" => 0,
        //     ];
        //     $cart = Cart::create($cart_data);
        // }
        // // Check cart product
        // $cart_product = CartProduct::where("user_id", $uid)
        //     ->where("cart_id", $cart->id)
        //     ->where("product_id", $data["item_id"])
        //     ->where("is_delete", false)
        //     ->first();
        // $quantity = $data["amount"] ?? 0;
        // if ($cart_product) {
        //     $quantity += $cart_product->quantity;
        // }
        // $cart_product_data = [
        //     "cart_id" => $cart->id,
        //     "partner_id" => 1,
        //     "user_id" => $uid,
        //     "source" => $data["source"],
        //     "product_id" => $data["item_id"] ?? null,
        //     "product_name" => $data["item_title"] ?? null,
        //     "propertiesId" => $data["properties_id"] ?? null,
        //     "properties" => $data["properties_name"] ?? null,
        //     "price_cn" => $data["original_price"] ?? 0,
        //     "price" => 0,
        //     "original_price" => $data["original_price"] ?? 0,
        //     "promotion_price" => $data["promotion_price"] ?? 0,
        //     "price_table" => $data["prices_config"] ?? null,
        //     "quantity" => $quantity,
        //     "quantity_min" => 0,
        //     "stock" => $data["stock"] ?? 0,
        //     "url" => $data["item_link"] ?? null,
        //     "image" => $data["image_link"] ?? null,
        //     "image_detail" => null,
        //     "note" => null,
        //     "unit_price_cn" => 0,
        //     "unit_price_vn" => 0,
        // ];
        // // Create or update cart product
        // if ($cart_product) {
        //     $cart_product->update($cart_product_data);
        // } else {
        //     CartProduct::create($cart_product_data);
        // }
        return response()->json([
            'message' => "Đã thêm sản phẩm vào giỏ hàng"
        ], ResponseAlias::HTTP_OK);
    }
}
