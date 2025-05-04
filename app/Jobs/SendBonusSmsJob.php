<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\DirectBonusTransaction;
use App\Models\ReferBonusTransaction;
use App\Models\NwmtbTransaction;
use App\Models\NwmtgTransaction;
use App\Models\WgbTransaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendBonusSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

  

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $ckp = setting()->check_point;
        $chcu = [];
        $now = Carbon::now();
        
        $currentMonth = $now->format('m');
          // Get the current year
        $currentYear = $now->format('Y');
        $month_year = $currentMonth."-".$currentYear;
        // Fetch users with submitted_point >= 400
        $users = User::where('submitted_point', '>=', $ckp)->get();

        foreach ($users as $user) {
            // Fetch the transactions for the current year and month
            $DirectBonusTransaction = DirectBonusTransaction::where('user_id', $user->id)->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount');
            $ReferBonusTransaction = ReferBonusTransaction::where('user_id', $user->id)->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount');
            $NwmtbTransaction = NwmtbTransaction::where('user_id', $user->id)->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount');
            $NwmtgTransaction = NwmtgTransaction::where('user_id', $user->id)->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount');
            $WgbTransaction = WgbTransaction::where('user_id', $user->id)->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('amount');

            // Calculate net amount
            $net_amount = $DirectBonusTransaction + $ReferBonusTransaction + $WgbTransaction + $NwmtbTransaction + $NwmtgTransaction;
            $m_m = $net_amount / 0.90;  // Amount before charge deduction
            $charge = $m_m - $net_amount; // Deducted charge

            // If there is a net amount, prepare the SMS
            if ($net_amount > 0) {
            $date = DateTime::createFromFormat('m-Y', $month_year);
            // Add 1 month
            $date->modify('+1 month');
            // Format to "F, Y" (e.g., May, 2025)
            $formatted = $date->format('F, Y');
                $msg = "HMS Affiliate Bonus   " . $net_amount . " BDT , for (" . $formatted . "). Charge deducted " . $charge . "BDT .  New Balance " . formatAmount($user->balance) . "BDT (" . $user->username . ") \n Haqmultishop.com \n Digital Affiliate System";
                $chcu[] = ['to' => $user->phone, 'message' => $msg];
            }
        }

        // Send bulk SMS
        bulk_msg_sms_send($chcu);
    }
}
