<?php

use Illuminate\Database\Seeder;
use App\Module;
class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules = [
            ['item' => 'Slot'],
            ['item' => 'Equipment'],
            ['item' => 'User'],
        ];
        Module::insert($modules);
        echo "Successfully seed modules "." \n";
    }
}
