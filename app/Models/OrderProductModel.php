<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderProductModel extends Model
{
    protected $table = "order_products";

    public $timestamps = true;

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'partner_id',
        'order_id',
        'product_id',
        'source',
        'product_name',
        'propertiesId',
        'properties',
        'quantity_bought',
        'price',
        'quantity_min',
        'price_table',
        'original_price',
        'promotion_price',
        'stock',
        'url',
        'image_link',
        'image_detail',
        'order_status_id',
        'shop_id'
    ];
}
