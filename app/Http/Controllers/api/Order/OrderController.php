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
            'oderProducts' => $oderProducts,
            'getCartNotifications' => $getCartNotifications,
            'getOrderNotifications' => $getOrderNotifications,
        ]);
    }
}
