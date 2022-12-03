<?php

namespace App\Http\Controllers\api\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ComplainController extends Controller
{
    public function getComplain(){

        $list_complain = DB::table('complains')->where('user_id', Auth::id())->where('is_delete', 0)->get();

        return response()->json([
            'status' => 200,
            'data' => [
                'list_complain' => $list_complain,
            ]
        ],200);
    }
}