<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProductModel extends Model
{
    use HasFactory;

    protected $table = "cart_products";

    public $timestamps = true;

    const UPDATED_AT = null;
    const CREATED_AT = "create_at";

    protected $fillable = [
        "cart_id",
        "partner_id",
        "user_id",
        "source",
        "product_id",
        "product_name",
        "propertiesId",
        "properties",
        "price_cn",
        "price",
        "original_price",
        "promotion_price",
        "price_table",
        "quantity",
        "quantity_min",
        "stock",
        "url",
        "image",
        "image_detail",
        "note",
        "unit_price_cn",
        "unit_price_vn",
    ];

    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $exchange_rate = ConfigModel::where('key', config('const.config.EXCHANGE_RATE'))
                ->select('value')
                ->first()
                ->value;
            if ($model->promotion_price) {
                $model->price_cn = $model->promotion_price * $model->quantity;
                $model->price = $model->promotion_price * $exchange_rate * $model->quantity;
            }
            else {
                $model->price_cn = $model->original_price * $model->quantity;
                $model->price = $model->original_price * $exchange_rate * $model->quantity;
            }  
        });
    }
}
