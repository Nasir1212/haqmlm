<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use App\Models\DirectBonusCondition;
use App\Models\PointSubmitHistory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\WithdrawSetting;
use App\Models\CompanyReserveCondition;
use App\Models\WorkingGenCondition;
use App\Models\SponsorGenCondition;
use App\Models\NonWorkingGenCondition;
use App\Models\NonWorkingMatrixCondition;
use App\Models\RankCondition;
use App\Models\userSelfSubmitPoint;
use App\Models\Transaction;
use App\Models\CountTotalSubmittedPoint;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Contracts\Encryption\Encrypter as EncrypterContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Image;

class SettingsController extends Controller
{

    public function auto_pv_collector(Request $request){
      
        $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
          $cpoint = setting()->check_point;
       if($request->point_type == 'Normal'){
           $users = User::where('point', '>=', $request->point)->where('distribute_status',0)->latest('id')->where('submit_check',0)->paginate(20);
       }elseif($request->point_type == 'Lock'){
           $users = User::where('lock_point', '>=', $request->point)->where('distribute_status',0)->latest('id')->where('submit_check',0)->paginate(20);
       }else{
        $page_title = "Auto collector find out users";
        $users = userSelfSubmitPoint::select('user_self_submit_point.*', 'users.name', 'users.email','users.username','users.point_submit_date','users.id', )
        ->join('users', 'user_self_submit_point.user_id', '=', 'users.id') // Join with users table
        ->where('user_self_submit_point.is_admin_point_collect',0)
        ->latest('user_self_submit_point.id')
        ->paginate(20);
            return view('Admin.settings.auto-pv-collector',compact('cpoint','page_title','users','gsd'));

           
       }
        
            
           
            $page_title = "Auto collector find out users";
            $users->appends(['point' => $request->point,'point_type' => $request->point_type]);
            return view('Admin.settings.auto-pv-collector',compact('cpoint','page_title','users','gsd'));
        }else{
            notify()->error('Permission Not Allow!');
        return back();
        }
    }    


    public function auto_pv_collection_action(Request $request){
         $runing_count_point = 0;
         $gsd = global_user_data();
          $runing_count_point= 0;
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){     
            $point = $request->point;
       // $now = Carbon::today();
       if($request->point_type == 'Normal'){
        $users = User::where('point', '>=', $point)->where('distribute_status',0)->where('submit_check',0)->get();
       }elseif($request->point_type == 'Lock'){
        $users = User::where('lock_point', '>=', $point)->where('distribute_status',0)->where('submit_check',0)->get();
       }else{
      
        $user_submitted_points  = userSelfSubmitPoint::all();
       
        foreach($user_submitted_points as $user_submitted_point){
            $gsd = User::where('id',$user_submitted_point->user_id)->first();
            if($gsd->submit_check == 1){
                $gsd->submitted_point += $user_submitted_point->point;
            }else{
               $gsd->submitted_point = $user_submitted_point->point;
            }
            $runing_count_point +=  $user_submitted_point->point;
            $gsd->total_submitted_point  += $user_submitted_point->point;
            $gsd->distribute_status = 1;
            $gsd->submit_check = 1; 
            $gsd->point_submit_date = date('Y-m-d H:i:s'); 
            $gsd->save();
           

         $trns = Transaction::where('user_id',$user_submitted_point->user_id)->where('created_at',$user_submitted_point->created_at)->where('admin_recollect_date',null)->first(); 
            if($trns != null){
                $trns->admin_recollect_date = Carbon::now();
                $trns->save();
            }
        
        }
           
        // CountTotalSubmittedPoint::create([
        // 'point' => $runing_count_point
        // ]);

       userSelfSubmitPoint::truncate();
        notify()->success('Self Sub Point Collection Complete');
        return back();

       }
     
            if($point == ''){
                notify()->error('Collection point not set !');
                return back();
            }
            if($point == 0){
                notify()->error('Collection point 0 not allow !');
                return back();
            }
       if($request->point_type == ''){
        notify()->error('Collection point type not set !');
        return back();
    }
     $today = Carbon::today();
        $amount = $point;

        foreach ($users as $key => $user) {
            if($request->point_type == 'Normal'){
            $runing_count_point+=$request->point;
            $prev_point = $user->point;
            $user->point -= $point;
            $dd = 'admin action normal point';
            $ph = new PointSubmitHistory();
            $ph->point = $request->point;
            $ph->user_id = $user->id;
           $ph->save();
             }else if($request->point_type == 'Lock'){
              $runing_count_point+=$request->point;
              $prev_point = $user->lock_point;
              $user->lock_point -= $point;
              $dd = 'admin action lock point';
               $ph = new PointSubmitHistory();
            $ph->point = $request->point;
            $ph->user_id = $user->id;
           $ph->save();
             }
            
            $user->submitted_point = $point;
            $user->total_submitted_point += $point;
            $user->point_submit_date = $today;
            $user->distribute_status = 1;
            $user->submit_check = 1;
           $user->save();
            
            trxCreate($amount,$prev_point,$user->point,$user->id,'auto_pv_submit',$dd,'-','N',"M");
        }
         CountTotalSubmittedPoint::create([
        'point' => $runing_count_point
        ]);
       
        notify()->success('Collection Complete');
        return back();
      }else {
        notify()->error('Permission Not Allow!');
        return back();
      }
    }
    
    
    
    
    public function auto_pv_collection_back_action(Request $request){
         $gsd = global_user_data();
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        if(isset($request->single)){
            $trx = Transaction::whereDate('created_at',$request->date)->where('id',$request->id)->where('user_id',$request->user_id)->where('remark','auto_pv_submit')->first();
         
            $auto_p  = PointSubmitHistory::whereDate('created_at',$request->date)->where('user_id',$request->user_id)->where('point',$trx->amount)->first();
        
            $user = User::where('id',$request->user_id)->first();
       
           if($user->submit_check == 1 && $user->distribute_status == 1){
                
                   $user->point += $trx->amount;
                   $user->submitted_point -= $trx->amount;
                   $user->total_submitted_point -= $trx->amount;
                   
                    if($user->submitted_point <= 0){
                         $user->point_submit_date = NULL;
                         $user->distribute_status = 0;
                    $user->submit_check = 0;
                    }
                    $user->save();
                    if($auto_p != null){

                        $auto_p->delete();
                    }
                     $trx->delete();
               notify()->success('Remove Success');
           }
         
            
           
            return back();
                }else{
                      notify()->error('Only Single Data !');
                           return back();
                }
       }else{
                 notify()->error('Permission Not Allow !');
                           return back();
                        }
    
    
    }
    

        
    
    
   

    public function bonus_sender_form(){
        $gsd = global_user_data();
       // dd(User::where('id',1)->latest('id')->paginate(40));
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
           $users = User::where('distribute_status',1)->latest('id')->paginate(40);
        //   $users = User::select('users.*', 'transactions.admin_recollect_date')
        //   ->leftJoin('transactions', function ($join) {
        //       $join->on('users.id', '=', 'transactions.user_id')
        //            ->on('users.point_submit_date', '=', 'transactions.admin_recollect_date')
        //            ->where('transactions.remark', 'self_pv_submit'); // Move condition inside leftJoin
        //           // ->where('users.point_submit_date', '=', 'transactions.created_at'); // Move condition inside leftJoin
        //   })
        //   ->where('users.distribute_status', 1)
        //   ->latest('users.id')
        //   ->paginate(40);
            
        
            $page_title = "Bonus Sending User List";
            return view('Admin.settings.bonus-sender-form',compact('page_title','users','gsd'));
        }else{
          notify()->error('Permission Not Allow !');
           return back();
        }
    }   

      public function working_gen_conditions(){
        $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $WorkingGens = WorkingGenCondition::all();
            return view('Admin.settings.working-generation-condition',compact('WorkingGens','gsd'));
        }else{
notify()->error('Permission Not Allow !');
           return back();
        }
    }   
    public function sponsor_gen_condition_remove(Request $request){
      $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
    SponsorGenCondition::destroy($request->id);
    notify()->success('Remove Success');
        return back();
}else{
 notify()->error('Permission Not Allow !');
           return back();
        }
}
    
      public function sponsor_gen_conditions(){
        $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $SponsorGens = SponsorGenCondition::all();
            return view('Admin.settings.sponsor-generation-condition',compact('SponsorGens','gsd'));
        }else{
notify()->error('Permission Not Allow !');
           return back();
        }
    }   
    public function sponsor_gen_condition_store(Request $request){
               $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $sGenCondition = new SponsorGenCondition();
        $sGenCondition->level = $request->level;
        $sGenCondition->amount = $request->amount;
        $sGenCondition->save();
        notify()->success('Create Success');
        return back();
    }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
        
    } 
     public function sponsor_gen_condition_update(Request $request){
            $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $sGenCondition = SponsorGenCondition::where('id', $request->id)->first();
        $sGenCondition->level = $request->level;
        $sGenCondition->amount = $request->amount;
        $sGenCondition->save();
        notify()->success('Update Success');
        return back();
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }
    
    public function non_working_gen_conditions(){
        $gsd = global_user_data();
       if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $NonWorkingGens = NonWorkingGenCondition::all();
            return view('Admin.settings.non-working-generation-condition',compact('NonWorkingGens','gsd'));
        }else{
notify()->error('Permission Not Allow !');
           return back();
        }
    }   

    public function non_working_matrix_bonus_conditions(){
        $gsd = global_user_data();
          if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $NonWorkingMatrixCondition = NonWorkingMatrixCondition::all();
            return view('Admin.settings.non-working-matrix-condition',compact('NonWorkingMatrixCondition','gsd'));
        }else{
notify()->error('Permission Not Allow !');
           return back();
        }
    }  
    
    public function direct_bonus_conditions(){
         $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $DirectBonusConditions = DirectBonusCondition::all();
            return view('Admin.settings.direct-bonus-condition',compact('DirectBonusConditions','gsd'));
        }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }  

public function working_gen_condition_remove(Request $request){
      $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
    WorkingGenCondition::destroy($request->id);
    notify()->success('Remove Success');
        return back();
}else{
 notify()->error('Permission Not Allow !');
           return back();
        }
}
public function non_working_matrix_condition_remove(Request $request){
      $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
    NonWorkingMatrixCondition::destroy($request->id);
    notify()->success('Remove Success');
        return back();
}else{
 notify()->error('Permission Not Allow !');
           return back();
        }
}
public function direct_bonus_condition_remove(Request $request){
         $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
    DirectBonusCondition::destroy($request->id);
    notify()->success('Remove Success');
        return back();
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
}


   
    
    public function rank_conditions(){
               $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $Ranks = RankCondition::all();
            return view('Admin.settings.rank-condition',compact('Ranks','gsd'));
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }   
    
    
    
    
    public function working_gen_condition_store(Request $request){
               $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $WorkingGenCondition = new WorkingGenCondition();
        $WorkingGenCondition->level = $request->level;
        $WorkingGenCondition->amount = $request->amount;
        $WorkingGenCondition->save();
        notify()->success('Create Success');
        return back();
    }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
        
    } 
       public function non_working_gen_condition_store(Request $request){
             $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $NonWorkingGenCondition = new NonWorkingGenCondition();
        $NonWorkingGenCondition->level = $request->level;
        $NonWorkingGenCondition->amount = $request->amount;
        $NonWorkingGenCondition->save();
        notify()->success('Create Success');
        return back();
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    } 
    
    public function non_working_matrix_condition_store(Request $request){
          $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $NonWorkingMatrixCondition = new NonWorkingMatrixCondition();
        $NonWorkingMatrixCondition->level = $request->level;
        $NonWorkingMatrixCondition->amount = $request->amount;
        $NonWorkingMatrixCondition->save();
        notify()->success('Create Success');
        return back();
    }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }   
    
    public function direct_bonus_condition_store(Request $request){
         $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $DirectBonusCondition = new DirectBonusCondition();
        $DirectBonusCondition->point = $request->point;
        $DirectBonusCondition->commission = $request->amount;
        $DirectBonusCondition->save();
        notify()->success('Create Success');
        return back();
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
        
    }  
    
    public function rank_condition_create(Request $request){
              $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $RankCondition = new RankCondition();
        $RankCondition->rank_royality = $request->rank_royality;
        $RankCondition->position = $request->position;
        $RankCondition->left = $request->left;
        $RankCondition->right = $request->right;
        $RankCondition->rank_name = $request->rank_name;
        $RankCondition->save();
        notify()->success('Create Success');
        return back();
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    } 

    public function rank_condition_update(Request $request){
       $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $RankCondition = RankCondition::where('id', $request->id)->first();
        $RankCondition->position = $request->position;
        $RankCondition->rank_royality = $request->rank_royality;
        $RankCondition->left = $request->left;
        $RankCondition->right = $request->right;
        $RankCondition->rank_name = $request->rank_name;
        $RankCondition->save();
        notify()->success('Update Success');
        return back();
    }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    } 
    
    public function working_gen_condition_update(Request $request){
            $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $WorkingGenCondition = WorkingGenCondition::where('id', $request->id)->first();
        $WorkingGenCondition->level = $request->level;
        $WorkingGenCondition->amount = $request->amount;
        $WorkingGenCondition->save();
        notify()->success('Update Success');
        return back();
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }
    
    public function non_working_gen_condition_update(Request $request){
            $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $NonWorkingGenCondition = NonWorkingGenCondition::where('id', $request->id)->first();
        $NonWorkingGenCondition->limit = $request->limit;
        $NonWorkingGenCondition->amount = $request->amount;
        $NonWorkingGenCondition->save();
        notify()->success('Update Success');
        return back();
    }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }
    
    public function non_working_matrix_condition_update(Request $request){
          $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $NonWorkingMatrixCondition = NonWorkingMatrixCondition::where('id', $request->id)->first();
        $NonWorkingMatrixCondition->level = $request->level;
        $NonWorkingMatrixCondition->amount = $request->amount;
        $NonWorkingMatrixCondition->save();
        notify()->success('Update Success');
        return back();
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }  
    
    public function direct_bonus_condition_update(Request $request){
           $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $DirectBonusCondition = DirectBonusCondition::where('id', $request->id)->first();
        $DirectBonusCondition->point = $request->point;
        $DirectBonusCondition->commission = $request->amount;
        $DirectBonusCondition->save();
        notify()->success('Update Success');
        return back();
         }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }
    
    public function company_reserve_setting(){
        $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $crc_datas = CompanyReserveCondition::all();
            return view('Admin.settings.company-reserve-condition',compact('crc_datas','gsd'));
        }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    } 


    public function company_reserve_condition_create(Request $request){
        $gsd = global_user_data();
             if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $wsd = new CompanyReserveCondition();
            $wsd->cond_name = $request->cond_name;
            $wsd->commission = $request->amount;
            $wsd->type = $request->atype;
            $wsd->save();
            notify()->success('Creating Success');
            return back();
        }else{
            notify()->success('Sorry not Allow !');
            return back();
        }  
    }

    public function company_reserve_condition_update(Request $request){
        $gsd = global_user_data();
            if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $wsd = CompanyReserveCondition::where('id',$request->id)->first();
            $wsd->cond_name = $request->cond_name;
            $wsd->commission = $request->amount;
            $wsd->type = $request->atype;
            $wsd->save();
            
            notify()->success('Update Success');
            return back();
        }else{
 notify()->error('Permission Not Allow !');
           return back();
        }  
    }
    
    public function withdraw_setting(){
        $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
            $WithdrawSettingData = WithdrawSetting::where('id',1)->first();
            return view('Admin.settings.withdraw-setting',compact('WithdrawSettingData','gsd'));
        }else{
 notify()->error('Permission Not Allow !');
           return back();
        }
    }
    

    public function withdraw_setting_update(Request $request){
        $gsd = global_user_data();
         if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        if(Auth::id() == 1){
            $wsd = WithdrawSetting::where('id',1)->first();

            $wsd->withdraw_minimum_limit = $request->minimum_limit;
            $wsd->withdraw_maximum_limit = $request->maximum_limit;
            $wsd->sun_day =  $request->sunday;
            $wsd->mon_day =  $request->monday;
            $wsd->tue_day =  $request->tueday;
            $wsd->wed_day =  $request->wedday;
            $wsd->thu_day =  $request->thuday;
            $wsd->fri_day =  $request->friday;
            $wsd->sat_day =  $request->satday;
            $wsd->withdraw_switch =  $request->withdraw_switch;
            $wsd->message =  $request->message;
        
            $wsd->save();
            
            notify()->success('Update Success');
            return back();
        }else{
  notify()->error('Permission Not Allow !');
           return back();
        }  
         }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
        
    }
    

    
    public function web_config(){
        $gsd = global_user_data();
           if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $setting_data = Setting::where('id',1)->first();
        return view('Admin.settings.settings',compact('setting_data','gsd'));
           }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    } 

    public function web_config_update(Request $request){
      
           $gsd = global_user_data();
           if (Auth::id() == 1 || permission_checker($gsd->role_info,'setting_manage') == 1){
        $setting = Setting::where('id',1)->first();
        $setting->company_name = $request->company_name;
        $setting->refer_com = $request->refer_com;
        $setting->income_charge = $request->income_charge;
        $setting->company_tagline = $request->company_tagline;
        $setting->company_helpline = $request->company_helpline;
        $setting->company_address = $request->company_address;
        $setting->company_second_rpt = $request->company_second_rpt;
        $setting->shipping_cost_in_dhaka = $request->shipping_cost_in_dhaka;
        $setting->shipping_cost_out_dhaka = $request->shipping_cost_out_dhaka;
        $setting->check_point = $request->check_point;
        $setting->set_gen_member = $request->set_gen_member;
        $setting->matrix_gen_check = $request->matrix_gen_check;
        $setting->boot_check_month = $request->boot_check_month;
        if(isset($request->register_switch)){
            $setting->user_register_switch = 1;
        }else{
            $setting->user_register_switch = 0;
        }

        if(isset($request->login_switch)){
            $setting->user_login_switch = 1;
        }else{
            $setting->user_login_switch = 0;
        }
       
       $setting->admin_mail = $request->admin_mail;
       $setting->whatsapp_n = $request->whatsapp_n;
         $setting->regular_tsp = $request->regular_tsp;
         $setting->irregular_tsp = $request->irregular_tsp;
         $setting->non_working_auto = $request->non_working_auto;
         $setting->pension_withdraw_amount = $request->pension_withdraw_amount;
         $setting->lock_point = $request->lock_point;

        $setting->save();
        notify()->success('Update Success');
        return back();
           }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
    }
    
   
}
