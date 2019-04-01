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
            ['name' => 'Lecturer Neo','email' => 'firdaushishamuddin@gmail.com'],
            ['name' => 'Lecturer Wahyu','email' => 'ade.wahyu@utp.edu.my'],
        ];
        Supervisor::insert($supervisors);
        echo "Successfully seed supervisors "." \n";
    }
}
