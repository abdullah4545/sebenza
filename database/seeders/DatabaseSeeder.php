<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //  $this->call(UserSeeder::class);
         $this->call(RolePermissionSeeder::class);
         $this->call(UserRolePermissionSeeder::class);
        // \App\Models\User::factory(10)->create();
         $this->call(BasicinfoSeeder::class);
         $this->call(AdminSeeder::class);

    }
}
