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
            $table->id(); // ID manpower
            $table->foreignId('proyek_id')->constrained('proyeks')->cascadeOnDelete(); // Foreign key ke tabel proyeks
            $table->string('nama');
            $table->enum('devisi', ['pgmt', 'hvac', 'qa.qc', 'piping', 'scaffolder', 'structure', 'architectural', 'civil']);;
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
