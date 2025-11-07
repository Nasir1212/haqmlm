<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'method_code',
        'payment_r_ac',
        'amount',
        'charge',
        'rate',
        'detail',
        'method_currency',
        'status',
        'trx',
        'admin_feedback'
    ];
    public function userdata()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

     public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
    
}
