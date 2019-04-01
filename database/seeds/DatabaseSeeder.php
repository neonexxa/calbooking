<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(SlotsTableSeeder::class);
        $this->call(LocationsTableSeeder::class);
        $this->call(EquipmentsTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(SupervisorsTableSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
    }
}
