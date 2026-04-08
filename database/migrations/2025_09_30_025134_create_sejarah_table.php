<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sejarah', function (Blueprint $table) {
            $table->id();
            $table->string('judul');      // contoh: "Turnamen Lokal"
            $table->string('sub_judul');  // contoh: "Juara 2022"
            $table->string('gambar');     // path gambar trophy
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sejarah');
    }
};
