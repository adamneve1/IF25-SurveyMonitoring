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
        Schema::create('manpower_idls', function (Blueprint $table) {
        $table->id(); // ID manpower
        $table->foreignId('proyek_id')->constrained('proyeks')->cascadeOnDelete();
        $table->string('nama');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manpower_idls');
    }
};
