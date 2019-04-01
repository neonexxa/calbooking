<?php

use Illuminate\Database\Seeder;
use App\State;
class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $states = [
            ['label' => 'FYP'],
            ['label' => 'MSc'],
            ['label' => 'PhD'],
            ['label' => 'RO'],
            ['label' => 'Others'],
        ];
        State::insert($states);
    }
}
