<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminBalanceSendRecord extends Model
{
    use HasFactory;
    
   protected $fillable = [
       'receiver_id',
       'balance_type',
       'amount'
       ];
    
    public function user(){
      return $this->hasOne(User::class, 'id','receiver_id');
    }
}
