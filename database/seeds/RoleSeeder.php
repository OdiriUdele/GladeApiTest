<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['superadmin','admin','company','employee'];

        foreach ($roles as $role) {
            
            App\Role::firstorCreate(
                [
                    'name' => $role
                ]
            );
        }
    }
}
