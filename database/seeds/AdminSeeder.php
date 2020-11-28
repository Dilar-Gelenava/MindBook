<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->instert([
            'name' => 'Dilar',
            'email' => 'dilar.gelenava.1@btu.edu.ge',
            'password' => bcrypt('12345678'),
        ]);
    }
}
