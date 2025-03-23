<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'trx',
        'trx_type',
        'amount',
        'post_balance',
        'details',
        'remark',
        'user_id'
    ];
    
    
    public function userdata()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
