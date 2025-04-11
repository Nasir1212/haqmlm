<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\WorkingGenCondition;
use App\Models\DirectBonusCondition;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use App\Jobs\SendBonusSmsJob;

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
   
        $users = User::where('distribute_status', 1)->get(); // Fetch users with distribute status = 1
        $conds =  WorkingGenCondition::all();
        foreach ($users as $user) {
              
            working_generation_income_with_refer($user, $conds)  ;
            sponsor_generation_income_with_sponsor($user->id);
            matrix_income($user->id);

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
                $user->balance += $dbcm;
                $user->total_income += $dbcm;
                $user->save();
    
               // Log transaction
               out_bonus($dbcm);
               trxCreate($dbcm, $prevbalance, $user->balance, $user->id, 'direct_bonus', 'Direct bonus from LSP '.$user->submitted_point, '+', 'N', 'DBT'); 
            }

        
         }

        // Reset submission checks
        $users = User::where('submit_check', 1)->get();
        foreach ($users as $user) {
            $user->submit_check = 0;
            $user->distribute_status = 0;
            $user->save();
        }
       // SendBonusSmsJob::dispatch();
       // Log success (or you can notify)
        Log::info('Point Bonus Send Success');

        // Under  commanted the code is old code 

        // $gsd = global_user_data(); // Fetch global user data
        // $setting = setting(); // Fetch settings
        // $users = User::where('distribute_status', 1)->get(); // Fetch users with distribute status = 1
        
        // foreach ($users as $user) {
        //     if ($user->first_submit == 0) {
        //         matrix_serial_bonus($user->id); // Handle matrix serial bonus
        //         $user->first_submit = 1;
        //     }

        //     working_generation_income_with_refer($user->id, $user->ref_id, $user->submitted_point);
        //     sponsor_generation_income_with_sponsor($user->id, $user->sponsor_id, $user->submitted_point);
        //     matrix_income($user->id);

        //     $dbcs = DirectBonusCondition::all();
        //     $ckv = 0;
        //     foreach ($dbcs as $dbc) {
        //         if ($user->submitted_point >= $dbc->point) {
        //             $ckv++;
        //         }
        //     }

        //     if($ckv > 0){
        //            // Calculate bonus
        //         $prevbalance = $user->balance;
        //         $dbcm = $user->submitted_point / 100 * $dbcs[$ckv - 1]->commission;
        //         $dbcm -= $dbcm / 100 * $setting->income_charge;
    
        //         // Update user balance and income
        //         $user->balance += $dbcm;
        //         $user->total_income += $dbcm;
        //         $user->save();
    
        //         // Log transaction
        //         out_bonus($dbcm);
        //         trxCreate($dbcm, $prevbalance, $user->balance, $user->id, 'direct_bonus', 'Direct bonus from submitted Point', '+', 'N', 'DBT'); 
        //     }

        
        // }

        // // Reset submission checks
        // $users = User::where('submit_check', 1)->get();
        // foreach ($users as $user) {
        //     $user->submit_check = 0;
        //     $user->distribute_status = 0;
        //     $user->save();
        // }
        // SendBonusSmsJob::dispatch();
        // // Log success (or you can notify)
        // Log::info('Point Bonus Send Success');
    }
}
