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
            ['label' => 'CHE'],
            ['label' => 'CV'],
            ['label' => 'EE'],
            ['label' => 'FASD'],
            ['label' => 'ME'],
            ['label' => 'Others'],
        ];
        Department::insert($departments);
    }
}
