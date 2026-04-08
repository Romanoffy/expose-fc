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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_transaksi');
            $table->foreignId('id_merchandise');
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_satuan', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->string('ukuran')->nullable();
            $table->string('warna')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_transaksi')
                ->references('id')
                ->on('transaksi')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('id_merchandise')
                ->references('id')
                ->on('merchandise')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('detailtransaksi', function (Blueprint $table) {
            //
        });
    }
};
