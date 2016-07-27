<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OAuthClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insert([
            'id' => 'appid01',
            'secret' => 'secret',
            'name' => 'Minha app mobile',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
