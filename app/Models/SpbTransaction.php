<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpbTransaction extends Model
{
    use HasFactory;

    public function userdata()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
