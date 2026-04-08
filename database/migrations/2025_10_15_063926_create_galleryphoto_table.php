<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('galleryphoto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')
                  ->constrained('gallery')
                  ->onDelete('cascade');

            $table->string('photo');
            $table->string('alt')->nullable(); 
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleryphoto');
    }
};
