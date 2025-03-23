<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserExtra extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_name',
        'pos_id','position',
        'paid_left',
        'paid_middle',
        'paid_right',
        'middle_free',
        'left_free',
        'right_free'
    ];




    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function matrix_Levels()
    {
        return $this->hasOne(MatrixLevel::class,'user_id','user_id');
    }

    public function pos_child()
    {
        return $this->hasMany(UserExtra::class,'pos_id','id');
    }
    public function down_id()
    {
        return $this->hasOne(UserExtra::class,'pos_id','id');
    }
    
    
    
   public function downline() {
        return $this->hasMany(UserExtra::class, 'pos_id', 'id');
    }

    public function getDownlineUserCount($level = 1) {
        $totalUsers = 0;
        
        if ($level === 1) {
            return $this->downline->count();
        }
        
        foreach ($this->downline as $user) {
            $totalUsers += $user->getDownlineUserCount($level - 1);
        }
        
        return $totalUsers;
    }
    
    
     // Method to fill up the tree
    public function fillTree($parentId, $level, $maxLevels)
    {
        if ($level <= $maxLevels) {
            for ($i = 1; $i <= 3; $i++) { // Assuming 3 positions for each member
                $child = new UserExtra([
                    'user_id' => $parentId, // Set the user's ID
                    'position' => $level,
                ]);

                $this->pos_child()->save($child);

                $this->fillTree($child->id, $level + 1, $maxLevels);
            }
        }
    }
    
   public function children()
    {
        return $this->hasMany(UserExtra::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(UserExtra::class, 'parent_id');
    }
    
    
}
