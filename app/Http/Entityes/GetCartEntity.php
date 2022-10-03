<?php

namespace App\Http\Entityes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GetCartEntity extends Controller
{
    public function getCarts(){

        $getCarts = DB::table('carts')
            ->where('user_id', auth()->user()->id)
            ->where('is_delete', 0)
            ->orderBy('created_at', 'DESC')
            ->select('id as cart_id', 'source', 'shop_name', 'shop_url', 'total_price', 'created_at')
            ->get()
            ->map( function ($getCart) {

                $getCart->cart_products = DB::table('cart_products')
                    ->where('cart_id', $getCart->cart_id)
                    ->where('is_delete', 0)
                    ->orderBy('created_at', 'DESC')
                    ->select('source', 'product_id', 'product_name', 'propertiesId', 'properties', 'price_cn', 'price', 'original_price', 'promotion_price', 'quantity', 'quantity_min', 'url', 'image', 'created_at')
                    ->get();

                return $getCart;
            });

        return $getCarts;
    }
}