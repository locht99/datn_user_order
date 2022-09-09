<?php

namespace App\Http\Controllers\api\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrder(){
        return response()->json("Tra ve order ne", 200);
    }
}
