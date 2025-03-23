<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    public function category(){
        return $this->hasOne(ProductCategory::class, 'id','category_id');
    }

   public function brand(){
    return $this->hasOne(ProductBrand::class, 'id','brand_id');

    }
    public function ownerSelf()
    {
        return $this->hasOne(ProductOwner::class, 'product_id', 'id');
    }
    
    
    public function owner()
    {
        // Assuming 'product_id' is the foreign key in 'product_owners' table, and it relates to 'id' in the 'products' table
        return $this->hasOne(ProductOwner::class, 'product_id', 'id');
    }

}
