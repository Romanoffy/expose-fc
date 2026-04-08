<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('category', ['internal', 'external', 'friendly'])->comment('Kategori: internal, external, friendly');
            $table->string('event_name', 100)->comment('Nama event/kegiatan');
            $table->text('description')->nullable()->comment('Deskripsi event');
            $table->timestamps();

            // Index untuk performa
            $table->index('category');
            $table->unique(['category', 'event_name'], 'unique_category_event');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_categories');
    }
};