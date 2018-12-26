<?php

use Illuminate\Database\Seeder;
use App\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $roles = [
            ['id' => 1,'label' => 'Super Admin'],
            ['id' => 2,'label' => 'Lab Admin'],
            ['id' => 3,'label' => 'Staff'],
            ['id' => 4,'label' => 'Student'],
        ];
		Role::insert($roles);
        echo "Successfully seed roles "." \n";
    }
}
