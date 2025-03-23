<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayAccounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'gateway_id',
        'user_id',
        'account',
        'status',
        'account_qr_code',
        'description'
    ];

    public function gateway(){
        return $this->hasOne(Gateway::class,'id','gateway_id');
    }
}
