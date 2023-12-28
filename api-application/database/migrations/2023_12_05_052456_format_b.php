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
        Schema::create('format_b', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_bayi')->unsigned();
            $table->foreign('id_bayi')->references('id')->on('bayi')->onDelete('cascade')->onUpdate('cascade');
            $table->bigInteger('nomor_batas_tab')->unsigned();
            $table->foreign('nomor_batas_tab')->references('nomor')->on('batas_tab')->onDelete('cascade')->onUpdate('cascade');
            $table->text('hasil');
            $table->text('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_b');
    }
};
