<?php

namespace App\Http\Entityes;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GetTransaction extends Controller
{
    public function getTransactions(){

        $getTransactions = DB::table('transactions')
            ->join('type_transactions', 'transactions.type_id', 'type_transactions.id')
            ->where('user_id', auth()->user()->id)
            ->select('transactions.order_id', 'type_transactions.type_name', 'transactions.content', 'transactions.point', 'transactions.created_at')
            ->get();

        return $getTransactions;
    }
}