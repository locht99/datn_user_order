<?php

namespace App\Http\Controllers\api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Entityes\GetCartEntity;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $getCartEntity;

    public function __construct()
    {
        $this->getCartEntity = new GetCartEntity;
    }

    public function getShopCart(){

        $getCarts = $this->getCartEntity->getCarts();

        return response()->json([
            'status' => 200,
            'data' => [
                'getCarts' => $getCarts,
            ]
        ],200);

    }


}
