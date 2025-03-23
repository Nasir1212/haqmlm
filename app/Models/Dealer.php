<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;
    public function ref(){
        return $this->hasOne(User::class, 'id','ref_id');
    }
    public function user(){
        return $this->hasOne(User::class, 'id','user_id');
    }
}
