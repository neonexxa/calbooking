<?php

use Illuminate\Database\Seeder;
use App\Department;
class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $departments = [
            // ['label' => 'ICT'],
        ];
        Department::insert($departments);
    }
}
