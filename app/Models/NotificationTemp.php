<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTemp extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'body'];
}

