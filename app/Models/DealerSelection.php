<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealerSelection extends Model
{
    use HasFactory;
    
    public function dealer(){
        return $this->hasOne(Dealer::class, 'user_id','dealer_id');
    }
}
