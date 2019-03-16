<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations = [
            ['name' => 'Lab 1','address' => 'Secret'],
        ];
        Location::insert($locations);
        echo "Successfully seed locations "." \n";
    }
}
