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
        Schema::create('players_positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('player_id',false)->unsigned();
            $table->bigInteger('position_id',false)->unsigned();
            $table->timestamps();

            $table->foreign('player_id')->references('id')->on('players');
            $table->foreign('position_id')->references('id')->on('positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players_positions');
    }
};
