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
}
