<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $table = "order_detail";
    public $timestamps = true;
    const UPDATED_AT =null;
    protected $fillable = [
        'shop_id',
        'shop_name',
        'shop_url',
        'order_id'
    ];
}
