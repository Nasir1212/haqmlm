<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'access_id',
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'email',
        'religion',
        'client_update_count',
        'password',
        'username',
        'position',
        'ref_id',
        'sponsor_id',
        'balance',
        'new_submited_point_status',
        'refer_com',
        'honorarium_balance',
        'rank_royality_balance',
        'rank_insentive_balance',
        'club_balance',
        'repurchase_gen_com',
        'purchase_bonus',
        'roi_gen_bonus',
        'matching_bonus',
        'purchase_balance',
        'roi',
        'roi_send',
        'roi_payable_count',
        'roi_stop',
        'invest_date_time',
        'roi_next_date',
        'invest_status',
        'address',
        'status',
        'user_rank',
        'phone',
        'total_income',
        'trx_password',
        'uniqe_key_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
     public function findForPassport($username)
{
    return $this->where('username', $username)->first();
}
     
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
   

    public function role_info(){
        return $this->hasOne(Role::class,'id','access_id');
    }

    // public function sponsor(){
    //     return $this->hasOne(User::class,'id','ref_id');
    // }

    public function sponsor(){
        return $this->hasMany(User::class,'sponsor_id','id');
    }
    
    public function userExtra()
    {
        return $this->hasOne(UserExtra::class,'user_id','id');
    }

    public function children()
    {
        return $this->hasMany(User::class,'ref_id','id');
    }
    public function first_sponsor()
    {
        return $this->hasMany(User::class,'sponsor_id','id');
    }
    public function downlineSps()
    {
        return $this->hasMany(User::class,'sponsor_id','id');
    }

    public function downline()
    {
        return $this->hasMany(User::class, 'ref_id');
    }

    public function childrenn()
    {
        return $this->hasMany(User::class,'ref_id','id');
    }


    public function nominee()
    {
        return $this->hasOne(UserNominee::class,'parent_id','id');
    }
    
    public function child(){
        return $this->hasOne(UserChild::class,'user_id','id');
    }
    
    
  public function downlineTotalPoints($current = null)
{
    if ($current === null) {
       $current = Carbon::now()->subMonth();
    }
 

    $totalPoints = 0;

    foreach ($this->childrenn as $uuser) {
        // Check if the user has submitted points in the current month
        if($uuser->point_submit_date == '' || $uuser->point_submit_date == null){
            
        }else{
            $tm = explode('-',$uuser->point_submit_date);
            if($tm[0] == $current->year && $tm[1] == $current->month){
               $userPoints = $uuser->submitted_point;
              $totalPoints += $userPoints;
            }
          
        }
        

       
      
        // Recursively get the downline total points
        $totalPoints += $uuser->downlineTotalPoints($current);
    }

    return $totalPoints;
}

public function transactions()
{
    return $this->hasMany(Transaction::class, 'user_id');
}

}
