<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchSummonerPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_summoner_champion', function (Blueprint $table) {
            $table->integer('matchId')->unsigned()->index();
            $table->foreign('matchId')->references('matchId')->on('matches')->onDelete('cascade');
            $table->integer('summonerId')->unsigned()->index();
            $table->integer('championId')->unsigned()->index();
            $table->integer('teamId')->unsigned()->index();
            $table->boolean('winner');

            $table->primary(['matchId', 'summonerId', 'championId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('match_summoner_champion');
    }
}
