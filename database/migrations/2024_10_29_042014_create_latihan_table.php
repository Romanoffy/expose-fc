<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('latihan', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->bigInteger('id_pelatih', false)->unsigned();
            $table->text('kegiatan_latihan');
            $table->dateTime('jam_mulai_berlatih');
            $table->dateTime('jam_selesai_berlatih');
            $table->text('catatan')->nullable(); // catatan latihan
            $table->timestamps();

            $table->foreign('id_pelatih')->references('id')->on('pelatih');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('latihan');
    }
};
