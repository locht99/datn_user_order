<?php 
namespace App\Http\GenerateCodeOrder;

use App\Models\OrderModel;
use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;

class GenerateCode{
    public function generateCodeTransaction(){
        $id = TransactionModel::get('id');
        $newid = $id[count($id)-1]->id +1;
        $code =$newid.'-'. date("Ymd");
        return response()->json($code);
    }
    public function generateCodeOrder(){
        $id = OrderModel::where('user_id',Auth::user()->id)->get('id');
        $newId = $id[count($id)-1]->id+1;
        $code ='MD' . Auth::id().$newId.date("Ymd");
        return $code;
    }
}