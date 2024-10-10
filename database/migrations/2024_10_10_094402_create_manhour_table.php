<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManhourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manhour', function (Blueprint $table) {
            $table->bigIncrements('manhour_id'); // Primary key untuk manhour
            $table->unsignedBigInteger('proyek_id'); // Kolom relasi ke proyek
            $table->string('proyek'); // Kolom untuk nama proyek / LK
            $table->unsignedInteger('idl'); // Kolom untuk IDL
            $table->unsignedInteger('dl'); // Kolom untuk DL
            $table->unsignedInteger('total'); // Kolom untuk Total
            $table->string('area'); // Kolom untuk Area
            $table->timestamps(); // Menambahkan created_at dan updated_at

            // Menambahkan foreign key constraint
            $table->foreign('proyek_id')->references('proyek_id')->on('proyek')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manhour');
    }
}
