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
        // Hapus tabel jika sudah ada (untuk fresh migration)
        Schema::dropIfExists('competitions');

        // Buat tabel baru dengan semua kolom
        Schema::create('competitions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->year('year')->nullable();
            $table->enum('category', ['internal', 'external', 'friendly'])->nullable(); // FIXED: changed to 'friendly'
            $table->string('event_type', 100)->nullable();
            $table->text('description');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('competitions');
    }
};