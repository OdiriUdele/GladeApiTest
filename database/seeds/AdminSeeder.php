<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
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
                'email' =>   "firstadmin@admin.com",
                'password' =>   bcrypt("password"),
            ],
            [
                'email' =>   "uniqueadmin@admin.com",
                'password' =>   bcrypt("password"),
            ],
        ]);
    }
}
