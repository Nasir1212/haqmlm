<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'agent_id',
        'method_code',
        'payment_s_ac',
        'amount',
        'payable_amount',
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
}
