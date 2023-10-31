<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class VerifikasiController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'verifikasi';
    }

    public function index()
    {
        return view('verifikator.verifikasi.index', ['nav' => $this->nav]);
    }

    public function setuju($id)
    {
        $ajuan = Ajuan::find($id);

        return view('verifikator.verifikasi.setuju', [
            'nav' => $this->nav,
            'data' => $ajuan
        ]);
    }

    public function verifikasi(Request $request, $id)
    {
        $ajuan = Ajuan::find($id);

        $requestUrl = $request->getRequestUri();
        $urlArray = explode('/', $requestUrl);

        if($urlArray[3] === 'setuju'){
            $ajuan->status = 2;
        }else{
            $ajuan->status = 3;
        }
        
        $ajuan->catatan = $request->catatan;

        try {
            $ajuan->save();

            Session::flash('message', 'Berhasil setujui pengajuan ' . $ajuan->kode_pengajuan);
            Session::flash('alert-class', 'alert-success');

            return redirect('/verifikator/verifikasi');
        } catch (\Throwable $th) {
            return redirect()->to('/verifikator/verifikasi/setuju/' . $id)->withErrors($th->getMessage());
        }
    }


    public function getAjuanVerifikasiJSON(Request $request)
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
            8 => 'action',
        );
        $ajuan = DB::table('ajuans')
            ->join('desas', 'ajuans.kode_desa', '=', 'desas.kode_desa')
            ->join('users', 'ajuans.user_id', '=', 'users.id')
            ->select('ajuans.*', 'desas.nama_desa', 'users.name')
            ->where('status', 1);

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
            $ajuans = $ajuan->offset($start)
                ->limit($limit)
                ->orderBy('status', 'asc')
                ->get();
        } else {
            $ajuans = $ajuan->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('nama_desa', 'LIKE', "%{$search}%")
                    ->orWhere('kode_pengajuan', 'LIKE', "%{$search}%");
            })->offset($start)
                ->limit($limit)
                ->orderBy('status', 'asc')
                ->get();

            $totalFiltered = $ajuan->where('name', 'LIKE', "%{$search}%")
                ->orWhere('kode_pengajuan', 'LIKE', "%{$search}%")
                ->orWhere('nama_desa', 'LIKE', "%{$search}%")
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
                $nestedData['action'] = "
                <a href='" . url('/verifikator/verifikasi/setuju') . '/' . $ajuan->id . "' title='SETUJU' data='{$ajuan->id}' class='btn btn-success btn-sm'><i class='fa fa-check'></i></a>&nbsp
                <a href='" . url('/verifikator/verifikasi/tolak') . '/' . $ajuan->id . "' title='TOLAK' data='{$ajuan->id}' class='btn btn-danger btn-sm'><i class='fa fa-times'></i></a>&nbsp
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
