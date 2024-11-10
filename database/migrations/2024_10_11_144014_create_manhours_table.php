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
        Schema::create('manhours', function (Blueprint $table) {
            $table->id(); // ID manhour
            $table->foreignId('proyek_id')->constrained('proyeks')->cascadeOnDelete(); // Foreign key ke tabel proyeks
            $table->date('tanggal'); // Tanggal input data manhour
            $table->unsignedInteger('jumlah_tenaga_langsung'); // Jumlah tenaga kerja langsung
            $table->unsignedInteger('jumlah_tenaga_tidak_langsung'); // Jumlah tenaga kerja tidak langsung
            $table->unsignedInteger('total_jam'); // Total jam kerja
            $table->timestamps(); // Created at dan updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manhours');
    }
};
