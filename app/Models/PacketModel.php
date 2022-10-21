<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacketModel extends Model
{
    protected $table = "packets";

    public $timestamps = true;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'partner_id',
        'order_id',
        'status',
        'opt_order_checking',
        'opt_wood_packing',
        'opt_separate_wood_packing',
        'quantity_buy',
        'quantity_receive',
        'price_unit'
    ];
}
