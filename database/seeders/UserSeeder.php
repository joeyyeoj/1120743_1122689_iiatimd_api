<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Joey",
            'email' => "joey@vetcoolproject.com",
            'password' => bcrypt('testpass'),
            'publieke_email' => "joey@contactmehier.com"
        ]);
    }
}
