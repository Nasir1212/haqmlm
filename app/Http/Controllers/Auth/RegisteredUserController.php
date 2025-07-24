<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserExtra;
use App\Models\UserChild;
use App\Models\UserNominee;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Notifications\UserMessageNotification;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $permission  = Setting::where('id', 1)->first();
        if($permission->user_register_switch == 1){
        return view('auth.register');
        }else{
            return redirect('/');
        }

    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

     public function user_uniqe_key_check(Request $request){
    
        $user = User::where('uniqe_key_code', $request->uniqe_key_code)->first();
        
        return response()->json([$user->username,$user->uniqe_key_code]);
   }




public function username__check(Request $request){
    
     $user = User::where('username', $request->username)->first();
     if($user){
            $notice = "<h4 style='color:red;padding:10px'>".$request->username." <strong> is Not Available!</h4>";
     }else{
            $notice = "<h4 style='color:green;padding:10px'>".$request->username." <strong> is Available!</h4>";
     }
     
    return response()->json([$notice]);
}



public function sponsor_user__check(Request $request){
    if ($request->sponsor_username){
        $ref_user = User::where('username', $request->sponsor_username)->first();
        $notice = '';
        if (!$ref_user) {
          
            $notice = "<h4 style='color:red;padding:10px'>".$ref_user->sponsor_username." <strong> Invalid Sponsor Name</h4>";
        }else{
           
    
        $notice = "<h4 style='color:green;padding:10px'>".$ref_user->name." <strong> Correct Sponsor</h4>";
            
               
            
        }

        return response()->json([$notice]);
    }
   }




   public function ref_user__check(Request $request){
    if ($request->ref_username){
        $ref_user = User::where('username', $request->ref_username)->first();
        $notice = '';
        if (!$ref_user) {
          
            $notice = "<h4 style='color:red;padding:10px'>".$request->ref_username." <strong> Invalid Referral Name</h4>";
        }else{
           
                $dref = User::where('ref_id', $ref_user->id)->get();
                if($dref){
                    if($dref->count() >= 2){
                     $notice = "<h4 style='color:red;padding:10px'>".$ref_user->name." <strong> Direct ".$dref->count()." Refers already completed! Please try another referral from your working-team.
</h4>";
                    }else{
                         $notice = "<h4 style='color:green;padding:10px'>".$ref_user->name." <strong> Direct ".$dref->count()." Refer Correct Referral</h4>";
                    }
                }else{
                     $notice = "<h4 style='color:green;padding:10px'>".$ref_user->name." <strong> Direct 0 Refer Correct Referral</h4>";
                }
                
                
               
               
            
        }

        return response()->json([$notice]);
    }
   }

public function   user_join_review(Request $request) {

        if ($request->placement_username && $request->position){
            $placement_user = UserExtra::where('user_name', $request->placement_username)->first();
        }
    

        if ($request->position == 'Left') {
            $position = 1;
        } 

        elseif ($request->position == 'Middle') {
            $position = 2;
        }
     
        elseif ($request->position == 'Right') {
            $position = 3;
        }
   

        $pos = getPosition($placement_user->id, $position);

        $join_under = User::find($pos['pos_id']);

        if ($pos['position'] == 1){
            $get_position = 'Left';

        }
  
        if ($pos['position'] == 2){
            $get_position = 'Middle';

        }
  

        if($pos['position'] == 3){
            $get_position = 'Right';
        }

        return response()->json([$join_under->username,$get_position]);
    }



    public function store(Request $request)
    {
    //   $u =   User::where('username', $request->sponsor_username)->first();
     
       
        $request->validate([
          'terms' => ['required'],
            'username' => ['required', 'lowercase', 'string', 'min:4', 'unique:'.User::class],
            'ref_username' => ['required', 'string'],
            'father_name' => ['required','string'],
             'mother_name' => ['required','string'],
             'full_name' => ['required','string'],
            'phone' => ['required'],
            'password' => ['required'],
            'password_confirmation' => 'required_with:password|same:password'
        ]);

      //  $notify = $this->strongPassCheck($request->password);




        $userCheck = User::where('username', $request['ref_username'])->first();
        if (!$userCheck)
        {
            $notify[] = ['error', 'Referral not found.'];
           
         return back();
        }else{
        $dref = User::where('ref_id', $userCheck->id)->get();
        if($dref){
            if($dref->count() >= 2){
                $notify[] = ['error', 'Direct ".$dref->count()." Refers already completed! Please try another referral from your working-team.
'];
                return back();       
            }
            
        }
           
        }

        // if ($request->position == 'Left'){
        //     $request_position = 1;
        // }
      

        // if ($request->position == 'Middle'){
        //     $request_position = 2;
        // }

        // if ($request->position == 'Right'){
        //     $request_position = 3;
        // }


        $u_address = [
             'house_holding'=>'--',
            'country'=>'--',
            'city'=>'--',
            'state'=>'--',
             'upzila'=>'--',
             'village'=> '--',
            'zip_code'=>'--'
        ];

        if($request->email == ''){
            $semail = 'haqmultishop@gmail.com';
        }else{
            $semail = $request->email;
        }
        
        
        

        if(!isset($request->uniqe_key_code) || $request->uniqe_key_code == ''){
           $fg =  Str::random(10);
            $uniqe_id = 'JS'.$fg;
            $sname = $request->full_name;
            
       //    $ee =  explode(' ',$request->full_name);
            
            $sfname = $sname;
            $slname = '';
             
        }else{

           $uniqe_id = $request->uniqe_key_code;
           $uniqe_info = User::where('uniqe_key_code', $uniqe_id)->first();

           $sname = $uniqe_info->name;
           $sfname = $uniqe_info->first_name;
           $slname = $uniqe_info->last_name;
           if($uniqe_info->email != ''){
            $semail = $uniqe_info->email;
           }
            
        }
        $spnc = User::where('username', $request->sponsor_username)->first();
        $spn = '';
        if($spnc){
            $spn = $spnc->id;
        }
    
        $user = User::create([
            'ref_id' => $userCheck->id,
            'sponsor_id' => $spn,
            'name' => $sname,
            'first_name' => $sfname,
            'father_name' => $request->father_name,
            'mother_name' => $request->mother_name,
            'last_name' => $slname,
            'position'     => 1,
            'username'     => $request->username,
            'email' => $semail,
            'total_income' => 0,         
            'deposit' => 0,   
            'point' => 0,
            'matrix_activation_status' => 0,
            'user_pic_path' => 'storage/uploads/users/',
            'user_pic' => 'sq-logo.png',
            'access_id' => 2,
            'phone' => $request->phone,
            'uniqe_key_code' => $uniqe_id,
            'free_member_set' => 0,
            'address' =>  json_encode($u_address),
            'password' => Hash::make($request->password),
        ]);

      $spset = User::where('id', $userCheck->id)->first(['id','username']);
      $spset->total_sponsor += 1;
      $spset->save();

      $UserNominee = new UserNominee();
      $UserNominee->parent_id = $user->id;
      $UserNominee->save();
      matrixLCreate($user->id);
     
    //   $setting = setting();
       
    //   $subject = "New User Register";
    //   $email = $request->email;
    //   $name = $request->name;
    //   $phone = $request->phone;
    //   $username = $request->username;
    //   $received_mail = $setting->admin_mail;
      
    //   Mail::to($received_mail)->send(new RegisterMail($subject,$name,$phone,$email,$username));
       
       

        Auth::login($user);

        session(['check_auth_id'=> Auth::id()]);
                $template = getNotificationTemplate('new_joining_working_team', [
                
                '[new_working_team_member]' => $request->username,
                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url("user-unilevel-tree/$request->username"),
                ];

                   $template_sps = getNotificationTemplate('new_joining_sps_team', [
                
                '[new_sps_team_member]' => $request->username,
                ]);
                $data_sps = [
                'body' => $template_sps['body'],
                'type' => $template_sps['type'],
                'subject' => $template_sps['subject'],
                'url' => url("my-sponsors?id=$request->username"),
                ];
                 $upline =  getUplinesRef( Auth::id());

                 foreach ($upline as $key => $up) {
                    $up_ref = User::find($up->id);
                    if ($up_ref) {
                        $up_ref->notify(new UserMessageNotification($data));
                    }
                }
                    $uplineSps = getUplinesSps(Auth::id());
                    foreach ($uplineSps as $key => $up) {
                        $up_sps = User::find($up->id);
                        if ($up_sps) {
                            $up_sps->notify(new UserMessageNotification($data_sps));
                        }
                    }
               

        return redirect()->route('dashboard_index');
    }



    protected function strongPassCheck($password){
        
        $capital = '/[ABCDEFGHIJKLMNOPQRSTUVWXYZ]/';
        $capital = preg_match($capital,$password);
        $notify = null;
        if (!$capital) {
            $notify[] = ['error','Minimum 1 capital word is required'];
        }
        $number = '/[123456790]/';
        $number = preg_match($number,$password);
        if (!$number) {
            $notify[] = ['error','Minimum 1 number is required'];
        }
        $special = '/[`!@#$%^&*()_+\-=\[\]{};:"\\|,.<>\/?~\']/';
        $special = preg_match($special,$password);
        if (!$special) {
            $notify[] = ['error','Minimum 1 special character is required'];
        }
        return $notify;
    }

}
