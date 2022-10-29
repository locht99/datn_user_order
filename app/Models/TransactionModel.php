<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionModel extends Model
{
    use HasFactory;

    protected $table = "transactions";

    protected $fillable = [
        'partner_id',
        'user_id',
        'order_id',
        'type_id',
        'content',
        'point',
        'point',
        'point_transaction'
    ];

    public $timestamps = true;

    const UPDATED_AT = null;
<<<<<<< HEAD
=======
   
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
>>>>>>> 4f76fb121aa052d409522d9a3e483e1bbcb413d0
}
