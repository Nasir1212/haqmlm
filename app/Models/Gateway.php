<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    use HasFactory;
    protected $fillable = [
        'withdraw_conversation_rate',
        'deposit_conversation_rate',
        'name',
        'image_path',
        'image_name',
        'description',
        'supported_currencies',
        'status'
    ];
}
