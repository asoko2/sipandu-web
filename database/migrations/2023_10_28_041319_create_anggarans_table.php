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
        Schema::create('anggarans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_desa');
            $table->double('total_anggaran', 10, 2);
            $table->integer('tahun_anggaran');
            $table->timestamps();
        });

        Schema::table('anggarans', function (Blueprint $table) {
            $table->foreign('kode_desa')->references('kode_desa')->on('desas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anggarans');
    }
};
