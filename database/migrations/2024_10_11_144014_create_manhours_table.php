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
            $table->foreignId('proyek_id')->constrained('proyeks')->cascadeOnDelete(); // Foreign key to proyeks table
            $table->foreignId('manpower_idl_id')->constrained('manpower_idls')->cascadeOnDelete(); // Foreign key to manpower_dls table
            $table->string('manpower_dl');
            $table->string('pic');
            $table->date('tanggal'); // Date for manhour data entry
            $table->unsignedInteger('overtime'); // Total overtime hours
            $table->enum('devisi', ['pgmt', 'hvac', 'qa.qc', 'piping', 'scaffolder', 'structure', 'architectural', 'civil']);
            $table->timestamps(); // Created at and updated at
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
