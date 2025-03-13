<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('proyek_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('bulan'); // 1 - 12
            $table->unsignedInteger('tahun');
            $table->unsignedInteger('jumlah_plan'); // Plan manpower untuk bulan tersebut
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proyek_plans');
    }
};
