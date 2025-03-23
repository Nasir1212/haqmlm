<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserExtra;
use App\Models\UserChild;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $u_address = [
            'country'=>'--',
            'city'=>'--',
            'state'=>'--',
            'zip_code'=>'--'
        ];

        $user = new User();
        $user->ref_id = null;
        $user->email = "hms162023@gmail.com";
        $user->name = "muhammad abdul aziz";
        $user->first_name = "Mohammad Abdul";
        $user->last_name = "Aziz";
        $user->username = "haqmultishop";
        $user->ref_id = 0;
        $user->pos_id = 0;
        $user->position = 0;
        $user->access_id = 1;
        $user->password = Hash::make('12345678');
        $user->address = json_encode($u_address);
        $user->save();
        
        $userExtra = new UserExtra();
        $userExtra->user_id = 1;
        $userExtra->save();

        $UserChild = new UserChild();
        $UserChild->user_id = 1;
        $UserChild->save();

    }
}
