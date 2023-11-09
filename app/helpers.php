<?php

use App\Models\Desa;
use Illuminate\Support\Facades\DB;

function getListNamaDesa()
{
  $nama_desa_array = Desa::select('nama_desa')
    ->orderBy('nama_desa', 'asc')
    ->get()
    ->toArray();

  $nama_desa = [];

  foreach ($nama_desa_array as $key => $value) {
    array_push($nama_desa, $value['nama_desa']);
  }

  $nama_desa = json_encode(array_values($nama_desa));

  return $nama_desa;
}

function getListAnggaranDesa()
{
  $anggaran_desa_array = DB::table('anggarans as a')
    ->select('a.*', 'd.nama_desa')
    ->join('desas as d', 'a.kode_desa', '=', 'd.kode_desa')
    ->orderBy('nama_desa', 'asc')
    ->get();

  $anggaran_desa = [];

  foreach ($anggaran_desa_array as $key => $value) {
    array_push($anggaran_desa, $value->total_anggaran);
  }

  $anggaran_desa = json_encode(array_values($anggaran_desa));

  return $anggaran_desa;
}

function getListRealisasiDesa()
{
  $desas = DB::table('desas')
    ->orderBy('nama_desa', 'asc')
    ->get();

  $realisasi_desa = [];

  foreach ($desas as $d) {

    $hasil_pemeriksaan = DB::table('hasil_pemeriksaans as hp')
      ->select('hp.*', 'aj.kode_desa', 'd.nama_desa')
      ->join('ajuans as aj', 'hp.ajuan_id', '=', 'aj.id')
      ->join('desas as d', 'aj.kode_desa', '=', 'd.kode_desa')
      ->where('aj.kode_desa', $d->kode_desa)
      ->get();

    $realisasi = 0;
    foreach ($hasil_pemeriksaan as $h) {
      $realisasi += $h->anggaran_setuju;
    }

    array_push($realisasi_desa, $realisasi);
  }

  $realisasi_desa = json_encode(array_values($realisasi_desa));

  return $realisasi_desa;
}
