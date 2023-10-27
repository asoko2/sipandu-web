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
        Schema::create('verifikasi_ajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ajuan_id')->constrained();
            $table->boolean('verifikator_1');
            $table->boolean('verifikator_2');
            $table->boolean('verifikator_3');
            $table->boolean('verifikator_4');
            $table->boolean('verifikator_5');
            $table->boolean('verifikator_6');
            $table->boolean('check_surat_permintaan_pembayaran_spp');
            $table->boolean('check_rab');
            $table->boolean('check_pernyataan_pertanggungjawaban');
            $table->boolean('check_belanja_dpa');
            $table->boolean('check_lapor_pertanggungjawaban');
            $table->boolean('check_patuh_kebijakan');
            $table->boolean('check_dokumentasi');
            $table->boolean('check_sk_tim_pelaksana');
            $table->boolean('check_sk_dasar_kegiatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('verifikasi_ajuans');
    }
};
