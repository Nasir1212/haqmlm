<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\UserExtra;
use App\Models\WorkingGenCondition;
use App\Models\DirectBonusCondition;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendBonusSmsJob;
use Illuminate\Notifications\DatabaseNotification;
use App\Notifications\UserMessageNotification;
use App\Http\Controllers\NotificationTempController;
use App\Models\NotificationTemp;

class BonusBulkSenderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
$gsd = global_user_data(); // Fetch global user data
        $setting = setting(); // Fetch settings
   
        $level = $setting->matrix_gen_check;
        $total_member = $setting->set_gen_member;

        $userIds = UserExtra::pluck('user_id');
        $userIdsArray = $userIds->toArray();

        $originalArray = $userIdsArray;
        $elementsToMove = [];
        
        $lv = "lv_" . $level;

        foreach ($originalArray as $user) {
            $check_level = MatrixLevel::where('user_id', $user)->first();
            if ($check_level) {
                $check_level->$lv ; 
                $data = json_decode($check_level->$lv);
          
                if (count($data) == $total_member) {
                    $elementsToMove[] = $user;
                }
            }
        }

       // return $elementsToMove;

        $users = User::where('distribute_status', 1)->get(); // Fetch users with distribute status = 1
        $conds =  WorkingGenCondition::all();
        
        foreach ($users as $user) {
              
            $dbcs = DirectBonusCondition::all();
            $ckv = 0;
            foreach ($dbcs as $dbc) {
                if ($user->submitted_point >= $dbc->point) {
                    $ckv++;
                }
            }
           

            if($ckv > 0){
               
                 //  Calculate bonus
                $prevbalance = $user->balance;
                $dbcm = $user->submitted_point / 100 * $dbcs[$ckv - 1]->commission;
                $dbcm -= $dbcm / 100 * $setting->income_charge;
    
                // Update user balance and income

                if(in_array($user->id, $elementsToMove) && $user->id !=1){
                $user->pension_balance  += $dbcm;
                }else{
                $user->balance += $dbcm;
                }
                $user->total_income += $dbcm;
                $user->save();
               // Log transaction
               out_bonus($dbcm);
               trxCreate($dbcm, $prevbalance, $user->balance, $user->id, 'direct_bonus', 'Direct bonus from LSP '.$user->submitted_point, '+', 'N', 'DBT'); 
            }
            working_generation_income_with_refer($user, $conds,$elementsToMove)  ;
            sponsor_generation_income_with_sponsor($user->id,$elementsToMove);
            matrix_income($user->id,$elementsToMove);

        
         }

              foreach( $elementsToMove as $em){
            $user = User::find($em);
            if($user){
            // Notification for Pension Balance
                $template = getNotificationTemplate('pension_balance', [
                '[amount]' => $user->pension_balance,
                '[lock_point]' => $setting->lock_point,
                '[withdraw_amount]' =>  $setting->pension_withdraw_amount,
                ]);
                $data = [
                'body' => $template['body'],
                'type' => $template['type'],
                'subject' => $template['subject'],
                'url' => url('user-details/'.$user->username),
                ];
                 $user->notify(new UserMessageNotification($data));

            }
         }

        // Reset submission checks
        $users = User::where('submit_check', 1)->get();
        foreach ($users as $user) {
            $user->submit_check = 0;
            $user->distribute_status = 0;
            $user->save();
        }
      SendBonusSmsJob::dispatch();
      
        Log::info('Point Bonus Send Success');
  

    //    $gsd = global_user_data(); // Fetch global user data
    //     $setting = setting(); // Fetch settings
   
    //     $level = $setting->matrix_gen_check;
    //     $total_member = $setting->set_gen_member;

    //     $userIds = UserExtra::pluck('user_id');
    //     $userIdsArray = $userIds->toArray();

    //     $originalArray = $userIdsArray;
    //     $elementsToMove = [];
        
    //     $lv = "lv_" . $level;

    //     foreach ($originalArray as $user) {
    //         $check_level = MatrixLevel::where('user_id', $user)->first();
    //         if ($check_level) {
    //             $check_level->$lv ; 
    //             $data = json_decode($check_level->$lv);
          
    //             if (count($data) == $total_member) {
    //                 $elementsToMove[] = $user;
    //             }
    //         }
    //     }

    //     $users = User::where('distribute_status', 1)->get(); // Fetch users with distribute status = 1
    //     $conds =  WorkingGenCondition::all();
        
    //     foreach ($users as $user) {
              
    //         $dbcs = DirectBonusCondition::all();
    //         $ckv = 0;
    //         foreach ($dbcs as $dbc) {
    //             if ($user->submitted_point >= $dbc->point) {
    //                 $ckv++;
    //             }
    //         }
           

    //         if($ckv > 0){
               
    //              //  Calculate bonus
    //             $prevbalance = $user->balance;
    //             $dbcm = $user->submitted_point / 100 * $dbcs[$ckv - 1]->commission;
    //             $dbcm -= $dbcm / 100 * $setting->income_charge;
    
    //             // Update user balance and income

    //             if(in_array($user->id, $elementsToMove)){
    //             $user->pension_balance  += $dbcm;
    //             }else{
    //             $user->balance += $dbcm;
    //             }
    //             $user->total_income += $dbcm;
    //             $user->save();
    //            // Log transaction
    //            out_bonus($dbcm);
    //            trxCreate($dbcm, $prevbalance, $user->balance, $user->id, 'direct_bonus', 'Direct bonus from LSP '.$user->submitted_point, '+', 'N', 'DBT'); 
    //         }
    //         working_generation_income_with_refer($user, $conds,$elementsToMove)  ;
    //         sponsor_generation_income_with_sponsor($user->id,$elementsToMove);
    //         matrix_income($user->id,$elementsToMove);

        
    //      }

    //     // Reset submission checks
    //     $users = User::where('submit_check', 1)->get();
    //     foreach ($users as $user) {
    //         $user->submit_check = 0;
    //         $user->distribute_status = 0;
    //         $user->save();
    //     }
    //   SendBonusSmsJob::dispatch();
    //    // Log success (or you can notify)
    //     Log::info('Point Bonus Send Success');

       
    }
}
