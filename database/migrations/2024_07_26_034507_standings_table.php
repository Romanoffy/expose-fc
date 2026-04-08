<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        {
            Schema::create('standings', function (Blueprint $table) {
                $table->bigIncrements('team_id');
                $table->integer('win');
                $table->integer('draw');
                $table->integer('lose');
                $table->integer('goal_for');
                $table->integer('goal_against');
                $table->integer('goal_difference');
                $table->integer('point');
            });
        }
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standings');
    }
};