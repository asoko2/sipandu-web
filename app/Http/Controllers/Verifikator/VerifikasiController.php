<?php

namespace App\Http\Controllers\Verifikator;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use App\Models\Verifikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function show($id)
    {
        $ajuan = DB::table('ajuans as a')
            ->select('a.*', 'd.nama_desa', 'u.name', 'ag.total_anggaran', 'hp.verifikator_1', 'hp.verifikator_2', 'hp.verifikator_3', 'hp.verifikator_4', 'hp.verifikator_5', 'hp.verifikator_6', 'hp.check_surat_permintaan_pembayaran_spp', 'hp.check_rab', 'hp.check_pernyataan_pertanggungjawaban', 'hp.check_belanja_dpa', 'hp.check_lapor_pertanggungjawaban', 'hp.check_patuh_kebijakan', 'hp.check_sk_tim_pelaksana', 'hp.check_sk_dasar_kegiatan', 'hp.anggaran_setuju')
            ->join('desas as d', 'a.kode_desa', '=', 'd.kode_desa')
            ->join('users as u', 'a.user_id', '=', 'u.id')
            ->join('anggarans as ag', 'a.kode_desa', '=', 'ag.kode_desa')
            ->leftJoin('hasil_pemeriksaans as hp', 'a.id', '=', 'hp.ajuan_id')
            ->where('a.id', $id)
            ->first();

        $hasil_pemeriksaan = DB::table('hasil_pemeriksaans')
            ->select('hasil_pemeriksaans.*', 'ajuans.kode_desa', 'desas.nama_desa')
            ->join('ajuans', 'hasil_pemeriksaans.ajuan_id', '=', 'ajuans.id')
            ->join('desas', 'ajuans.kode_desa', '=', 'desas.kode_desa')
            ->where('ajuans.kode_desa', $ajuan->kode_desa)
            ->get();

        $realisasi = 0;
        foreach ($hasil_pemeriksaan as $h) {
            $realisasi += $h->anggaran_setuju;
        }

        return view('verifikator.verifikasi.verif', [
            'nav' => $this->nav,
            'data' => $ajuan,
            'realisasi' => $realisasi,
        ]);
    }

    public function setuju($id)
    {
        $ajuan = Ajuan::find($id);

        return view('verifikator.verifikasi.setuju', [
            'nav' => $this->nav,
            'data' => $ajuan
        ]);
    }

    public function tolak($id)
    {
        $ajuan = Ajuan::find($id);

        return view('verifikator.verifikasi.tolak', [
            'nav' => $this->nav,
            'data' => $ajuan
        ]);
    }

    public function verifikasi(Request $request, $id)
    {
        $ajuan = Ajuan::find($id);

        $verifikator = DB::table('verifikators')->where('user_id', Auth::user()->id)->first();

        // dd($ajuan);
        // dd($request);
        // dd($verifikator);
        $b = str_replace(".", "", $request->anggaran_setuju);
        $anggaran_setuju = str_replace(",", ".", $b);

        try {
            $ajuanVerified = DB::table('hasil_pemeriksaans')->where('ajuan_id', $id)->first();

            $hasil_pemeriksaan_table = DB::table('hasil_pemeriksaans');

            if (!$ajuanVerified) {
                $hasil_pemeriksaan_table->insert([
                    'ajuan_id' => $ajuan->id,
                    'check_surat_permintaan_pembayaran_spp' => $request->input('check_surat_permintaan_pembayaran_spp'),
                    'check_rab' => $request->input('check_rab'),
                    'check_pernyataan_pertanggungjawaban' => $request->input('check_pernyataan_pertanggungjawaban'),
                    'check_belanja_dpa' => $request->input('check_belanja_dpa'),
                    'check_lapor_pertanggungjawaban' => $request->input('check_lapor_pertanggungjawaban'),
                    'check_patuh_kebijakan' => $request->input('check_patuh_kebijakan'),
                    'check_sk_tim_pelaksana' => $request->input('check_sk_tim_pelaksana'),
                    'check_sk_dasar_kegiatan' => $request->input('check_sk_dasar_kegiatan'),
                    'verifikator_' . $verifikator->no => $request->input('verifikasi') == 'on' ? 1 : null,
                    'anggaran_setuju' => $anggaran_setuju,
                ]);
            } else {
                $hasil_pemeriksaan_table->where('ajuan_id', $id)
                    ->update([
                        'ajuan_id' => $ajuan->id,
                        'check_surat_permintaan_pembayaran_spp' => $request->input('check_surat_permintaan_pembayaran_spp'),
                        'check_rab' => $request->input('check_rab'),
                        'check_pernyataan_pertanggungjawaban' => $request->input('check_pernyataan_pertanggungjawaban'),
                        'check_belanja_dpa' => $request->input('check_belanja_dpa'),
                        'check_lapor_pertanggungjawaban' => $request->input('check_lapor_pertanggungjawaban'),
                        'check_patuh_kebijakan' => $request->input('check_patuh_kebijakan'),
                        'check_sk_tim_pelaksana' => $request->input('check_sk_tim_pelaksana'),
                        'check_sk_dasar_kegiatan' => $request->input('check_sk_dasar_kegiatan'),
                        'verifikator_' . $verifikator->no => $request->input('verifikasi') == 'on' ? 1 : null,
                        'anggaran_setuju' => $anggaran_setuju,
                    ]);
            }

            DB::table('ajuans')
                ->where('id', $id)
                ->update([
                    'catatan' => $request->input('catatan')
                ]);

            Session::flash('message', 'Berhaisl verifikasi ajuan');
            Session::flash('alert-class', 'alert-info');

            return redirect('verifikator/verifikasi');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('verifikator/verifikasi/' . $id)->withErrors($th->getMessage());
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

        $no_verifikator = Verifikator::where('user_id', Auth::user()->id)->first()->no;

        // dd($no_verifikator);

        $data = array();
        if (!empty($ajuans)) {
            $i = $start + 1;
            foreach ($ajuans as $ajuan) {

                $hasil_pemeriksaan = DB::table('hasil_pemeriksaans')->where('ajuan_id', $ajuan->id)->first();

                if ($no_verifikator == 1) {
                    $verif = $hasil_pemeriksaan->verifikator_1 ?? 0;
                } else if ($no_verifikator == 2) {
                    $verif = $hasil_pemeriksaan->verifikator_2 ?? 0;
                } else if ($no_verifikator == 3) {
                    $verif = $hasil_pemeriksaan->verifikator_3 ?? 0;
                } else if ($no_verifikator == 4) {
                    $verif = $hasil_pemeriksaan->verifikator_4 ?? 0;
                } else if ($no_verifikator == 5) {
                    $verif = $hasil_pemeriksaan->verifikator_5 ?? 0;
                } else {
                    $verif = $hasil_pemeriksaan->verifikator_5 ?? 0;
                }

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

                if ($verif == 1) {
                    $status = 'Sudah Verifikasi';
                } else {
                    $status = 'Belum Verifikasi';
                }
                $nestedData['status'] = $status;
                $nestedData['action'] = "
                <a href='" . url('/verifikator/verifikasi/') . '/' . $ajuan->id . "' title='DETAIL' data='{$ajuan->id}' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>&nbsp
                ";
                // $nestedData['action'] = "
                // <a href='" . url('/verifikator/verifikasi/setuju') . '/' . $ajuan->id . "' title='SETUJU' data='{$ajuan->id}' class='btn btn-success btn-sm'><i class='fa fa-check'></i></a>&nbsp
                // <a href='" . url('/verifikator/verifikasi/tolak') . '/' . $ajuan->id . "' title='TOLAK' data='{$ajuan->id}' class='btn btn-danger btn-sm'><i class='fa fa-times'></i></a>&nbsp
                // ";

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
