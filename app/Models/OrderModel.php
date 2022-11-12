<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderModel extends Model
{
    protected $table = "orders";

    public $timestamps = true;

    const UPDATED_AT = null;
    // const CREATED_AT = "create_at";

    protected $fillable = [
        'partner_id',
        'user_id',
        'order_status_id',
        'shop_id',
        'shop_name',
        'shop_url',
        'global_shipping_fee',
        'china_shipping_fee',
        'purchase_fee',
        'inventory_fee',
        'wood_packing_fee',
        'separately_wood_packing_fee',
        'high_value_fee',
        'checking_order_fee',
        'auto_shipping_fee',
        'express_shipping_fee',
        'total_price',
        'deposit_amount',
        'note',
        'source',
        'order_code',
        'total_price_order'
    ];
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $exchange_rate = DB::table('configs')->where('key', config('const.config.EXCHANGE_RATE'))
                ->select('value')
                ->first()
                ->value;
            $model->total_price_order = $model->global_shipping_fee ?? 0
                + ($model->china_shipping_fee ?? 0
                    * $exchange_rate)
                + $model->purchase_fee ?? 0
                + $model->inventory_fee ?? 0
                + $model->wood_packing_fee ?? 0
                + $model->separately_wood_packing_fee ?? 0
                + $model->high_value_fee ?? 0
                + $model->checking_order_fee ?? 0
                + $model->auto_shipping_fee ?? 0
                + $model->saving_shipping_fee ?? 0
                + $model->express_shipping_fee ?? 0
                + $model->total_price ?? 0;
        });
    }
    function product()
    {
        return $this->hasMany(OrderProductModel::class, 'order_id', 'id');
    }
}
