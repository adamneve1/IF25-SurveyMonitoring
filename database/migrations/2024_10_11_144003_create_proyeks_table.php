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
        Schema::create('proyeks', function (Blueprint $table) {
            $table->id(); // ID proyek
            $table->string('nama_proyek'); // Nama proyek
            $table->string('alamat_proyek'); // Alamat proyek
            $table->enum('status', ['belum_mulai', 'berjalan', 'batal', 'selesai']); // Status proyek
            $table->date('tanggal_mulai'); // Tanggal mulai proyek
            $table->date('estimasi_selesai'); // Estimasi selesai proyek
            $table->timestamps(); // Created at dan updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeks');
    }
};
