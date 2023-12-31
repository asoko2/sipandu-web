<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_desa')->unique();
            $table->index('kode_desa');
            $table->string('nama_desa');
            $table->string('kode_kecamatan');
            $table->timestamps();
        });

        Schema::table('desas', function (Blueprint $table) {
            $table->foreign('kode_kecamatan')->references('kode_kecamatan')->on('kecamatans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desas');
    }
};
