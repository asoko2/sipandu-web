<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class RekapController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'rekap-pengajuan';
    }

    public function index()
    {
        return view('admin.rekap.index', [
            'nav' => $this->nav
        ]);
    }

    public function getAjuanRekapJSON(Request $request)
    {
        $columns = array(
            0 => 'no',
            1 => 'tanggal_pengajuan',
            2 => 'surat_permintaan_pembayaran_spp',
            3 => 'rab',
            4 => 'pernyataan_pertanggung_jawaban',
            5 => 'dpa',
            6 => 'sk_tim_pelaksana',
            7 => 'sk_dasar_kegiatan',
            8 => 'spj',
            9 => 'action',
        );
        $ajuan = DB::table('ajuans')
            ->join('desas', 'ajuans.kode_desa', '=', 'desas.kode_desa')
            ->join('users', 'ajuans.user_id', '=', 'users.id')
            ->select('ajuans.*', 'desas.nama_desa', 'users.name');

        $totalData = $ajuan->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $search = $request->input('search.value');

        if ($request->input('order.0.column')) {
            $order = $columns[$request->input('order.0.column')];
        } else {
            $order = 'id';
        }
        if ($request->input('order.0.dir')) {
            $dir = $request->input('order.0.dir');
        } else {
            $dir = 'desc';
        }

        if (empty($search)) {
            $ajuans = $ajuan
                ->whereNot('status', '1')
                ->whereNot('status', '4')
                ->offset($start)
                ->limit($limit)
                ->orderBy('status', 'asc')
                ->get();
        } else {
            $ajuans = $ajuan->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('nama_desa', 'LIKE', "%{$search}%")
                    ->orWhere('kode_pengajuan', 'LIKE', "%{$search}%")
                    ->whereNot('status', '=', '1')
                    ->whereNot('status', '=', '4');
            })->offset($start)
                ->limit($limit)
                ->orderBy('status', 'asc')
                ->get();

            $totalFiltered = $ajuan->where('name', 'LIKE', "%{$search}%")
                ->orWhere('kode_pengajuan', 'LIKE', "%{$search}%")
                ->orWhere('nama_desa', 'LIKE', "%{$search}%")
                ->whereNot('status', '1')
                ->whereNot('status', '4')
                ->offset($start)
                ->limit($limit)
                ->orderBy('status', 'asc')
                ->count();
        }

        $data = array();
        if (!empty($ajuans)) {
            $i = $start + 1;
            foreach ($ajuans as $ajuan) {
                // dd($ajuan);
                $nestedData['no'] = $i;
                $nestedData['kode_pengajuan'] = $ajuan->kode_pengajuan;
                $nestedData['name'] = $ajuan->name;
                $nestedData['nama_desa'] = $ajuan->nama_desa;
                $nestedData['surat_permintaan_pembayaran_spp'] = '<a href="' . URL::to('/') . '/storage/files/' . $ajuan->surat_permintaan_pembayaran_spp . '" target="_blank">Surat Permintaan Pembayaran SPP</a>';
                $nestedData['rab'] = '<a href="' . URL::to('/') . '/storage/files/' . $ajuan->rab . '" target="_blank">RAB</a>';
                $nestedData['pernyataan_pertanggungjawaban'] = '<a href="' . URL::to('/') . '/storage/files/' . $ajuan->pernyataan_pertanggungjawaban . '" target="_blank">Pernyataan Pertanggungjawaban</a>';
                $nestedData['belanja_dpa'] = '<a href="' . URL::to('/') . '/storage/files/' . $ajuan->belanja_dpa . '" target="_blank">Belanja DPA</a>';
                $nestedData['sk_tim_pelaksana'] = '<a href="' . URL::to('/') . '/storage/files/' . $ajuan->sk_tim_pelaksana . '" target="_blank">SK Tim Pelaksana</a>';
                $nestedData['sk_dasar_kegiatan'] = '<a href="' . URL::to('/') . '/storage/files/' . $ajuan->sk_dasar_kegiatan . '" target="_blank">SK Dasar Kegiatan</a>';
                $nestedData['spj'] = '<a href="' . URL::to('/') . '/storage/files/' . $ajuan->spj . '" target="_blank">SPJ</a>';
                if ($ajuan->status == 0) {
                    $status = 'Belum Diajukan';
                } else if ($ajuan->status == 1) {
                    $status = 'Dikirim';
                } else if ($ajuan->status == 2) {
                    $status = 'Layak / Memenuhi Syarat';
                } else if ($ajuan->status == 3) {
                    $status = 'Tidak Layak';
                } else {
                    $status = 'Dibatalkan';
                }
                $nestedData['status'] = $status;
                $nestedData['action'] = "
                <a href='" . route('cetak-verifikasi-ajuan', $ajuan->id) . "' class='btn btn-primary' title='DOWNLOAD' target='_blank'><i class='fa fa-download'></i></a>
                ";

                $data[] = $nestedData;
                $i++;
            }
        }



        $json_data = array(
            "draw"              => intval($request->input('draw')),
            "recordsTotal"      => intval($totalData),
            "recordsFiltered"   => intval($totalFiltered),
            "data"              => $data
        );

        echo json_encode($json_data);
    }
}
