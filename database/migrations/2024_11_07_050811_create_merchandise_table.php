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
        Schema::create('merchandise', function (Blueprint $table) {
            $table->bigIncrements('id');                 
            $table->string('nama_produk');          
            $table->text('deskripsi')->nullable();  
            $table->integer('harga');        
            $table->integer('stok');                
            $table->string('ukuran', 50)->nullable(); 
            $table->string('warna', 50)->nullable(); 
            $table->string('gambar')->nullable();   
            $table->timestamps();                  


            // Pada kolom rating dengan deklarasi decimal(3, 2), angka tersebut merujuk pada:

            // 3 adalah jumlah total digit (baik di kiri maupun kanan desimal) yang dapat disimpan dalam kolom rating. Jadi, 3 memungkinkan untuk nilai antara 0.00 hingga 9.99.
            // 2 adalah jumlah digit di sebelah kanan desimal (angka desimalnya). Artinya, 2 ini memungkinkan nilai rating memiliki dua angka desimal, seperti 4.75.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchandise');
    }
};
