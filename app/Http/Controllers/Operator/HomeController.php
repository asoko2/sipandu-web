<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use App\Models\Anggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'dashboard';
    }

    public function index()
    {
        $total_anggaran = $this->getTotalAnggaran(Auth::user()->kode_desa);
        $total_realisasi = $this->getTotalRealisasi(Auth::user()->kode_desa);
        $total_ajuan = $this->getTotalAjuan(Auth::user()->kode_desa);


        return view('operator.home.index', [
            'nav' => $this->nav,
            'total_anggaran' => $total_anggaran,
            'total_realisasi' => $total_realisasi,
            'total_ajuan' => $total_ajuan,
        ]);
    }

    private function getTotalAnggaran($desa)
    {
        $anggaran = Anggaran::where('kode_desa', $desa)->first();

        return $anggaran->total_anggaran;
    }

    private function getTotalRealisasi($desa)
    {
        $hasil_pemeriksaan = DB::table('hasil_pemeriksaans as hp')
            ->select('hp.*', 'aj.kode_desa')
            ->join('ajuans as aj', 'hp.ajuan_id', '=', 'aj.id')
            ->where('aj.kode_desa', $desa)
            ->get();

        $realisasi = 0;
        foreach ($hasil_pemeriksaan as $h) {
            $realisasi += $h->anggaran_setuju;
        }

        return $realisasi;
    }

    private function getTotalAjuan($desa)
    {
        $total_ajuan = Ajuan::where('kode_desa', $desa)->count();

        return $total_ajuan;
    }

    public function readNotification(Request $request)
    {

        $notifications = DB::table('notifications')
            ->select('id')
            ->where('user_id', Auth::user()->id)
            ->where('read_at', null)
            ->get();

        foreach ($notifications as $notif => $id) {
            DB::table('notifications')
                ->where('id', $id->id)
                ->update(['status' => '1',]);
        }

        echo json_encode([
            'message' => 'success'
        ]);
    }
}
