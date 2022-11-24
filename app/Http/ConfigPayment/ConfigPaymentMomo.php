<?php

namespace App\Http\ConfigPayment;

use App\Http\Controllers\Controller;
use App\Models\ConfigPayment\ConfigPayment;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConfigPaymentMomo extends Controller
{
    protected $endpoint;
    protected $partnerCode;
    protected $accessKey;
    protected $serectKey;
    protected $redirectUrl;
    protected $ipnUrl;
    protected $extraData;
    protected $dataPayment;
    protected $ConfigPayment;
    public function __construct()
    {
        $host = url()->current();
        $domain =  parse_url($host);
        $resultDomain = $domain['scheme'] . '://' . $domain['host'];
        $this->dataPayment = ConfigPayment::where('tenant_code', 'OrderVietTrung')->where('supplier', 'Momo')->first();
        $this->endpoint = $this->dataPayment->api_end_point;
        $this->partnerCode = $this->dataPayment->partnerCode;
        $this->accessKey = $this->dataPayment->access_key;
        $this->serectKey = $this->dataPayment->serec_key;
        $this->redirectUrl = $resultDomain . ':8000' . "/transaction/create";
        $this->ipnUrl = $resultDomain . ':8000' . "/transaction/create";
        $this->extraData = "";
    }
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function createPaymentMomo($request)
    {

        // dd($request->orderInfo);

        $data = $this->dataPayment;
        $this->ConfigPayment = $data;
        $endpoint =  $this->ConfigPayment->api_end_point . '/v2/gateway/api/create';
        $partnerCode = $this->ConfigPayment->partnerCode;
        $accessKey = $this->ConfigPayment->access_key;
        $secretKey = $this->ConfigPayment->serec_key;
        $orderCodeResponse = $request['orderCodeResponse'];
        $orderInfo = $request['OrderInfo'];
        $amount = +$request['amount'];
        $ipnUrl = route("getRequest");
        $redirectUrl = route("getRequest");
        $requestId = time() . "";
        $requestType = "captureWallet";
        $extraData = $request['extraData'] ? $request['extraData'] : "";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderCodeResponse . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            "partnerCode" => $partnerCode,
            "partnerName" => $this->ConfigPayment->tenant_code,
            "storeId" => "MomotestStore",
            "requestId" => $requestId,
            "amount" => $amount,
            "orderId" => $orderCodeResponse,
            "orderInfo" => $orderInfo,
            "redirectUrl" => $redirectUrl,
            "ipnUrl" => $ipnUrl,
            "lang" => "vi",
            "extraData" => $extraData,
            "requestType" => $requestType,
            "signature" => $signature
        );

        $params = [
            'amount' => $amount,
            'orderInfo' => $orderInfo,
            'orderType' => "momo_wallet",
            'resultCode' => 1,
            'message' => "Chưa thanh toán",
            'signature' => $signature,
            'user_id' => Auth::user()->id,
            'OrderId' => $orderCodeResponse,
            'type_id'=>$request['type_id']

        ];
        DB::table('history_transaction_momo')->insert($params);
        $result = Http::post($endpoint, $data);
        $jsonResult = json_decode($result, true);
        return $jsonResult;
    }
    public function checkQueryTransaction($request)
    {

        $response = '';
        $requestId = time() . "";
        $data = $this->dataPayment;
        $this->ConfigPayment = $data->data;
        $orderId = $request['OrderCode'];
        $rawHash = "accessKey=" . $this->ConfigPayment->access_key . "&orderId=" . $orderId . "&partnerCode=" . $this->ConfigPayment->partner_code . "&requestId=" . $requestId;
        $signature = hash_hmac("sha256", $rawHash, $this->ConfigPayment->serec_key);
        $requestType = '';
        $data = array(
            'partnerCode' => $this->ConfigPayment->partner_code,
            'requestId' => $requestId,
            'orderId' => $orderId,
            'requestType' => $requestType ? $requestType : '',
            'signature' => $signature,
            'lang' => 'vi'
        );
        $result =  Http::post($this->ConfigPayment->api_end_point . '/v2/gateway/api/query', json_encode($data));
        $jsonResult = json_decode($result, true);
        $response = json_encode($jsonResult, JSON_PRETTY_PRINT);

        if (!empty($result) && $jsonResult['resultCode'] == 0) {
            $partnerCode = $jsonResult["partnerCode"];
            $accessKey = $jsonResult["accessKey"];
            $requestId = $jsonResult["requestId"];
            $orderId = $jsonResult["orderId"];
            $errorCode = $jsonResult["errorCode"];
            $transId = $jsonResult["transId"];
            $amount = $jsonResult["amount"];
            $message = $jsonResult["message"];
            $localMessage = $jsonResult["localMessage"];
            $requestType = $jsonResult["requestType"];
            $payType = $jsonResult["payType"];
            $extraData = ($jsonResult["extraData"] ? $jsonResult["extraData"] : "");
            $m2signature = $jsonResult["signature"];

            $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&orderId=" . $orderId . "&errorCode=" . $errorCode . "&transId=" . $transId . "&amount=" . $amount . "&message=" . $message . "&localMessage=" . $localMessage . "&requestType=" . $requestType . "&payType=" . $payType . "&extraData=" . $extraData;
            $response = $partnerSignature = hash_hmac("sha256", $rawHash, $this->ConfigPayment->serec_key);
        }
        return $response;
    }
}
