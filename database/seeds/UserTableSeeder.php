<?php

use Illuminate\Database\Seeder;
use CodeDelivery\Models\User;
use CodeDelivery\Models\Client;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'User',
            'email' => 'user@user.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10),
        ])->client()->save(factory(Client::class)->make());

        factory(User::class)->create([
            'name' => 'Admin',
            'email' => 'admin@user.com',
            'password' => bcrypt(123456),
            'role' => 'admin',
            'remember_token' => str_random(10),
        ])->client()->save(factory(Client::class)->make());

        factory(User::class, 10)->create()->each(function($u){
            for($i=1; $i<=10; $i++){
                $u->client()->save(factory(Client::class)->make());
            }
        });

        for($i=0; $i<6; $i++){
            factory(User::class)->create([
                'name' => 'Entregador ' . $i,
                'email' => 'entregador'.$i.'@user.com',
                'password' => bcrypt(123456),
                'role' => 'deliveryman',
                'remember_token' => str_random(10),
            ])->client()->save(factory(Client::class)->make());
        }
    }
}
