<?php

namespace App\Http\Entityes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GetOrderEntity extends Controller
{
    public function oderProducts(){

        $oderProducts = DB::table('order_products')
            ->orderBy('created_at', 'DESC')
            ->where('user_id', auth()->user()->id)
            ->select('id','order_id' ,'product_name' ,'quantity_bought')
            ->get()->map( function($oderProduct)
            {
                $oderProduct->order_status_id = DB::table('orders')
                    ->where('id', $oderProduct->order_id)
                    ->pluck('order_status_id')
                    ->join('order_statuses', 'orders.order_status_id', 'order_statuses.id');

                $oderProduct->status_name = DB::table('order_statuses')
                    ->where('id', $oderProduct->order_status_id)
                    ->pluck('status_name')
                    ->join('order_statuses', 'orders.order_status_id', 'order_statuses.id');
                return $oderProduct;
            });

        return $oderProducts;
    }

    public function getCartNotifications(){

        $getCartNotifications = DB::table('carts')
            ->where('user_id', auth()->user()->id)
            ->select('created_at', 'id')
            ->get();

        return $getCartNotifications;
    }

    public function getOrderNotifications(){

        $getOrderNotifications = DB::table('orders')
            ->where('user_id', auth()->user()->id)
            ->select('created_at', 'id')
            ->get();

        return $getOrderNotifications;
    }

}
