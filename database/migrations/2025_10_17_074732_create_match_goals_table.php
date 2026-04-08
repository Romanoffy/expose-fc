<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('match_id', false)->unsigned();
            $table->bigInteger('player_id', false)->unsigned();
            $table->bigInteger('team_id', false)->unsigned();
            $table->integer('minute')->nullable(); // Menit gol dicetak
            $table->enum('goal_type', ['regular', 'penalty', 'own_goal'])->default('regular');
            $table->timestamps();

            $table->foreign('match_id')->references('id')->on('matches')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_goals');
    }
};