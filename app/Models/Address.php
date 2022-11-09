<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $table = "user_addresses";

    public $timestamps = true;

    protected $fillable = [
        'address',
        'user_id',
        'name',
        'phone',
        'province',
        'district',
        'ward',
        'note',
        'is_default'
    ];
}
