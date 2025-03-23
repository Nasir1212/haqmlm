<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Models\CompanyAccount;
use App\Models\CustomerRankCondition;
use App\Models\DirectBonusCondition;
use App\Models\DirectBonusTransaction;
use App\Models\News;
use App\Models\NonWorkingGenCondition;
use App\Models\NoticeBoard;
use App\Models\OutPointHistory;
use App\Models\PointSaleHistory;
use App\Models\PointSubmitHistory;
use App\Models\ReserveCond;
use App\Models\User;
use App\Models\UserExtra;
use App\Models\Withdraw;
use App\Models\WithdrawSetting;
use App\Jobs\CallTreeMakeCommandJob;



use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    

    
  public function my_sponsors_jump(Request $request){
    $gsd = global_user_data();
  

    if($request->username != ''){
         if(Auth::id() == 1){
         
         return redirect()->route('my_sponsors', ['id'=>$request->username]);
           
    }else{
       notify()->error('Sorry Not Allow');
                return back();
    }
  
    }else{
         notify()->error('Please Provide Username');
                return back();
    }
  
  }



  public function my_sponsors(Request $request)
{
    $gsd = global_user_data();
    if(Auth::id() == 1){
    $user = User::where('username', $request->id)->with('sponsor')->first();

if($user){
    $sponsors =  User::where('sponsor_id',$user->id)->get(); 
}else{
    $sponsors = null; 
}
}else{
// dd($request->is_jump);
    if($request->is_jump == 'ok'){
         $sps  = $this->getDownlineSponsorUsers($gsd->id);
        if(in_array( $request->id, $sps)){
            $user = User::where('username', $request->id)->with('sponsor')->first();
            $sponsors =  User::where('sponsor_id',$user->id)->get();
           
        }else{
            return redirect()->back()->with('error', 'Sorry, Not Allowed');

        }
       
    }else{
        $user = User::where('username', $request->id)->first();
        $sponsors =  User::where('sponsor_id',$user->id)->get();

    }

}
  return view('Admin.unilevel_tree', compact('sponsors', 'user'));
}

public function fetch_total_team_point_by_sponsors(Request $request,$id ){
   $users =  User::where('username',$id)->with('sponsor')->get();
   $sum_ttp = 0;
   foreach($users as $user){
   if (\Carbon\Carbon::parse($user["point_submit_date"])->gt(\Carbon\Carbon::now()->subDays(7))) {
    $sum_ttp += $user["submitted_point"];
}

}
return $sum_ttp;
}

public function getDownlineSponsorUsers($userId, &$downlineUsers = [])
{
    $users = User::where('sponsor_id', $userId)->get();
    foreach ($users as $user) {
        $downlineUsers[] = $user->username;
        $this->getDownlineSponsorUsers($user->id, $downlineUsers); // Recursive call
    }
    return $downlineUsers;
}

    public function bonus_bulk_sender(){
       
       
        CallTreeMakeCommandJob::dispatch();
        
          notify()->success('Task Proccessing !');
        return back();
    }
     
public function account_active_form(Request $request){
    
    $gsd = global_user_data();
    if(permission_checker($gsd->role_info, 'activation_power') == 1 || Auth::id() == 1){
    return view('Admin.select-account-active',compact('gsd'));
        }else{
        notify()->error('Sorry Not Allow !');
        return back();
    }
    
}



public function account_balance_withdraw_action(Request $request){
    $gsd = global_user_data();
    $cond = WithdrawSetting::where('id',1)->first();
    

    
      if($request->bl_name == 'refer_com'){
       $ramount = $gsd->refer_com;
        if($ramount > 0){
       $gsd->refer_com = 0;
       $commission = $ramount / 100 * $cond->commission;
       if($request->receive_wallet == 'main_wallet'){
           $gsd->balance +=  $ramount - $commission;
       }
       notify()->success('Transfer Success!');
       
       }else{
           notify()->error('Balance Empty!');
       }
    }
    
    $gsd->save();
    
    return back();
}

public function account_balance_trans_manage(){
    $gsd = global_user_data();
    $others = User::where('uniqe_key_code', $gsd->uniqe_key_code)->get();
    return view('Admin.select-bulk-balance-transfer',compact('others','gsd'));
}



    public function unique_key_manage(){
        $gsd = global_user_data();
        return view('Admin.unique-key-manage',compact('gsd'));
    }

    public function unique_key_update(Request $request){
    
         if(isset($request->bulk)){
           $usernames = explode(',',$request->user_list);
           foreach ($usernames as $key => $value) {
            $user = User::where('username',$value)->first();
            if($user){
                $user->uniqe_key_code = $request->key_code;
                $user->save();
                notify()->success('Bulk Key Setup Success');
            }
           }

         }else{
        
            $user = User::where('username',$request->user_list)->first();
            if($user){
                $user->uniqe_key_code = $request->key_code;
                $user->save();
                notify()->success('Single Key Setup Success');
            }
            
         }
        
        return back();
    }

    public function account_switcher(Request $request){

        $main_ac = User::where('id', Auth::id())->first(['uniqe_key_code']);
        $target_ac = User::where('id', $request->selected_account)->first(['uniqe_key_code']);

        if($main_ac == $target_ac){
            session(['check_auth_id' =>  $request->selected_account]);
            notify()->success('Account Switched Success!');
            return redirect()->route('dashboard_index');
        }else{
            notify()->error('You Are theif!');
            return back();
        }
    }

    public function Index(Request $request){

       $gsd = global_user_data();

        if (view()->exists('Admin.dashboard'))
        {
            $power = 'general';
            if (Auth::id() == 1){
                
                if(isset($request->date)){
                     $now =  Carbon::parse($request->date);
                     $users = User::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->get();
                     
                     $accusers = User::where('status',1)->count();
                     $matrix_ac_users = User::where('status',1)->whereYear('point_submit_date',$now->year)->whereMonth('point_submit_date',$now->month)->where('submitted_point', '>=', 400)->count();
                     $matrix_inac_users = $accusers - $matrix_ac_users;
                     $total_sale_point = PointSaleHistory::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->where('status',1)->sum('point');
                     $total_submitted_point = PointSubmitHistory::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->latest('id')->sum('point');
                     $bonus_delivered = Withdraw::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->where('status','Approve')->sum('amount');
                     $out_point = OutPointHistory::whereYear('created_at',$now->year)->whereMonth('created_at',$now->month)->sum('amount');
                }else{
                    $users = User::all();
                    $total_sale_point = PointSaleHistory::where('status',1)->sum('point');
                    $total_submitted_point = PointSubmitHistory::latest('id')->sum('point');
                    $bonus_delivered = Withdraw::where('status','Approve')->sum('amount');
                    $out_point = OutPointHistory::sum('amount');
                    $accusers = User::where('status',1)->count();
                    $matrix_ac_users = User::where('status',1)->where('submitted_point', '>=', 400)->count();
                    $matrix_inac_users = $accusers - $matrix_ac_users;
                }
                
   
                $total_users = 0;
                $total_bannded = 0;
                $total_active = 0;
                $total_inactive = 0;
                $total_locked = 0;
                foreach ($users as $key => $user) {
                   
                    if($user->status == 3){
                        $total_bannded +=1;
                    }else{
                       $total_active += 1; 
                    }
                    
                    if($user->lock_status == 1){
                        $total_locked +=1;
                    }
                  
                   
                    $total_users +=1;

                }

                $power = 'management';
              return  view('Admin.dashboard', compact('bonus_delivered','out_point','total_submitted_point','total_users','total_sale_point','total_active','total_inactive','total_locked','total_bannded','power','matrix_ac_users','gsd','matrix_inac_users'));
            }else{
                $Notice = NoticeBoard::where('id',1)->first();
                $news = News::latest('id')->where('status',1)->paginate(10);
                $crcs = CustomerRankCondition::latest('target_point')->get();
              
                $crn = '';
                foreach($crcs as $crc){
                    if($crc->target_point <= $gsd->total_submitted_point){
                        $crn = $crc->rank_name;
                       break;
                    }
                }

                 
                
                
                
               return  view('Admin.dashboard', compact('power','gsd','Notice','news','crn'));
            }
           
        }else{
            echo "not found";
        }
      
    }

    public function point_submit_form(Request $request){
        $gsd = global_user_data();

        return  view('Admin.point-submit-form', compact('gsd'));

    }

    public function point_submit_for_account_active(Request $request){
        $gsd = global_user_data();
        
        if(isset($request->trx_pin) && $request->trx_pin != ''){
             if($request->trx_pin !=  $gsd->trx_password){
                    notify()->error('Sorry Transaction Password Not Match!');
                return back();
               }
        }else{
            notify()->error('Please Provide your Transaction Password!');
                return back();
        }
        
        $setting = setting();
        if($request->point <= 0){
            notify()->error('Point Empty');
            return back();
        }
        if($request->point >= $setting->check_point ){
            if($gsd->point < $request->point){
                notify()->error('Point Empty');
                return back();
            }else{
              
                $dt = Carbon::now()->subMonth();

                $startDate = new Carbon($gsd->point_submit_date);
                $today = Carbon::now()->subMonth();
                
                $months = $today->diffInMonths($startDate);

                if ($months > 1) {
                    $month = $months;
                    $mc = $month * $setting->check_point;
                    if($request->point < $mc){
                        notify()->error('Due '. $month.' month require point is'.$mc);
                        return back();
                    }
                }
                $prev_point = $gsd->point;
                $gsd->point -= $request->point;
                if($gsd->submit_check == 1){
                    $gsd->submitted_point += $request->point;
                }else{
                   $gsd->submitted_point = $request->point;
                }
          
                $gsd->distribute_status = 1;
                $gsd->submit_check = 1;

               
                
                $gsd->total_submitted_point += $request->point;
                $gsd->point_submit_date = $dt;
                $gsd->save();

                $ph = new PointSubmitHistory();
                $ph->point = $request->point;
                $ph->user_id = $gsd->id;
                $ph->created_at = $dt;
                $ph->updated_at = $dt;
                $ph->save();
                $dd = 'selft point submit';
                 trxCreate($request->point,$prev_point,$gsd->point,$gsd->id,'self_pv_submit',$dd,'-','N',"M");
                notify()->success('Point Submit Success');
                return back();

            }
          
        }else{
            notify()->error('Nedd More Point');
            return back();
        }

    }
}
