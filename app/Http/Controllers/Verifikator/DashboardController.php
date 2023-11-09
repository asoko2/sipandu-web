<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'dashboard';
    }

    public function index()
    {
        $nama_desa = getListNamaDesa();
        $anggaran_desa = getListAnggaranDesa();
        $realisasi_desa = getListRealisasiDesa();

        return view('verifikator.home.index', [
            'nav' => $this->nav,
            'nama_desa' => $nama_desa,
            'anggaran_desa' => $anggaran_desa,
            'realisasi_desa' => $realisasi_desa,
        ]);
    }
}
