<?php

use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        App\User::insertOrIgnore([
            [
                'email' =>   "superadmin@admin.com",
                'password' =>   bcrypt("password"),
            ],
        ]);
    }
}
