<?php

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
        $this->call(SuperAdminSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SuperAdminRoleSeeder::class);
        $this->call(AdminRoleSeeder::class);
    }
}
