<?php

namespace App\Http\Controllers\Backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\PayAccounts;
use App\Models\User;
use App\Notifications\UserMessageNotification;
use Illuminate\Support\Facades\Auth;



class DepositController extends Controller
{
    
    // Pending data Catcher
    public function Pending(){
       $gsd = global_user_data();
       $page_title = 'Pending Balance Request';
       if(Auth::id() == 1 || permission_checker($gsd->role_info,'deposit_manage') == 1){
       $data =  Deposit::where('status', 'Pending')->with('userdata')->latest('id')->get();
        }else{
            $data =  Deposit::where('user_id',$gsd->id)->where('status', 'Pending')->with('userdata')->latest('id')->get();
        }
        return view('Admin.deposit.deposit', compact('page_title','data','gsd'));
    } 
    // Approved data Catcher
    public function Approved(){
       $gsd = global_user_data();
        $page_title = 'Approve Balance Request';
        if(Auth::id() == 1 || permission_checker($gsd->role_info,'deposit_manage') == 1){
        $data =  Deposit::where('status', 'Approve')->with('userdata')->latest('id')->get();
        }else{
            $data =  Deposit::where('user_id',$gsd->id)->where('status', 'Approve')->with('userdata')->latest('id')->get();
        }
        return view('Admin.deposit.deposit', compact('page_title','data','gsd'));
    } 
    // Reject data Catcher
    public function Canceled(){
       $gsd = global_user_data();
       $page_title = 'Reject Balance Request';
       if(Auth::id() == 1 || permission_checker($gsd->role_info,'deposit_manage') == 1){
        $data =  Deposit::where('status', 'Cancel')->with('userdata')->latest('id')->get();
       }else{
            $data =  Deposit::where('user_id',$gsd->id)->where('status', 'Cancel')->with('userdata')->latest('id')->get();
        }
        return view('Admin.deposit.deposit', compact('page_title','data','gsd'));
    } 

    public function Deposit_form(Request $request){
       $gsd = global_user_data();
          $pay_accounts = PayAccounts::where('user_id', 1)->where('status', 1)->with('gateway')->get();
          return view('Admin.deposit.deposit-form', compact('pay_accounts','gsd'));
        
    }  

    public function Deposit_preview(){
        $gsd = global_user_data();
        return view('Admin.deposit.deposit-preview', compact('gsd'));
    } 
    
    public function Deposit_form_submit(Request $request){
        $gsd = global_user_data();

         $payAccount = PayAccounts::where('id', $request->pay_account)->with('gateway')->first();
            $gtrx = getTrx();
            
            $deposit = new Deposit();
            $deposit->payable_amount =  $request->payable_amount;
            $deposit->payment_s_ac =  $request->account_number;
            $deposit->amount =  $request->amount;
            $deposit->charge =  $request->charge;
            $deposit->trx =  $request->trx_id;
            $deposit->method_code =  $payAccount->gateway->name;
            $deposit->refer_trx =  $gtrx;
            $deposit->admin_feedback =  '';
            $deposit->user_id =  $gsd->id;
            $deposit->balance_type = $request->blc_type;
            $deposit->status = 'Pending';
            $deposit->save();

            $gsd->deposit += $request->amount;
            $gsd->save();
            notify()->success('Your Deposit successfull submitted !');
        
            return redirect()->route('deposit_pending');
        
    } 

    public function Deposit_insert(Request $request){
        if($request->amount == ''){
            notify()->error('Please Fillup your Amount !');
            return back();
        }

                $PayAccount = PayAccounts::where('id',$request->pay_account_id)->with('gateway')->first();
                $gateway_image = $PayAccount->gateway->image_path.$PayAccount->gateway->image_name;
                $pay_ac_id = $PayAccount->id;
                $pay_ac_number = $PayAccount->account;
                $pay_ac_description = $PayAccount->description;
                $pay_ac_qr_code = $PayAccount->account_qr_code == ''?'no':$PayAccount->account_qr_code;
             
                $request_amount = $request->amount;
                $ccch = $request->amount / 1000 * $PayAccount->charge;
                $payble_amount = $request->amount + $ccch;
                return redirect()->route('Deposit_preview', ['pay_ac_description'=>$pay_ac_description,'pay_ac_number'=>$pay_ac_number,'pay_ac_qr_code'=>$pay_ac_qr_code,'gateway_image'=>$gateway_image,'pay_ac_id'=>$pay_ac_id,'charge'=>$ccch,'request_amount'=>$request_amount,'payable_amount'=>$payble_amount]);
            
        
    } 



    public function Status_changer(Request $request){
        $gsd = global_user_data();
        $ac_order = $request->action_order;
        $deposit =  Deposit::where('id',$request->id)->first();
        $trx_trx = $deposit->refer_trx;
        $user_id = $deposit->user_id;
        $deposit_current_status = $deposit->status;
        // $user = User::where('id', $gsd->id)->first();
        $user = User::where('id',$user_id)->first();
        //  Approve Condition
        if( $ac_order == 'approve'){
            if( $deposit_current_status == 'Approve'){
                  
                  notify()->error('Already Approved, So Do not Try again!');
                 return back();
            }else{
            $deposit->status = 'Approve';
            $deposit->save();

             

            if($deposit->balance_type == 'main_balance'){
                $user->balance += $deposit->amount;
                $d_type= "Tk ";
            }else{
                $user->point += $deposit->amount;
                $d_type= "Point ";  
            }
            $user->deposit -= $deposit->amount;
            $user->save();
            $template_delivery = getNotificationTemplate('deposit_approved', [
                '[amount]' => number_format($deposit->amount,2). ' ' .  $d_type, 
              
                ]);
                $data = [
                'body' => $template_delivery['body'],
                'type' => $template_delivery['type'],
                'subject' => $template_delivery['subject'],
                'url' => url("deposit-approved"),
                ];              
                $user->notify(new UserMessageNotification($data));

            notify()->success('Balance Request approve successfully!');
            return back();
            }
          

      }elseif($ac_order == 'reject'){
        if( $deposit->status == 'Cancel'){
            notify()->error('Already Rejected, So Do not Try again!');
            return back();
        }else{
            $prev_status = $deposit->status;
            $deposit->status = 'Cancel';
            $deposit->save();

            if($prev_status == 'Pending'){
                $user->deposit -= $deposit->amount;
            }

            if($prev_status == 'Approve'){
                if($deposit->balance_type == 'main_balance'){
                    $user->balance -= $deposit->amount;
                   
                }else{
                    $user->point -= $deposit->amount;
                   
                }
            }
            $user->save();
            $d_type = $deposit->balance_type == 'main_balance' ? ' Tk ' : ' Point ';
             $template_delivery = getNotificationTemplate('deposit_rejected', [
                '[amount]' =>number_format($deposit->amount,2) . ' ' .$d_type,
              
                ]);
                $data = [
                'body' => $template_delivery['body'],
                'type' => $template_delivery['type'],
                'subject' => $template_delivery['subject'],
                'url' => url("deposit-approved"),
                ];
                
               
                $user->notify(new UserMessageNotification($data));


            notify()->success('Balance Request Rejected successfully!');
            return back();

        }
        
      }

    } 



}
