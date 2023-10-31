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
        Schema::create('ajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('surat_permintaan_pembayaran_spp')->nullable();
            $table->string('rab')->nullable();
            $table->string('pernyataan_pertanggungjawaban')->nullable();
            $table->string('belanja_dpa')->nullable();
            $table->string('lapor_pertanggungjawaban')->nullable();
            $table->string('patuh_kebijakan')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->string('sk_tim_pelaksana')->nullable();
            $table->string('sk_dasar_kegiatan')->nullable();
            $table->date('tanggal_ajuan');
            $table->char('status', 1)->default(0);
            $table->text('catatan')->nullable();
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
        Schema::dropIfExists('ajuans');
    }
};
