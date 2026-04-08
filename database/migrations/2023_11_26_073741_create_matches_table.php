<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('competition_id',false)->unsigned();
            $table->bigInteger('team_id_1',false)->unsigned();
            $table->bigInteger('team_id_2',false)->unsigned();
            $table->integer('score_team1')->unsigned();
            $table->integer('score_team2')->unsigned();
            $table->bigInteger('winner_team_id',false)->unsigned();
            $table->dateTime('date');
            $table->bigInteger('venue_id',false)->unsigned();
            $table->string('link_ticket');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('competition_id')->references('id')->on('competitions');
            $table->foreign('team_id_1')->references('id')->on('teams');
            $table->foreign('team_id_2')->references('id')->on('teams');
            $table->foreign('winner_team_id')->references('id')->on('teams');
            $table->foreign('venue_id')->references('id')->on('venues');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
};
