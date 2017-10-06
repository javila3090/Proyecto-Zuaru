<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Julio Avila',
            'email' => 'javila3090@gmail.com',
            'password' => bcrypt('secret'),
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
