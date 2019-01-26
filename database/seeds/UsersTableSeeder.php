<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\User::class, 50)->create();
        /* or you can add also another table that is dependent on user_id:*/
       /*factory(App\User::class, 50)->create()->each(function($u) {
            $userId = $u->id;
            DB::table('posts')->insert([
                'body' => str_random(100),
                'user_id' => $userId,
            ]);
        });*/
        $users = [
            // ['name' => str_random(6),'email' => strtolower(str_random(6)).'@gmail.com','password' => bcrypt('test@123')],
            ['name' => 'super_admin','email' => 'super_admin@gmail.com','password' => bcrypt('password'),'role_id' => 1],

            ['name' => 'lab_admin','email' => 'lab_admin@gmail.com','password' => bcrypt('password'),'role_id' => 2],
            ['name' => 'lab_admin2','email' => 'lab_admin2@gmail.com','password' => bcrypt('password'),'role_id' => 2],

            ['name' => 'staff','email' => 'staff@gmail.com','password' => bcrypt('password'),'role_id' => 3],
            ['name' => 'staff2','email' => 'staff2@gmail.com','password' => bcrypt('password'),'role_id' => 3],
            ['name' => 'staff3','email' => 'staff3@gmail.com','password' => bcrypt('password'),'role_id' => 3],
            ['name' => 'staff4','email' => 'staff4@gmail.com','password' => bcrypt('password'),'role_id' => 3],

            // given
            ['name' => 'student','email' => 'student@gmail.com','password' => bcrypt('password'),'role_id' => 4],
            ['name' => 'student2','email' => 'student2@gmail.com','password' => bcrypt('password'),'role_id' => 4],
            ['name' => 'student3','email' => 'student3@gmail.com','password' => bcrypt('password'),'role_id' => 4],
            ['name' => 'student4','email' => 'student4@gmail.com','password' => bcrypt('password'),'role_id' => 4],
            ['name' => 'student5','email' => 'student5@gmail.com','password' => bcrypt('password'),'role_id' => 4],
            ['name' => 'student6','email' => 'student6@gmail.com','password' => bcrypt('password'),'role_id' => 4],
            ['name' => 'student7','email' => 'student7@gmail.com','password' => bcrypt('password'),'role_id' => 4],
            ['name' => 'student8','email' => 'student8@gmail.com','password' => bcrypt('password'),'role_id' => 4],
            ['name' => 'student9','email' => 'student9@gmail.com','password' => bcrypt('password'),'role_id' => 4],
        ];
        User::insert($users);
        $users2 = [
            ['name' => 'Hashila','ext' => 8215, 'email' => 'Hashila@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Anuar','ext' => 8212, 'email' => 'Anuar@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Idrus','ext' => 8211, 'email' => 'Idrus@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Omar','ext' => 8213, 'email' => 'Omar@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Faizah','ext' => 8229, 'email' => 'Faizah@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Firdaus','ext' => 7195, 'email' => 'Firdaus@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Jailani','ext' => 7586, 'email' => 'Jailani@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Fauzi','ext' => 7552, 'email' => 'Fauzi@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Asnizam','ext' => 8210, 'email' => 'Asnizam@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Irwan','ext' => 8222, 'email' => 'Irwan@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Asna','ext' => 8376, 'email' => 'Asna@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Hazri','ext' => 8224, 'email' => 'Hazri@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Johan','ext' => 7334, 'email' => 'Johan@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Yus','ext' => 7330, 'email' => 'Yus@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
            ['name' => 'Shahrrul','ext' => 7105, 'email' => 'Shahrrul@app.com', 'password' => bcrypt('password'), 'role_id' => 3],
        ];
        User::insert($users2);
        echo "Successfully seed users "." \n";
    }
}
