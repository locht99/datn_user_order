<?php

namespace App\Http\Entityes;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Exceptions\OAuthServerException;

class GetTransaction extends Controller
{
    public function getTransactions()
    {

        $getTransactions = DB::table('transactions')
            ->join('type_transactions', 'transactions.type_id', 'type_transactions.id')
            ->where('user_id', auth()->id())
            ->select('transactions.order_id', 'type_transactions.type_name', 'transactions.content', 'transactions.point', 'transactions.created_at')
            ->paginate(8);

        return $getTransactions;
    }
}
