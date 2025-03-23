<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    public function product(){
        return $this->hasOne(Product::class, 'id','product_id');
    }
    
    public function owner(){
        return $this->hasOne(Dealer::class, 'user_id','dealer_id');
    }
    
    public function creator(){
        return $this->hasOne(User::class, 'id','created_by');
    }
    
}
