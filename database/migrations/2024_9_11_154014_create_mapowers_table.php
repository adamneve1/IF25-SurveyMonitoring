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
        Schema::create('manpowers', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('proyek_id')->constrained('proyeks')->cascadeOnDelete();
            $table->foreignId('manpower_idl_id')->constrained('manpower_idls')->cascadeOnDelete();
            $table->foreignId('manpower_dl_id')->constrained('manpower_dls')->cascadeOnDelete();
            $table->string('pic');
            $table->date('tanggal');
            $table->boolean('hadir')->default(true); // Tambahkan kolom 'hadir'
            $table->text('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manpowers');
    }
};