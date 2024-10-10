<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyekTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyek', function (Blueprint $table) {
            $table->bigIncrements('proyek_id'); // Mengubah kolom id menjadi proyek_id
            $table->string('nama_proyek'); // Kolom untuk nama proyek
            $table->string('alamat_proyek'); // Kolom untuk alamat proyek
            $table->enum('status', ['belum_mulai', 'berjalan', 'batal', 'selesai']); // Kolom untuk status proyek
            $table->date('tanggal_mulai'); // Kolom untuk tanggal mulai
            $table->date('estimasi_selesai'); // Kolom untuk estimasi selesai
            $table->timestamps(); // Menambahkan kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyek');
    }
}
