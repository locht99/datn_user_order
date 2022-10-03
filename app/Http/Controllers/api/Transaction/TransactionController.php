<?php

namespace App\Http\Controllers\api\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Entityes\GetTransaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $getTransaction;

    public function __construct()
    {
        $this->getTransaction = new GetTransaction();
    }
    
    public function getTransaction(){
        
       
        $getTransactions = $this->getTransaction->getTransactions();
        return response()->json([
            'status' => 200,
            'data' => [
                'getTransactions' => $getTransactions,
            ]
        ],200);
    }
}
