<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->integer('jumlah_manpower')->nullable()->default(null)->change();
        });
    }

    public function down()
    {
        Schema::table('proyeks', function (Blueprint $table) {
            $table->integer('jumlah_manpower')->nullable(false)->default(0)->change();
        });
    }
};
