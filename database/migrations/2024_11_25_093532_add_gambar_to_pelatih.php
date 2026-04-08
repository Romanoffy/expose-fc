<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pelatih', function (Blueprint $table) {
        $table->string('gambar')->nullable(); // Adds a nullable 'gambar' column for storing image file path or URL
    });
}

public function down()
{
    Schema::table('pelatih', function (Blueprint $table) {
        $table->dropColumn('gambar'); // Drops the 'gambar' column if the migration is rolled back
    });
}

};
