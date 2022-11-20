<?php

namespace App\Http\Controllers\api\Log;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppLogController extends Controller
{
    public function getLog(){
        $allLog = DB::table('app_logs')->where('user_id', auth()->id())->limit(5)->orderBy('created_at', 'desc')->get();
        return response()->json($allLog, 200);
    }

}