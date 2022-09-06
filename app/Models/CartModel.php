<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartModel extends Model
{
    use HasFactory;

    protected $table = "carts";

    public $timestamps = true;

    const UPDATED_AT = null;
    const CREATED_AT = "create_at";

    protected $fillable = [
        "partner_id",
        "user_id",
        "source",
        "shop_id",
        "shop_name",
        "shop_url",
        "total_price",
    ];
}
