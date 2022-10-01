<?php

namespace App\Http\Entityes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GetOrderEntity extends Controller
{
    public function oderProducts()
    {

        $oderProducts = DB::table('order_products')
            ->orderBy('created_at', 'DESC')
            ->where('user_id', auth()->user()->id)
            ->select('id', 'order_id', 'product_name', 'quantity_bought', 'order_status_id')
            ->get()->map(function ($oderProduct) {
                $oderProduct->status_name = DB::table('order_statuses')
                    ->where('id', $oderProduct->order_status_id)
                    ->pluck('status_name')
                    ->join('order_statuses', 'orders.order_status_id', 'order_statuses.id');
                return $oderProduct;
            });

        return $oderProducts;
    }

    public function getCartNotifications()
    {

        $getCartNotifications = DB::table('carts')
            ->where('user_id', auth()->user()->id)
            ->select('created_at', 'id')
            ->get();

        return $getCartNotifications;
    }

    public function getOrderNotifications()
    {

        $getOrderNotifications = DB::table('orders')
            ->where('user_id', auth()->user()->id)
            ->select('created_at', 'id')
            ->get();

        return $getOrderNotifications;
    }

    public function filterStatus($source)
    {

        $filterStatus = DB::table('order_statuses')
            ->select('id as order_status_id', 'status_name')
            ->get()
            ->map(function ($countOrder) use ($source) {
                $countOrder->count_order_product = DB::table('orders')
                    ->where('order_status_id', $countOrder->order_status_id)
                    ->where('user_id', auth()->user()->id)
                    ->when($source, function ($query, $source) {

                        $query->whereIn('source', $source);
        
                    }, function ($query) {
        
                        $sources = DB::table('orders')->select('source')->distinct();
                        $query->whereIn('source',$sources);
        
                    })
                    ->select('id', 'source')
                    ->get()->count();
                return $countOrder;
            });

        return $filterStatus;
    }

    public function countStatusConfirmation(){

        $countStatusConfirmation = DB::table('orders')
            ->where('order_status_id', 9)
            ->where('user_id', auth()->user()->id)
            ->get()
            ->count();

        return $countStatusConfirmation;

    }

    public function filterDataOder($source, $order_status_id, $search){

        $filterDataOderProduct = DB::table('orders')
            ->where('user_id', auth()->user()->id)
            ->when($search, function ($query, $search) {

                $query->where('source', 'like', '%'.$search.'%');

            }, function ($query) use ($source, $order_status_id) {

                $query->when($source, function ($query, $source) {

                    $query->whereIn('source', $source);
    
                }, function ($query) {
    
                    $sources = DB::table('orders')->select('source')->distinct();
                    $query->whereIn('source',$sources);
    
                })->when($order_status_id, function ($query, $order_status_id) {
    
                    $query->where('order_status_id', $order_status_id); 
    
                }, function ($query) {
    
                    $order_statuses = DB::table('order_statuses')->pluck('id');
                    $query->whereIn('order_status_id',$order_statuses);
    
                });

            })->get()->map(function ($oderStatus) {
                $oderStatus->status_name = DB::table('order_statuses')
                    ->where('id', $oderStatus->order_status_id)
                    ->pluck('status_name')
                    ->join('orders', 'order_statuses.id', 'orders.order_statuses_id');
                return $oderStatus;
            });

        return $filterDataOderProduct;

    }
}
