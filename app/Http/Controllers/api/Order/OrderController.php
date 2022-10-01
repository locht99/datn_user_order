<?php

namespace App\Http\Controllers\api\Order;

use App\Http\Controllers\Controller;
use App\Http\Entityes\GetOrderEntity;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrder(){

        $getOrderEntity = new GetOrderEntity();
    
        $oderProducts = $getOrderEntity->oderProducts();
        $getCartNotifications = $getOrderEntity->getCartNotifications();
        $getOrderNotifications = $getOrderEntity->getOrderNotifications();

        return response()->json([
            'status' => 200,
            'data' => [
                'oderProducts'          => $oderProducts,
                'getCartNotifications'  => $getCartNotifications,
                'getOrderNotifications' => $getOrderNotifications,
            ]
        ],200);
    }

    public function getFilterOrder(){
        $source = ['1688', 'tmall'];
        $order_status_id = '1';
        $search = '1688';
        $getOrderEntity = new GetOrderEntity();

        $filterStatus = $getOrderEntity->filterStatus($source);
        $countStatusConfirmation = $getOrderEntity->countStatusConfirmation();
        $filterDataOder = $getOrderEntity->filterDataOder($source ,$order_status_id, $search);
        return response()->json([

            'status' => 200,
            'data' => [
                'filterStatus'            => $filterStatus,
                'countStatusConfirmation' => $countStatusConfirmation,
                'filterDataOder'   => $filterDataOder,
            ]

        ],200);
    }

}
