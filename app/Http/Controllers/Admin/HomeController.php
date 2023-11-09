<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use Illuminate\Http\Request;
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
        $nama_desa = getListNamaDesa();
        $anggaran_desa = getListAnggaranDesa();
        $realisasi_desa = getListRealisasiDesa();

        return view('admin.home.index', [
            'nav' => $this->nav,
            'nama_desa' => $nama_desa,
            'anggaran_desa' => $anggaran_desa,
            'realisasi_desa' => $realisasi_desa,
        ]);
    }

}
