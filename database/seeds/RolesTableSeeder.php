<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['label' => 'Super Admin'],
            ['label' => 'Lab Admin'],
            ['label' => 'Staff'],
            ['label' => 'Student'],
        ];
		Role::insert($roles);
        echo "Successfully seed roles "." \n";
    }
}
