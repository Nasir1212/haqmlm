<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PointSaleHistory;
use App\Models\BalanceTransferRecord;
use App\Models\AdminBalanceSendRecord;
use App\Models\NotificationTemp;
use App\Notifications\UserMessageNotification;


class BalanceTransferController extends Controller
{
    public function transfer_option(){
        $gsd = global_user_data();
     
        if($gsd->lock_status == 1){
            notify()->error('Your Account is Lock so at unlock it or contact our helpline!');
            return back();
        }
        return view('Admin.balance.transfer', compact('gsd'));
       
    }

    public function add_option(){
          $gsd = global_user_data();
          
        if (Auth::id() == 1 || permission_checker($gsd->role_info,'balance_add') == 1){
            return view('Admin.balance.add', compact('gsd'));
        }else{
            
           notify()->error('Permission Not Allow !');
           return back();
        }
        
        
    }

    public function transfer_action(Request $request){
        $gsd = global_user_data();
         if($gsd->username == $request->username){
                notify()->error('Sorry you cannot transfer own account!');
                return back(); 
            }
        
        if($gsd->lock_status == 1){
            notify()->error('Your Account is Lock so at unlock it or contact our helpline!');
            return back();
        }
        if ($request->trx_pin == $gsd->trx_password) {
       
            $sender_ac = User::where('username', $gsd->username)->first();             
            $target_user = User::where('username', $request->username)->first();            
            if($request->transfer_type == 'main_balance'){   
                $target_user_blance = $target_user->balance ;
                $sender_ac_blance = $sender_ac->balance; 
                if($sender_ac->balance >= $request->amount){

                    $sender_ac->balance -= $request->amount;
                    $target_user->balance += $request->amount;
             
                $BalanceTransferRecord = new BalanceTransferRecord();
                $BalanceTransferRecord->sender_id = $gsd->id;
                $BalanceTransferRecord->receiver_id = $target_user->id;
                $BalanceTransferRecord->balance_type = "Balance";
               
                $BalanceTransferRecord->prev_blance = $target_user_blance ;
                $BalanceTransferRecord->amount = $request->amount;
                $BalanceTransferRecord->after_blance = $target_user_blance + $request->amount;
                $BalanceTransferRecord->sender_after_blance = $sender_ac_blance - $request->amount;
                $BalanceTransferRecord->sender_before_blance = $sender_ac_blance; 
                $BalanceTransferRecord->save();

                // Sender Notification
                $template = getNotificationTemplate('balance_transfer', [
                '[amount]' => $request->amount,
                '[receiver_name]' => $request->username,
                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('balance-transfer-records'),
                ];
                $sender_ac->notify(new UserMessageNotification($data));

                //Reciver Notification
                $template = getNotificationTemplate('blance_recive', [
                '[amount]' => $request->amount,
                '[sender_name]' =>  $sender_ac->username,
                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('balance-transfer-records'),
                ];
                 $target_user->notify(new UserMessageNotification($data));

                
                    
                    notify()->success('Balance Transfer success in Main Wallet!');
                }else{
                    notify()->error('Insufficient Balance!');
                }
                
                
            }elseif($request->transfer_type == 'point_balance'){
                $target_user_prev_point =$target_user->point;
                $sender_user_prev_point =$sender_ac->point;
                if($sender_ac->point >= $request->amount){
                    $sender_ac->point -= $request->amount;
                    $target_user->point += $request->amount;
                    
                      $BalanceTransferRecord = new BalanceTransferRecord();
                      $BalanceTransferRecord->sender_id = $gsd->id;
                      $BalanceTransferRecord->receiver_id = $target_user->id;
                      $BalanceTransferRecord->balance_type = "Points";
                      $BalanceTransferRecord->prev_blance =  $target_user_prev_point;
                      $BalanceTransferRecord->amount = $request->amount;
                      $BalanceTransferRecord->after_blance = $target_user_prev_point+$request->amount;
                      $BalanceTransferRecord->sender_after_blance = $sender_user_prev_point - $request->amount;
                      $BalanceTransferRecord->sender_before_blance = $sender_user_prev_point;
                      $BalanceTransferRecord->save();
                    
                        $template = getNotificationTemplate('points_transfer', [
                '[amount]' => $request->amount,
                '[receiver_name]' => $request->username,
                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('balance-transfer-records'),
                ];
                $sender_ac->notify(new UserMessageNotification($data));



                //Reciver Notification
                $template = getNotificationTemplate('point_recive', [
                '[amount]' => $request->amount,
                '[sender_name]' =>  $sender_ac->username,
                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('balance-transfer-records'),
                ];
                 $target_user->notify(new UserMessageNotification($data));



                    notify()->success('Balance Transfer success in Point Wallet!');
                }else{
                    notify()->error('Insufficient Balance!');
                }
            }
            $sender_ac->save();
            $target_user->save();
            return back(); 
        }else{
            notify()->error('Transaction Password Not Match!');
                return back(); 
        }
    }


    public function add_action(Request $request){
         $gsd = global_user_data();
        
        if (Auth::id() == 1) {
             
            if($request->trx_pin == admin_trx_pin()){
                $sender_ac = User::where('username', $gsd->username)->first();
                $target_user = User::where('username', $request->username)->first();
                if($request->balance_type == 'main_balance'){
                    $sender_ac_blance = $sender_ac->balance;
                    $target_user_blance = $target_user->balance ;
                    $target_user->balance += $request->amount;
                    
                      $BalanceTransferRecord = new BalanceTransferRecord();
                      $BalanceTransferRecord->sender_id = $gsd->id;
                      $BalanceTransferRecord->receiver_id = $target_user->id;
                      $BalanceTransferRecord->balance_type = "balance";
                      $BalanceTransferRecord->amount = $request->amount;
                      $BalanceTransferRecord->prev_blance =  $target_user_blance ;
                      $BalanceTransferRecord->after_blance =  $target_user_blance +$request->amount;
                      $BalanceTransferRecord->sender_after_blance = $sender_ac_blance - $request->amount;
                      $BalanceTransferRecord->sender_before_blance = $sender_ac_blance;
                      $BalanceTransferRecord->save();
                      // Sender Notification
                $template = getNotificationTemplate('balance_transfer', [
                '[amount]' => $request->amount,
                '[receiver_name]' => $request->username,
                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('balance-transfer-records'),
                ];
                $sender_ac->notify(new UserMessageNotification($data));

                //Reciver Notification
                $template = getNotificationTemplate('blance_recive', [
                '[amount]' => $request->amount,
                '[sender_name]' =>  $sender_ac->username,
                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('balance-transfer-records'),
                ];
                 $target_user->notify(new UserMessageNotification($data));

                
                    
                    notify()->success('Balance Added in Main Wallet!');
                }elseif($request->balance_type == 'point_balance'){
                    $target_user_prev_point = $target_user->point;
                    $target_user->point += $request->amount;
                     $sender_user_prev_point =$sender_ac->point;
                    
                     $BalanceTransferRecord = new BalanceTransferRecord();
                      $BalanceTransferRecord->sender_id = $gsd->id;
                      $BalanceTransferRecord->receiver_id = $target_user->id;
                      $BalanceTransferRecord->balance_type = "Points";
                      $BalanceTransferRecord->amount = $request->amount;
                      $BalanceTransferRecord->prev_blance =  $target_user_prev_point;
                      $BalanceTransferRecord->after_blance = $target_user_prev_point + $request->amount;
                      $BalanceTransferRecord->sender_after_blance = $sender_user_prev_point - $request->amount;
                      $BalanceTransferRecord->sender_before_blance = $sender_user_prev_point;
                      
                      $BalanceTransferRecord->save();
                      
                      
                    $PointSaleHistory = new PointSaleHistory();
                    $PointSaleHistory->user_id = $target_user->id;
                    $PointSaleHistory->point = $request->amount;
                    $PointSaleHistory->status = 1;
                    $PointSaleHistory->save();
                    
                    notify()->success('Balance Added in Point Wallet!');
                }

                $target_user->save();
                    return back(); 
            }else{
                notify()->error('Transaction Password Not Match!');
                return back(); 
            }
            
        }else{
            notify()->error('Permission Not Guranted!');
                return back(); 
        }
    }


}
