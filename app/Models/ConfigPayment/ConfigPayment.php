<?php

namespace App\Models\ConfigPayment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigPayment extends Model
{
    use HasFactory;
    public $table = 'config_payment';
    public $timestamps = true;
    protected $fillable = ['serec_key','access_key','tenant_code','api_end_point','supplier'];

}
