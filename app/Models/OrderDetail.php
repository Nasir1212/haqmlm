<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'order_type',
        'qty',
        'price',
        'total_price',
        'delivery_cost',
        'product_id',
        'payment_status'
      
    ];

   public function product(){
    return $this->hasOne(Product::class, 'id','product_id');
   }
   public function package(){
    return $this->hasOne(Package::class, 'id','package_id');
   }
}
