<?php

namespace App\Http\Controllers\api\Order;

use App\Http\Controllers\Controller;
use App\Http\Entityes\GetOrderEntity;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $getOrderEntity;

    public function __construct()
    {
        $this->getOrderEntity = new GetOrderEntity();
    }
    public function getOrder(){

        $oderProducts = $this->getOrderEntity->oderProducts();
        $getCartNotifications = $this->getOrderEntity->getCartNotifications();
        $getOrderNotifications = $this->getOrderEntity->getOrderNotifications();

        return response()->json([
            'status' => 200,
            'data' => [
                'oderProducts'          => $oderProducts,
                'getCartNotifications'  => $getCartNotifications,
                'getOrderNotifications' => $getOrderNotifications,
            ]
        ],200);
    }

    public function getFilterOrder(Request $dataOder){

        $filterStatus = $this->getOrderEntity->filterStatus($dataOder->source);
        $countStatusConfirmation = $this->getOrderEntity->countStatusConfirmation();
        $filterDataOder = $this->getOrderEntity->filterDataOder($dataOder->order_status_id, $dataOder->search);
        return response()->json([

            'status' => 200,
            'data' => [
                'filterStatus'            => $filterStatus,
                'countStatusConfirmation' => $countStatusConfirmation,
                'filterDataOder'          => $filterDataOder,
            ]

        ],200);
    }

    public function createOrder(Request $dataOrder){

        
    }

    public function orderInfoes(Request $data){
        $orderInfo = $this->getOrderEntity->orderInfo($data->order_id);
        return response()->json([

            'status' => 200,
            'data' => [
                'orderInfo' => $orderInfo,
            ]

        ],200);
    }

    public function orderDetail($order_id){
        if($order_id){
            $order = $this->getOrderEntity->orderDetail($order_id)->first();
            if(is_null($order)){
                return response()->json([

                    'status' => 404,
                    'data' => [
                        'message' => 'The requested URL was not found on this server!',
                    ]
                    
                ],200);
            }
            $orderDetail = $this->getOrderEntity->orderProductDetail($order_id);
            return response()->json([

                'status' => 200,
                'data' => [
                    'orderDetail' => $orderDetail,
                ]

            ],200);
        }
        
    }
}