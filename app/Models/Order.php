<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'trucking_code',
        'shipping',
        'billing',
        'payment_status',
        'divery_status',
        'shipping_cost'
    ];
    
    public function order_detail(){
        return $this->hasMany(OrderDetail::class, 'order_id','id');
    }
    
  
    
     public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }
    
    public function shipping_address(){
        return $this->hasOne(ShippingAddress::class, 'id','shipping');
    }

    public function billing_address(){
        return $this->hasOne(BillingAddress::class, 'id','billing');
    }
}
