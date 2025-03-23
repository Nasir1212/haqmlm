<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;
use App\Models\RoiSetting;
use App\Models\WithdrawSetting;

class SettingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $setting = new Setting();
        $setting->sitename = 'g_binary';
        $setting->company_name = 'g_binary';
        $setting->site_url = 'g_binary.com';
        $setting->save(); 
        
        $RoiSetting = new RoiSetting();
        $RoiSetting->roi_send_amount = 5;
        $RoiSetting->roi_send_date_day = 1;
        $RoiSetting->roi_send_stop = 25;
        $RoiSetting->save();

        $WithdrawSetting = new WithdrawSetting();
        $WithdrawSetting->withdraw_minimum_limit = 100;
        $WithdrawSetting->withdraw_maximum_limit = 5000;
        $WithdrawSetting->sun_day = 1;
        $WithdrawSetting->mon_day = 1;
        $WithdrawSetting->tue_day = 1;
        $WithdrawSetting->wed_day = 1;
        $WithdrawSetting->thu_day = 1;
        $WithdrawSetting->fri_day = 1;
        $WithdrawSetting->sat_day = 1;
        $WithdrawSetting->withdraw_switch = 1;
        $WithdrawSetting->message = 'Recently our withdraw option off';
        $WithdrawSetting->save();

    }
}
