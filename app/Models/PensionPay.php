<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PensionPay extends Model
{
    use HasFactory;

      protected $fillable = [
        'gateway_id',
        'user_id',
        'account',
        'description',
        'account_qr_code',
        'charge',
        'status',
    ];
     public function gateway(){
        return $this->hasOne(Gateway::class,'id','gateway_id');
    }
}
