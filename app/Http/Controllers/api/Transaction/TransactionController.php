<?php

namespace App\Http\Controllers\api\Transaction;

use App\Http\ConfigPayment\ConfigPaymentMomo;
use App\Http\Controllers\Controller;
use App\Http\Entityes\GetTransaction;
use App\Http\Transaction\Transaction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    private $getTransaction;

    public function __construct()
    {
        $this->getTransaction = new GetTransaction();
    }

    public function getTransaction()
    {

        $getTransaction = new GetTransaction();
        $transactions = $getTransaction->getTransactions();
        return response()->json($transactions);
    }
    public function getTypeTransaction()
    {
        $typeTransaction = $this->getTransaction->getTypeTransactions();
        return response()->json($typeTransaction);
    }
    public function getTypePayment()
    {
        $typePayment = $this->getTransaction->getTypePayment();
        return response()->json($typePayment);
    }
    public function createTransaction(Request $request)
    {
        $transaction = new Transaction();
        $ConfigMomo = new ConfigPaymentMomo();

        $params = [
            'orderCodeResponse' => $request->orderCodeResponse,
            'amount' => $request->amount,
            'storeId' => $request->storeId,
            'OrderInfo' => $request->OrderInfo,
            'typePayment' => $request->typePayment,
            'extraData' => '',
            'typeTransaction' => $request->typeTransaction,
        ];
        $data = $transaction->createTransaction($params);
        return response()->json($data);
    }
  
    public function sendTransaction(Request $request)
    {
    
        $host = url()->current();
        $domain =  parse_url($host);
        $resultDomain = $domain['scheme'] . '://' . $domain['host'];
        $transaction = new Transaction();
        $transaction->sendTransactions($request->all());
        return redirect($resultDomain.':8002/transaction/create');

    }
    public function fetchTransaction()
    {
       $transaction = new Transaction();
       $data = $transaction->fetchTransactions();
       return response()->json($data);
    }
}
