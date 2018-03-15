<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($randomNumber = mt_rand(1, 9), $i = 1; $i < 10; $i++) {
            $randomNumber .= mt_rand(0, 9);
        }
        DB::table('users')->insert([
            'name' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'mobile_no'=> $randomNumber,
            'password' => bcrypt('secret'),
        ]);
    }
}
