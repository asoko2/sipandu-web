<?php

use App\Models\Desa;
use App\Models\Verifikator;
use Illuminate\Support\Facades\Auth;
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

function getUnverifiedUsulanCount(){
  
  $no_verifikator = Verifikator::where('user_id', Auth::user()->id)->first()->no;

  $count = DB::table('hasil_pemeriksaans')
              ->where('verifikator_'.$no_verifikator, 0)
              ->orWhere('verifikator_'.$no_verifikator, null)
              ->count();

  return $count;            
}

function getNewNotificationCount()
{
  $notifications = DB::table('notifications')
    ->where('user_id', Auth::user()->id)
    ->where('read_at', null)
    ->count();

  return $notifications;
}

function getNotification()
{
  $notifications = DB::table('notifications')
    ->selectRaw(
      '*, 
        timestampdiff(YEAR, created_at, now()) as YEARS, 
        timestampdiff(MONTH, created_at, now()) as MONTHS, 
        timestampdiff(WEEK, created_at, now()) as WEEKS, 
        timestampdiff(day, created_at, now()) as DAYS, 
        timestampdiff(HOUR, created_at, now()) as HOURS, 
        timestampdiff(MINUTE, created_at, now()) as MINUTES, 
        timestampdiff(SECOND, created_at, now()) as SECONDS 
        ',
    )
    ->where('user_id', Auth::user()->id)
    ->orderBy('id', 'desc')
    ->limit(10)
    ->get();

  return $notifications;
}

function getNotificationTimeDiff($notification)
{
  $time = '';
  if ($notification->YEARS > 0) {
    $time .= $notification->YEARS . 'y';
  } elseif ($notification->MONTHS > 0) {
    $time .= $notification->MONTHS . 'm';
  } elseif ($notification->WEEKS > 0) {
    $time .= $notification->WEEKS . 'w';
  } elseif ($notification->DAYS > 0) {
    $time .= $notification->DAYS . 'd';
  } elseif ($notification->HOURS > 0) {
    $time .= $notification->HOURS . 'h';
  } elseif ($notification->MINUTES > 0) {
    $time .= $notification->MINUTES . 'm';
  } elseif ($notification->SECONDS > 0) {
    $time .= $notification->SECONDS . 's';
  }

  return $time;
}
