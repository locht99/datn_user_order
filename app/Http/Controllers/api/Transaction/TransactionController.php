<?php

namespace App\Http\Controllers\api\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Entityes\GetTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    
    public function getTransaction(){
        
        $getTransaction = new GetTransaction();
        $getTransactions = $getTransaction->getTransactions();
        return response()->json([
            'status' => 200,
            'data' => [
                'getTransactions' => $getTransactions,
            ]
        ],200);
    }
}
