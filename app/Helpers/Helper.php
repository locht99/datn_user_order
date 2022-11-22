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
    dd($fee_check);
    return $fee_check;
}
