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
            'public_email' => "joey@contactmehier.com",
            'telefoonnummer' => "696969",
            'twitter' => "joey69696969",
            'facebook' => "Joey Peschier",
            'snapchat' => "joeypeschier",
            'instagram' => "joeypeschier",
            'linkedin' => "Joey Peschier",
            'tiktok' => "TikTok420",
            'geboortedatum' => "2000-03-28",
        ]);

        DB::table('users')->insert([
            'name' => "Joey2",
            'email' => "joey2@vetcoolproject.com",
            'password' => bcrypt('testpass'),
            'public_email' => "joey@contactmehier.com",
            'telefoonnummer' => "696969",
            'twitter' => "joey69696969",
            'facebook' => "Joey Peschier",
            'snapchat' => "joeypeschier",
            'instagram' => "joeypeschier",
            'linkedin' => "Joey Peschier",
            'tiktok' => "TikTok420",
            'geboortedatum' => "2000-03-28",
        ]);

        DB::table('users')->insert([
            'name' => "Nog een contact",
            'email' => "joey3@vetcoolproject.com",
            'password' => bcrypt('testpass'),
            'public_email' => "joey@contactmehier.com",
            'telefoonnummer' => "696969",
            'twitter' => "joey69696969",
            'facebook' => "Joey Peschier",
            'snapchat' => "joeypeschier",
            'instagram' => "joeypeschier",
            'linkedin' => "Joey Peschier",
            'tiktok' => "TikTok420",
            'geboortedatum' => "2000-03-28",
        ]);
    }
}
