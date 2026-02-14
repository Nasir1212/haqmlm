<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointSaleHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'point',
        'status',
         'remark_type',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}


