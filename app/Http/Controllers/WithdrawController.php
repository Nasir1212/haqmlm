<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdraw;
use App\Models\PayAccounts;
use App\Models\User;
use App\Models\Transaction;
use App\Models\PensionPay;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Notifications\UserMessageNotification;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class WithdrawController extends Controller
{
    public function Pending(){
        $gsd = global_user_data();
        $page_title = 'Pending Withdraw';
        
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'withdraw_manage') == 1){
        $data =  Withdraw::where('status', 'Pending')->orWhere('status','Pension Widthdrow Pending')->with('userdata')->latest('id')->get();
        }else{
            $data =  Withdraw::where('user_id',$gsd->id)->where('status', 'Pending')->with('userdata')->latest('id')->get();
        }
        return view('Admin.withdraw.withdraw', compact('page_title','data', 'gsd'));
    } 
    public function Approved(){
        $gsd = global_user_data();
        $page_title = 'Approve Withdraw';
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'withdraw_manage') == 1){
        $data =  Withdraw::where('status', 'Approve')->with('userdata')->latest('id')->get();
        }else{
            $data =  Withdraw::where('user_id',$gsd->id)->where('status', 'Approve')->with('userdata')->latest('id')->get();
        }
        return view('Admin.withdraw.withdraw', compact('page_title','data', 'gsd'));
    } 
    public function Canceled(){
        $gsd = global_user_data();
        $page_title = 'Cancel Withdraw';
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'withdraw_manage') == 1){
        $data =  Withdraw::where('status', 'Cancel')->with('userdata')->latest('id')->get();
        }else{
            $data =  Withdraw::where('user_id',$gsd->id)->where('status', 'Cancel')->with('userdata')->latest('id')->get();
        }
        return view('Admin.withdraw.withdraw', compact('page_title','data', 'gsd'));
    } 
    public function Status_changer(Request $request){
     
        $ac_order = $request->action_order;
        $withdraw =  Withdraw::where('id',$request->id)->first();
        $user_id = $withdraw->user_id;
        $user = User::find($user_id);
        $withdraw_current_status = $withdraw->status;
     
            if( $ac_order == 'pension_approve' || $ac_order == 'approve'){
                
            if( $withdraw->status == 'Approved' || $withdraw->status == 'Pension Widthdrow approve' || $withdraw->status == 'Approve'){
                  notify()->error('Already Approved, So Do not Try again!');
                 return back();
            }elseif($withdraw->status == 'Cancel'){
                 notify()->error('Already Cancel, So Do not Try again!');
                 return back();
            }else{
                 $status  = $ac_order == 'approve'?'Approve':'Pension Widthdrow approved';
                $withdraw->status = $status;         
                $withdraw->save();

               
             $template_delivery = getNotificationTemplate('withdraw_request_accepted', [
                '[amount]' =>number_format($withdraw->amount,2),
              
                ]);
                $data = [
                'body' => $template_delivery['body'],
                'type' => $template_delivery['type'],
                'subject' => $template_delivery['subject'],
                'url' => url("withdraw-approved"),
                ];               
                $user->notify(new UserMessageNotification($data));
               
                notify()->success('Withdraw Approve successfull!');
                return back();
                }
              
            }

            if( $ac_order == 'reject'){
                 if( $withdraw_current_status == 'Approve'){
                  notify()->error('Already Approved, So Do not Try again!');
                 return back();
            }
            elseif($withdraw_current_status == 'Cancel'){
                 notify()->error('Already Cancel, So Do not Try again!');
                 return back();
            }
            elseif($withdraw_current_status == 'Pending'){
                    $withdraw->status = 'Cancel';
                    $withdraw->save();        
                    $user = User::where('id',$user_id)->first();
                    $user->balance += $withdraw->amount + $withdraw->charge;
                    $user->save();

                      $template_delivery = getNotificationTemplate('withdraw_request_rejected', [
                '[amount]' =>number_format($withdraw->amount,2),
              
                ]);
                $data = [
                'body' => $template_delivery['body'],
                'type' => $template_delivery['type'],
                'subject' => $template_delivery['subject'],
                'url' => url("withdraw-cancel"),
                ];               
                $user->notify(new UserMessageNotification($data));
                  
                    notify()->success('Withdraw Reject successfull!');
                    return back();
                }
               
            }

        
    } 


    public function Withdraw_form(Request $request){
         $gsd = global_user_data();
         if($gsd->lock_status == 1){
            notify()->error('Your Account is Lock so at unlock it or contact our helpline!');
            return back();
        }
         $pay_accounts = PayAccounts::where('user_id', 1)->where('status', 1)->with('gateway')->get();
            return view('Admin.withdraw.withdraw-form', compact('pay_accounts','gsd'));
        
    } 

        public function Withdraw_pension_form(Request $request){
         $gsd = global_user_data();
         if($gsd->lock_status == 1){
            notify()->error('Your Account is Lock so at unlock it or contact our helpline!');
            return back();
        }
         $pension_pay = PensionPay::where('user_id', 1)->with('gateway')->get();
            return view('Admin.withdraw.withdraw-Pension-form', compact('pension_pay','gsd'));
        
    } 

    function Withdraw_pension_insert(Request $request){
        $gsd = global_user_data();
           if($gsd->lock_status == 1){
            notify()->error('Your Account is Lock so at unlock it or contact our helpline!');
            return back();
        }
           $uus = User::where('id',$gsd->id)->first();
           if($request->trx_pin == ''){
                notify()->error('Please Provide your Transaction Password!');
                return back();
           }else{
                if($request->trx_pin !=  $uus->trx_password){
                    notify()->error('Sorry Transaction Password Not Match!');
                return back();
               }
           }
    
        $sett =  setting();
    
        if($request->amount > $sett->pension_withdraw_amount){
                notify()->error('Sorry Maximum Withdraw Amount '.$sett->pension_withdraw_amount);
            return back();
        }

        if($sett->lock_point > $gsd->lock_point){
        notify()->error("Sorry, you cannot withdraw. Your lock point is less than {$sett->lock_point}.");
            return back();
        }
           
           if($request->amount >  $uus->pension_balance){
                notify()->error('Sorry Pension Balance Insufficient');
            return back();
           }
           
           

            $PayAccount = PensionPay::where('id',$request->pay_account_id)->with('gateway')->first();
            $gateway_image = $PayAccount->gateway->image_path.$PayAccount->gateway->image_name;
            $pay_ac_id = $PayAccount->id;
            $pay_ac_number = $PayAccount->account;
            $pay_ac_description = $PayAccount->description;
            $pay_ac_qr_code = $PayAccount->account_qr_code == ''?'no':$PayAccount->account_qr_code;
         
            $request_amount = $request->amount;
            $charge = $request_amount / 1000 * (int) $PayAccount->charge;
            $payble_amount = $request->amount - $charge;
            
            return redirect()->route('Withdraw_preview', ['pay_ac_description'=>$pay_ac_description,'pay_ac_number'=>$pay_ac_number,'pay_ac_qr_code'=>$pay_ac_qr_code,'gateway_image'=>$gateway_image,'pay_ac_id'=>$pay_ac_id,'charge'=>'10 Percent','request_amount'=>$request_amount,'payable_amount'=>$payble_amount,'is_pension'=>true]);
        
        
    

    }

    public function Withdraw_form_submit(Request $request){
        $gsd = global_user_data();
        if($gsd->lock_status == 1){
            notify()->error('Your Account is Lock so at unlock it or contact our helpline!');
            return back();
        }
        if($request->amount == ''){
            notify()->error('Please Fillup your Amount !');
            return back();
        }


        $user = User::where('id',Auth::id())->first();
        
       if($user->balance < $request->amount){
            notify()->error('Sorry your balance low!');
            return back();
        }else{ 
            
            $user->balance -= $request->amount;
            $user->save();
            $gtrx = getTrx();
            $wm = $request->amount;
            
            $payAccount = PayAccounts::where('id', $request->pay_account)->with('gateway')->first();
           
            $withdraw = new Withdraw();
            $withdraw->payment_r_ac =  $request->account_number;
            if ($request->hasFile('account_qr_code')) {
            $image_obj = $request->file('account_qr_code');

            // Generate unique filename
            $filename = Str::random(40) . '.' . $image_obj->getClientOriginalExtension();

            // Define relative and full storage path
            $media_type = 'withdraw-account-qr';
            $relative_path = 'uploads/' . $media_type . '/' . $filename;

            // Save image using Intervention
            $image_instance = Image::make($image_obj)->encode(); // you can resize if needed
            Storage::disk('img_disk')->put($relative_path, $image_instance);

            // Save to DB
            $withdraw->payment_r_ac_qr = Storage::disk('img_disk')->url('uploads/' . $media_type . '/' . $filename);
            }


            $charge = $wm / 1000 * $payAccount->charge;
            $withdraw->charge =  $charge;
            $withdraw->amount =  $wm - $charge;
            $withdraw->detail =  $request->extra_info;
            $withdraw->trx =  $gtrx;
            $withdraw->refer_trx =  $gtrx;
            $withdraw->method_code =  $payAccount->gateway->name;
            $withdraw->admin_feedback =  '';
            $withdraw->user_id =  $gsd->id;
            $withdraw->status = 'Pending';
            $withdraw->save();

            //Send Notification to Admin
            $admin = User::where('id', 1)->first();
            $template = getNotificationTemplate('new_withdraw_request', [
                '[amount]' =>number_format($request->amount,2),
                '[receiver_name]' => $user->username,
                '[method]' => $payAccount->gateway->name,
                '[after_blance]' => $user->balance,

                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('withdraw-pending'),
                ];
                $admin->notify(new UserMessageNotification($data));
            notify()->success('Your withdraw successfull submitted !');
            return redirect()->route('withdraw_pending');
            
        }
      
        
    } 
    
     public function Withdraw_form_pension_submit(Request $request){
        $gsd = global_user_data();
        if($gsd->lock_status == 1){
            notify()->error('Your Account is Lock so at unlock it or contact our helpline!');
            return back();
        }
        if($request->amount == ''){
            notify()->error('Please Fillup your Amount !');
            return back();
        }


        $user = User::where('id',Auth::id())->first();
        
       if($user->pension_balance < $request->amount){
            notify()->error('Sorry your balance low!');
            return back();
        }else{ 
            
            $user->pension_balance -= $request->amount;
            $user->save();
            $gtrx = getTrx();
            $wm = $request->amount;
            
            $payAccount = PensionPay::where('id', $request->pay_account)->with('gateway')->first();
           
            $withdraw = new Withdraw();
            $withdraw->payment_r_ac =  $request->account_number;
    
            // if($request->hasFile('account_qr_code')){
            //     $dt = Carbon::now();
            //     $micro = $dt->micro;
            //     $image_obj = $request->file('account_qr_code');
            //     $orpath = storage_path('app/public/uploads/withdraw-account-qr/');
            //     $image_name = $micro.$image_obj->getClientOriginalName();
            //     $public_path = 'storage/uploads/withdraw-account-qr/';
            //     Image::make($image_obj)->save($orpath.'/'.$image_name);
            //     $withdraw->payment_r_ac_qr =  $request->account_qr_code;
            // }

            if ($request->hasFile('account_qr_code')) {
            $image_obj = $request->file('account_qr_code');

            // Generate unique filename
            $filename = Str::random(40) . '.' . $image_obj->getClientOriginalExtension();

            // Define relative and full storage path
            $media_type = 'withdraw-account-qr';
            $relative_path = 'uploads/' . $media_type . '/' . $filename;

            // Save image using Intervention
            $image_instance = Image::make($image_obj)->encode(); // you can resize if needed
            Storage::disk('img_disk')->put($relative_path, $image_instance);

            // Save to DB
            $withdraw->payment_r_ac_qr = Storage::disk('img_disk')->url('uploads/' . $media_type . '/' . $filename);
            }


            $charge = $wm / 1000 *  (int) $payAccount->charge;
            $withdraw->charge =  $charge;
            $withdraw->amount =  $wm - $charge;
            $withdraw->detail =  $request->extra_info;
            $withdraw->trx =  $gtrx;
            $withdraw->refer_trx =  $gtrx;
            $withdraw->method_code =  $payAccount->gateway->name;
            $withdraw->admin_feedback =  '';
            $withdraw->user_id =  $gsd->id;
            $withdraw->status = 'Pension Widthdrow Pending';
            $withdraw->save();
            notify()->success('Your withdraw successfull submitted !');
            return redirect()->route('withdraw_pending');
            
        }
    }
    
    
    
    
    public function Withdraw_preview(){
        $gsd = global_user_data();
        if($gsd->lock_status == 1){
            notify()->error('Your Account is Locked so at unlock it or contact our helpline!');
            return back();
        }
        return view('Admin.withdraw.withdraw-preview', compact('gsd'));
    } 


    public function Withdraw_insert(Request $request){
           $gsd = global_user_data();
           if($gsd->lock_status == 1){
            notify()->error('Your Account is Lock so at unlock it or contact our helpline!');
            return back();
        }
           $uus = User::where('id',$gsd->id)->first();
           if($request->trx_pin == ''){
                notify()->error('Please Provide your Transaction Password!');
                return back();
           }else{
                if($request->trx_pin !=  $uus->trx_password){
                    notify()->error('Sorry Transaction Password Not Match!');
                return back();
               }
           }
    
           
           if($request->amount >  $uus->balance){
                notify()->error('Sorry Balance Insufficient');
            return back();
           }
            
            $PayAccount = PayAccounts::where('id',$request->pay_account_id)->with('gateway')->first();
            $gateway_image = $PayAccount->gateway->image_path.$PayAccount->gateway->image_name;
            $pay_ac_id = $PayAccount->id;
            $pay_ac_number = $PayAccount->account;
            $pay_ac_description = $PayAccount->description;
            $pay_ac_qr_code = $PayAccount->account_qr_code == ''?'no':$PayAccount->account_qr_code;
         
            $request_amount = $request->amount;
            $charge = $request_amount / 1000 * $PayAccount->charge;
            $payble_amount = $request->amount - $charge;
            
            return redirect()->route('Withdraw_preview', ['pay_ac_description'=>$pay_ac_description,'pay_ac_number'=>$pay_ac_number,'pay_ac_qr_code'=>$pay_ac_qr_code,'gateway_image'=>$gateway_image,'pay_ac_id'=>$pay_ac_id,'charge'=>'10 Percent','request_amount'=>$request_amount,'payable_amount'=>$payble_amount]);
        
        
    } 


}