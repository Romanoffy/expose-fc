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
        Schema::create('players', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('team_id',false )->unsigned()->nullable();
            $table->string('name');
            $table->date('birth_date');
            $table->string('gender');
            $table->string('photo');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
};