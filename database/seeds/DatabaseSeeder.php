<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    protected function runUnsafe(Callable $callback) {
        Model::unguard();
        DB::statement("SET foreign_key_checks=0");
        $callback($this);
        DB::statement("SET foreign_key_checks=1");
        Model::reguard();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->runUnsafe(function(Seeder $seeder) {
            $seeder->call('UserTableSeeder');
        });
    }
}
