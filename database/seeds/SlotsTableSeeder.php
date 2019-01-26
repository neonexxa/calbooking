<?php

use Illuminate\Database\Seeder;
use App\Slot;

class SlotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slots = [
            ['name' => 'Slot 1','start' => '9','end' => '10'],
            ['name' => 'Slot 2','start' => '10','end' => '11'],
            ['name' => 'Slot 3','start' => '11','end' => '12'],
            ['name' => 'Slot 4','start' => '12','end' => '1'],
            ['name' => 'Slot 5','start' => '2','end' => '3'],
            ['name' => 'Slot 6','start' => '3','end' => '4'],
            ['name' => 'Slot 7','start' => '4','end' => '5'],
            ['name' => 'Slot 8','start' => '5','end' => '6'],
        ];
        Slot::insert($slots);
        echo "Successfully seed slots "." \n";
    }
}
