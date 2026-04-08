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
        Schema::create('teams_competitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('team_id',false)->unsigned();
            $table->bigInteger('competition_id',false)->unsigned();
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('competition_id')->references('id')->on('competitions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams_competitions');
    }
};
