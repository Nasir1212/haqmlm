<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivation extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'activation_method',
        'activation_date',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
