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
        Schema::create('hasil_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ajuan_id')->constrained();
            $table->char('check_surat_permintaan_pembayaran_spp', 1)->nullable();
            $table->char('check_rab', 1)->nullable();
            $table->char('check_pernyataan_pertanggungjawaban', 1)->nullable();
            $table->char('check_belanja_dpa', 1)->nullable();
            $table->char('check_lapor_pertanggungjawaban', 1)->nullable();
            $table->char('check_patuh_kebijakan', 1)->nullable();
            $table->char('check_sk_tim_pelaksana', 1)->nullable();
            $table->char('check_sk_dasar_kegiatan', 1)->nullable();
            $table->char('check_spj', 1)->nullable();
            $table->double('anggaran_setuju', 13, 2);
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
        Schema::dropIfExists('hasil_pemeriksaans');
    }
};
