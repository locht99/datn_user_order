<?php

namespace App\Http\Transaction;

use App\Http\ConfigPayment\ConfigPaymentMomo;
use App\Http\Entityes\GetTransaction;
use App\Models\TransactionModel;
use App\Events\TransactionSent;
use App\Http\Controllers\api\Log\AppLogController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Transaction
{
    protected $ConfigPaymentMomo;
    protected $data;
    public function __construct()
    {
        $this->ConfigPaymentMomo = new ConfigPaymentMomo();
    }
    public function typeBanking()
    {
        $res = ['success' => true, 'result' => [], 'message' => 200];
        try {
            $data = DB::table('banking')->get();
            $res['result'] = $data;
        } catch (\Throwable $th) {
            $res['message'] = 440;
            $res['message'] = false;
        }
        return response()->json($res);
    }
    public function getTypeTransactionItem($id)
    {
        $item = DB::table('type_transactions')->where('id', $id)->first();
        return $item;
    }
    public function createTransaction($request)
    {
        // dd($request);
        // $dataBanking = DB::table('banking')->get();
        $entityes = new GetTransaction();
        $orderCodeResponse = $request['orderCodeResponse'] . date("his");
        $amount = +$request['amount'];
        $storeId = $request['storeId'];
        $OrderInfo = $request['OrderInfo'];
        $typePayment = $request['typePayment'];
        $typeTransaction = $request['typeTransaction'];
        $itemId = $this->getTypeTransactionItem($typeTransaction);

        $content = $itemId->type_name . " " . $request['orderCodeResponse'];
        $this->data = $request;


        switch ($typePayment) {
            case 'Momo':
                $paramsPayment = [
                    'orderCodeResponse' => $orderCodeResponse,
                    'extraData' => '',
                    'amount' => $amount,
                    'StoreId' => $storeId,
                    'OrderInfo' => $content,
                    'type_id' => $itemId->id
                ];
                $data = $this->ConfigPaymentMomo->createPaymentMomo($paramsPayment);
                return $data;
                break;
            default:
                # code...
                break;
        }
    }
    public function checkOrCreateTransaction()
    {
    }
    public function fetchTransactions()
    {
        return TransactionModel::with("user")->get();
    }
    public function sendTransactions($request)
    {
        $res = ['success' => false, 'data' => $request, 'message' => $request];
        $content = $request['orderInfo'];
        $itemOrderId = DB::table('history_transaction_momo')->where('OrderId', $request['orderId'])->first();
        if ($request['resultCode'] == 0) {
            $params = [
                'partner_id' => 1,
                'user_id' => $itemOrderId->user_id,
                'order_id' => 0,
                'type_id' => $itemOrderId->type_id,
                'content' => $content,
                'point' => $request['amount'],
                'code_transaction' => $itemOrderId->OrderId
            ];
            $data = TransactionModel::create($params);
            $res['success'] = true;
            $res['data'] = $data;
            $res['message'] = $request;

            $user = User::find($itemOrderId->user_id);
            $user->point = $user->point += $request['amount'];
            $user->save();
            $log = new AppLogController();
            $log->insertLog($itemOrderId->user_id, "Nạp số tiền" . $request["amount"] . 'vào tài khoản');
        }
        event(new TransactionSent($res, $itemOrderId->user_id));
        // $transactions= $user->messages()->create
        return "Successfully";
    }
}
