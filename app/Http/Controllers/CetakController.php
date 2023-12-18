<?php

namespace App\Http\Controllers;

ini_set('max_execution_time', 36000);

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CetakController extends Controller
{
    public function download($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $select_query = ['a.*', 'd.nama_desa', 'u.name', 'ag.total_anggaran', 'hp.check_surat_permintaan_pembayaran_spp', 'hp.check_rab', 'hp.check_pernyataan_pertanggungjawaban', 'hp.check_belanja_dpa', 'hp.check_lapor_pertanggungjawaban', 'hp.check_patuh_kebijakan', 'hp.check_sk_tim_pelaksana', 'hp.check_sk_dasar_kegiatan', 'hp.check_spj', 'hp.anggaran_setuju'];

        $jumlah_verifikator = DB::table('verifikators')->count();
        for ($i = 0; $i < $jumlah_verifikator; $i++) {
            $verifikator_number = 'hp.verifikator_' . $i + 1;
            $select_query[] = $verifikator_number;
        }

        $ajuan = DB::table('ajuans as a')
            ->select($select_query)
            ->join('desas as d', 'a.kode_desa', '=', 'd.kode_desa')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->join('anggarans as ag', 'a.kode_desa', '=', 'ag.kode_desa')
            ->leftJoin('hasil_pemeriksaans as hp', 'a.id', '=', 'hp.ajuan_id')
            ->where('a.id', $id)
            ->first();

        $pdf = Pdf::loadView('cetak.ceklis', [
            'data' => $ajuan,
        ]);
        return $pdf->download('Rekomendasi dan Verifikasi Ajuan Desa ' . $ajuan->nama_desa . ' ' . date('Ymdhis') . '.pdf');
    }

    public function view($id)
    {
        $select_query = ['a.*', 'd.nama_desa', 'u.name', 'ag.total_anggaran', 'hp.check_surat_permintaan_pembayaran_spp', 'hp.check_rab', 'hp.check_pernyataan_pertanggungjawaban', 'hp.check_belanja_dpa', 'hp.check_lapor_pertanggungjawaban', 'hp.check_patuh_kebijakan', 'hp.check_sk_tim_pelaksana', 'hp.check_sk_dasar_kegiatan', 'hp.check_spj', 'hp.anggaran_setuju'];

        $jumlah_verifikator = DB::table('verifikators')->count();
        for ($i = 0; $i < $jumlah_verifikator; $i++) {
            $verifikator_number = 'hp.verifikator_' . $i + 1;
            $select_query[] = $verifikator_number;
        }

        $ajuan = DB::table('ajuans as a')
            ->select($select_query)
            ->join('desas as d', 'a.kode_desa', '=', 'd.kode_desa')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->join('anggarans as ag', 'a.kode_desa', '=', 'ag.kode_desa')
            ->leftJoin('hasil_pemeriksaans as hp', 'a.id', '=', 'hp.ajuan_id')
            ->where('a.id', $id)
            ->first();

        $pdf = Pdf::loadView('cetak.ceklis', [
            'data' => $ajuan,
        ]);

        return view('cetak.ceklis', [
            'data' => $ajuan,
        ]);
    }
}
