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
        $ajuan = DB::table('ajuans as a')
            ->select('a.*', 'd.nama_desa', 'u.name', 'ag.total_anggaran', 'hp.verifikator_1', 'hp.verifikator_2', 'hp.verifikator_3', 'hp.verifikator_4', 'hp.verifikator_5', 'hp.verifikator_6', 'hp.check_surat_permintaan_pembayaran_spp', 'hp.check_rab', 'hp.check_pernyataan_pertanggungjawaban', 'hp.check_belanja_dpa', 'hp.check_lapor_pertanggungjawaban', 'hp.check_patuh_kebijakan', 'hp.check_sk_tim_pelaksana', 'hp.check_sk_dasar_kegiatan', 'hp.anggaran_setuju')
            ->join('desas as d', 'a.kode_desa', '=', 'd.kode_desa')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->join('anggarans as ag', 'a.kode_desa', '=', 'ag.kode_desa')
            ->leftJoin('hasil_pemeriksaans as hp', 'a.id', '=', 'hp.ajuan_id')
            ->where('a.id', $id)
            ->first();

        $pdf = Pdf::loadView('cetak.ceklis', [
            'data' => $ajuan,
        ]);
        return $pdf->download('Rekomendasi dan Verifikasi Ajuan Desa ' . $ajuan->nama_desa . ' ' . date('dd M Y') . '.pdf');

        // $pdf = Pdf::loadHTML('<h1>Text</h1>');
        // return $pdf->download('tes.pdf');


        // return Pdf::loadFile(public_path().'/cetak)

        // return view('cetak.ceklis', [
        //     'data' => $ajuan,
        // ]);
    }

    public function view($id)
    {
        $ajuan = DB::table('ajuans as a')
            ->select('a.*', 'd.nama_desa', 'u.name', 'ag.total_anggaran', 'hp.verifikator_1', 'hp.verifikator_2', 'hp.verifikator_3', 'hp.verifikator_4', 'hp.verifikator_5', 'hp.verifikator_6', 'hp.check_surat_permintaan_pembayaran_spp', 'hp.check_rab', 'hp.check_pernyataan_pertanggungjawaban', 'hp.check_belanja_dpa', 'hp.check_lapor_pertanggungjawaban', 'hp.check_patuh_kebijakan', 'hp.check_sk_tim_pelaksana', 'hp.check_sk_dasar_kegiatan', 'hp.anggaran_setuju')
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
