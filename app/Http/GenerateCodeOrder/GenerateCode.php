<?php 
namespace App\Http\GenerateCodeOrder;

use App\Models\TransactionModel;
use Illuminate\Support\Facades\Auth;

class GenerateCode{
    public function generateCodeTransaction(){
        $id = TransactionModel::get('id');
        $newid = $id[count($id)-1]->id +1;
        $code =$newid.'-'. date("Ymd");
        return response()->json($code);
    }
}