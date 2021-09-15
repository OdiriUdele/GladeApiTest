<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use App\UserRole;

class SuperAdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $superAdmins = ['superadmin@admin.com'];

        $superRole = Role::firstOrCreate(
            [
                'name' =>   "superadmin",
            ]
        );

        foreach ($superAdmins as $superAdmin) {
            
            $superAdmin = User::firstOrCreate(
                [
                    'email' =>   $superAdmin,
                ],
                [
                    'password' =>   bcrypt("password"),
                ]
            );

            UserRole::firstOrCreate(
                [
                    'user_id' =>   $superAdmin->id,
                    'role_id' =>   $superRole->id,
                ]
            );
            
        }
        

    }
}
