<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class AccessSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = new Role();
        $role->name = "Supper Admin";
        $role->access_module = NULL;
        $role->status = 1;
        $role->save();

    }
}
