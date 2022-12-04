<?php

use Illuminate\Support\Facades\DB;

function formatId($id, $num)
{
    return str_pad($id, $num, '0', STR_PAD_LEFT);
}

function getFeePurchase($opt_fee, $num)
{
    if ($num == 0) {
        return 0;
    }
    $fee_check = DB::table('configs')->where('key', $opt_fee)
        ->pluck('value')
        ->first();
    $fee_check = json_decode($fee_check, true);
    foreach ($fee_check as $key => $value) {
        if ($value['min'] >= $num) {
            return $fee_check[$key - 1]['value'];
        }
        if ($key == sizeof($fee_check) - 1) {
            return $fee_check[$key]['value'];
        }
    }
}

function getFeeConfig($opt_fee, $quantity)
{
    if ($quantity == 0) {
        return 0;
    }
    $fee_check = DB::table('configs')->where('key', $opt_fee)
        ->pluck('value')
        ->first();
    $fee_check = json_decode($fee_check, true);
    foreach ($fee_check as $key => $value) {
        if ($value['min'] >= $quantity) {
            return $fee_check[$key - 1]['value_1'];
        }
        if ($key == sizeof($fee_check) - 1) {
            return $fee_check[$key]['value_1'];
        }
    }
}
function getFeeConfigNumber($opt_fee)
{
    $fee_check = DB::table('configs')->where('key', $opt_fee)
        ->pluck('value')
        ->first();
    return $fee_check;
}
function sendMessageTeleGroup($orderCode = null)
{
    try {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.telegram.org/bot5945008366:AAEy9lkQQ9BI3JKveCoMyCsO3cB7WOckxHc/sendMessage',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'text=%C4%90%C6%A1n%20h%C3%A0ng%20c%C3%B3%20m%C3%A3%20' . $orderCode . '%20%C4%91%C3%A3%20%C4%91%C6%B0%E1%BB%A3c%20%C4%91%E1%BA%B7t%20c%E1%BB%8Dc%20th%C3%A0nh%20c%C3%B4ng&chat_id=-643143286',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));

        $response = curl_exec($curl);
        return true;

        curl_close($curl);
    } catch (\Throwable $th) {
        return false;
    }
}
