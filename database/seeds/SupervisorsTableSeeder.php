<?php

use Illuminate\Database\Seeder;
use App\Supervisor;
class SupervisorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supervisors = [
            ['name' => 'Lect Neo','email' => 'neonazi@20minutemail.it'],
        ];
        Supervisor::insert($supervisors);
        echo "Successfully seed supervisors "." \n";
    }
}
