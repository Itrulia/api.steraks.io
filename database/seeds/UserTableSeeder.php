<?php

use App\Elo;
use Illuminate\Database\Seeder;
use App\User;
use App\Game;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->truncate();

        User::create([
            'summonerId' => '21422420',
            'region' => 'EUW',
            'email' => 'fiora@summoner.gg',
            'password' => Hash::make('1234')
        ]);

        User::create([
            'summonerId' => '42999456',
            'region' => 'EUW',
            'email' => 'pixop@summoner.gg',
            'password' => Hash::make('1234')
        ]);
    }
}
