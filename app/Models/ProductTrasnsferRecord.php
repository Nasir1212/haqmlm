<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTrasnsferRecord extends Model
{
    use HasFactory;

    public function sender(){
        return $this->hasOne(Dealer::class, 'user_id','sender_id');
    }
    
    public function receiver(){
        return $this->hasOne(Dealer::class, 'user_id','receiver_id');
    }
    public function product(){
        return $this->hasOne(Product::class, 'id','product_id');
    }
    public function creator(){
        return $this->hasOne(User::class, 'id','created_by');
    }
}
