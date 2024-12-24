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
            $table->id(); 
            $table->foreignId('proyek_id')->constrained('proyeks')->cascadeOnDelete();
            $table->foreignId('manpower_idl_id')->constrained('manpower_idls')->cascadeOnDelete();
            $table->foreignId('manpower_dl_id')->constrained('manpower_dls')->cascadeOnDelete();
            $table->enum('jam_absen', ['pagi', 'siang', 'malam']);
            $table->string('pic');
            $table->date('tanggal');
            $table->unsignedInteger('overtime');
            $table->enum('devisi', ['pgmt', 'hvac', 'qa.qc', 'piping', 'scaffolder', 'structure', 'architectural', 'civil']);
            $table->timestamps();
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
