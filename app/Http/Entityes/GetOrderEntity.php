<?php

namespace App\Http\Entityes;

use App\Http\Controllers\Controller;
use App\Models\OrderModel;
use Illuminate\Support\Facades\DB;

class GetOrderEntity extends Controller
{
    public function oderProducts()
    {

        $oderProducts = DB::table('order_products')
            ->join('orders', 'orders.id', '=', 'order_products.order_id')
            ->orderBy('order_products.created_at', 'DESC')
            ->where('order_products.user_id', auth()->id())
            ->select(
                'order_products.id', 
                'orders.order_code', 
                'order_products.product_name',
                'order_products.url',
                'order_products.image_link',
                'order_products.quantity_bought', 
                'orders.order_status_id')
            ->get()->map(function ($oderProduct) {
                $oderProduct->status_name = DB::table('order_statuses')
                    ->where('id', $oderProduct->order_status_id)
                    ->pluck('status_name')
                    ->join('order_statuses', 'orders.order_status_id', 'order_statuses.id');
                return $oderProduct;
            });

        return $oderProducts;
    }

    public function notifications(){
        $notifications = DB::table('notifications')
            ->where('is_active', 1)
            ->get();
        return $notifications;
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

    public function filterDataOder($order_status_id, $search){
        $filterDataOderProduct = OrderModel::join('order_statuses', 'orders.order_status_id', 'order_statuses.id')
            ->select('orders.id', 'orders.order_status_id', 'orders.order_code', 'order_statuses.status_name', 'orders.updated_at')
            ->withCount('product')
            ->where('orders.user_id', auth()->user()->id)
            ->when($search, function ($query, $search) {

                $query->where('orders.order_code', 'like', '%'.$search.'%');

            }, function ($query) use ($order_status_id) {

                $query->when($order_status_id, function ($query, $order_status_id) {
    
                    $query->whereIn('orders.order_status_id', $order_status_id); 
    
                }, function ($query) {
    
                    $order_statuses = DB::table('order_statuses')->pluck('id');
                    $query->whereIn('orders.order_status_id',$order_statuses);
    
                });

            })->orderBy('orders.updated_at', 'DESC')->paginate(7);

        return $filterDataOderProduct;

    }

    public function orderProductDetail($order_id){
        $order_products = DB::table('order_products')
            ->join('order_statuses', 'order_products.order_status_id', 'order_statuses.id')
            ->select('order_statuses.status_name', 'order_products.product_name', 'order_products.source', 'order_products.properties', 'order_products.quantity_bought', 'order_products.promotion_price', 'order_products.original_price', 'order_products.price', 'order_products.image_link', 'order_products.url')
            ->where('order_products.order_id', $order_id)
            ->where('order_products.user_id', auth()->user()->id)
            ->get();
        $order_product_detail = [
            'order_products' => $order_products,
            'order'          => $this->orderDetail($order_id)->select('order_code')->first(),
        ];
        return $order_product_detail;
    }

    public function orderInfo($order_id){

        $order_info = [
            'source' => $this->listSource($order_id),
            'order'  => $this->orderDetail($order_id)->select('deposit_amount', 'order_code', 'total_price', 'total_price_order', 'express_shipping_fee')->first(),
            'address'=> $this->orderDetail($order_id)->join('user_addresses', 'orders.address_id', 'user_addresses.id')->select('user_addresses.*')->first(),
        ];
        return $order_info;
    }

    public function orderDetail($order_id){
        $data = DB::table('orders')
            ->where('orders.id', $order_id);
        return $data;
    }

    public function trackingStatus($order_id){
        $data = DB::table('tracking_statuses')
            ->where('order_id', $order_id);
        return $data;
    }

    public function listSource($order_id){
        $data = DB::table('order_detail')
            ->where('order_id', $order_id)
            ->groupBy('order_detail.source')
            ->select('order_detail.source')->get();
        return $data;
    }

    public function historyStatusDetail($order_id){
        $tracking_status = DB::table('tracking_statuses')
            ->where('order_id', $order_id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $statusDetail = [
            'order'        => $this->orderDetail($order_id)->select('order_code')->first(),
            'tracking_status' => $tracking_status,
        ];
        return $statusDetail;
    }
}
