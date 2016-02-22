<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->integer('matchId')->unsigned();
            $table->bigInteger('timestamp');
            $table->integer('winner');
            $table->string('season');
            $table->string('region');
            $table->string('version');

            $table->primary(['matchId', 'region']);
        });

        DB::statement("ALTER TABLE matches ADD data MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('matches');
    }
}
