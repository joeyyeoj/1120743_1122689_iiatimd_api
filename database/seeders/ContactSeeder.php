<?php

namespace Database\Seeders;
use DB;

use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contactlist')->insert([
            'ownerId' => 1,
            'contactId' => 2
        ]);

        DB::table('contactlist')->insert([
            'ownerId' => 1,
            'contactId' => 3
        ]);

    }
}
