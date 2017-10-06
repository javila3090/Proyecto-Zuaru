<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MonstersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('monsters')->insert([
            'name' => 'Monster 5',
            'level' => '5',
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);
    }
}
