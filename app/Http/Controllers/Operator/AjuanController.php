<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use App\Http\Requests\StoreAjuanRequest;
use App\Http\Requests\UpdateAjuanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class AjuanController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'pengajuan';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('operator.ajuan.index', ['nav' => $this->nav]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operator.ajuan.add', ['nav' => $this->nav]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAjuanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAjuanRequest $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        // dd($request);
        $validated = $request->validated();

        $suratPermintaanPembayaranSPPName = $this->setFileName($request->file('suratPermintaanPembayaranSPP'));
        $rabName = $this->setFileName($request->file('rab'));
        $pernyataanPertanggungJawabanName = $this->setFileName($request->file('pernyataanPertanggungJawaban'));
        $dpaName = $this->setFileName($request->file('dpa'));
        $skTimPelaksanaName = $this->setFileName($request->file('skTimPelaksana'));
        $skDasarKegiatanName = $this->setFileName($request->file('skDasarKegiatan'));
        $spjName = $this->setFileName($request->file('spj'));

        $lastId = Ajuan::orderBy('id', 'desc')->first();

        if (!$lastId) {
            $ajuanNumber = sprintf("%010d", 1);
        } else {
            $ajuanNumber = sprintf("%010d", $lastId->id + 1);
        }

        $kodePengajuan = 'AJP' . $ajuanNumber;

        // Save file
        $request->file('suratPermintaanPembayaranSPP')->storeAs('public/files', $suratPermintaanPembayaranSPPName);
        $request->file('rab')->storeAs('public/files', $rabName);
        $request->file('pernyataanPertanggungJawaban')->storeAs('public/files', $pernyataanPertanggungJawabanName);
        $request->file('dpa')->storeAs('public/files', $dpaName);
        $request->file('skTimPelaksana')->storeAs('public/files', $skTimPelaksanaName);
        $request->file('skDasarKegiatan')->storeAs('public/files', $skDasarKegiatanName);
        $request->file('spj')->storeAs('public/files', $spjName);

        if ($validated) {
            try {

                $b = str_replace(".", "", $request->anggaran);
                $anggaran = str_replace(",", ".", $b);

                Ajuan::insert([
                    'user_id' => Auth::user()->id,
                    'kode_desa' => Auth::user()->kode_desa,
                    'kode_pengajuan' => $kodePengajuan,
                    'surat_permintaan_pembayaran_spp' => $suratPermintaanPembayaranSPPName,
                    'rab' => $rabName,
                    'pernyataan_pertanggungjawaban' => $pernyataanPertanggungJawabanName,
                    'belanja_dpa' => $dpaName,
                    'sk_tim_pelaksana' => $skTimPelaksanaName,
                    'sk_dasar_kegiatan' => $skDasarKegiatanName,
                    'spj' => $spjName,
                    'anggaran' => $anggaran,
                    'tanggal_ajuan' => date('Y-m-d')
                ]);

                Session::flash('message', 'Berhasil input pengajuan');
                Session::flash('alert-class', 'alert-success');

                return redirect('/operator/pengajuan');
            } catch (\Throwable $th) {
                return redirect('/operator/pengajuan/tambah-pengajuan')->withErrors($th->getMessage());
            }
        } else {
            return redirect('/operator/pengajuan/tambah-pengajuan')->withErrors($validated);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ajuan  $ajuan
     * @return \Illuminate\Http\Response
     */
    public function show(Ajuan $ajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ajuan  $ajuan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ajuan = Ajuan::where('id', $id)->first();

        return view('operator.ajuan.edit', [
            'nav' => $this->nav,
            'data' => $ajuan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAjuanRequest  $request
     * @param  \App\Models\Ajuan  $ajuan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAjuanRequest $request, $id)
    {
        $ajuan = Ajuan::find($id);

        if ($request->suratPermintaanPembayaranSPP) {
            $suratPermintaanPembayaranSPPName = $this->setFileName($request->file('suratPermintaanPembayaranSPP'));
            Storage::delete('public/files/' . $ajuan->surat_permintaan_pembayaran_spp);
            $request->file('suratPermintaanPembayaranSPP')->storeAs('public/files', $suratPermintaanPembayaranSPPName);
            $ajuan->surat_permintaan_pembayaran_spp = $suratPermintaanPembayaranSPPName;
        }

        if ($request->rab) {
            $rabName = $this->setFileName($request->file('rab'));
            Storage::delete('public/files/' . $ajuan->rab);
            $request->file('rab')->storeAs('public/files', $rabName);
            $ajuan->rab = $rabName;
        }

        if ($request->pernyataanPertanggungJawaban) {
            $pernyataanPertanggungJawabanName = $this->setFileName($request->file('pernyataanPertanggungJawaban'));
            Storage::delete('public/files/' . $ajuan->pernyaaan_pertanggungjawaban);
            $request->file('pernyataanPertanggungJawaban')->storeAs('public/files', $pernyataanPertanggungJawabanName);
            $ajuan->pernyataan_pertanggungjawaban = $pernyataanPertanggungJawabanName;
        }

        if ($request->dpa) {
            $dpaName = $this->setFileName($request->file('dpa'));
            Storage::delete('public/files/' . $ajuan->belanja_dpa);
            $request->file('dpa')->storeAs('public/files', $dpaName);
            $ajuan->belanja_dpa = $dpaName;
        }

        if ($request->skTimPelaksana) {
            $skTimPelaksanaName = $this->setFileName($request->file('skTimPelaksana'));
            Storage::delete('public/files/' . $ajuan->sk_tim_pelaksana);
            $request->file('skTimPelaksana')->storeAs('public/files', $skTimPelaksanaName);
            $ajuan->sk_tim_pelaksana = $skTimPelaksanaName;
        }

        if ($request->skDasarKegiatan) {
            $skDasarKegiatanName = $this->setFileName($request->file('skDasarKegiatan'));
            Storage::delete('public/files/' . $ajuan->sk_dasar_kegiatan);
            $request->file('skDasarKegiatan')->storeAs('public/files', $skDasarKegiatanName);
            $ajuan->sk_dasar_kegiatan = $skDasarKegiatanName;
        }

        if ($request->spj) {
            $spjName = $this->setFileName($request->file('spj'));
            Storage::delete('public/files/' . $ajuan->spj);
            $request->file('spj')->storeAs('public/files', $spjName);
            $ajuan->spj = $spjName;
        }

        try {

            $b = str_replace(".", "", $request->anggaran);
            $anggaran = str_replace(",", ".", $b);
            $ajuan->anggaran = $anggaran;

            $ajuan->save();

            Session::flash('message', 'Berhasil edit pengajuan ' . $ajuan->kode_pengajuan);
            Session::flash('alert-class', 'alert-success');

            return redirect()->to('/operator/pengajuan');
        } catch (\Throwable $th) {
            return redirect()->to('/operator/pengajuan/edit/' . $id)->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ajuan  $ajuan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ajuan $ajuan)
    {
        //
    }

    public function setFileName($file)
    {
        $oriName = $file->getClientOriginalName();
        $trimmedName = str_replace(" ", "_", $oriName);
        $random = rand(1111111111, 9999999999);
        $date = date_timestamp_get(date_create());
        return $date . '_' . $random . '_' . $trimmedName;
    }

    public function getAjuanJSON(Request $request)
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
            ->select('ajuans.*', 'desas.nama_desa', 'users.name')
            ->where('ajuans.user_id', Auth::user()->id);

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
                $nestedData['spj'] = '<a href="' . URL::to('/') . '/storage/files/' . $ajuan->spj . '" target="_blank">SPJ</a>';
                $nestedData['anggaran'] = 'Rp. ' . number_format($ajuan->anggaran, 2, '.', ',');
                if ($ajuan->status == 0) {
                    $status = 'Belum Diajukan';
                } else if ($ajuan->status == 1) {
                    $status = 'Dikirim';
                } else if ($ajuan->status == 2) {
                    // $status = 'Layak / Memenuhi Syarat';
                    $status = 'Proses Verifikasi';
                } else if ($ajuan->status == 3) {
                    $status = 'Diverifikasi';
                // } else {
                //     $status = 'Dibatalkan';
                }
                $nestedData['status'] = $status;
                if ($ajuan->status == 0) {
                    $action = "
                    <a href='javascript:void(0)' title='KIRIM' data-id='{$ajuan->id}' id='btn-kirim' class='btn btn-success btn-sm'><i class='fa fa-paper-plane'></i></a>&nbsp;
                    <a href='" . url('/operator/pengajuan/edit') . '/' . $ajuan->id . "' title='EDIT' data='{$ajuan->id}' class='btn btn-primary btn-sm'><i class='fa fa-pen'></i></a>&nbsp;
                    <a href='javascript:void(0)' title='BATALKAN' data-id='{$ajuan->id}' id='btn-cancel' class='btn btn-danger btn-sm'><i class='fa fa-ban'></i></a>
                    ";
                } else if ($ajuan->status == 2) {
                    $action = "
                    <a href='" . url('/operator/pengajuan/detail') . '/' . $ajuan->id . "' title='DETAIL' data-id='{$ajuan->id}' id='btn-detail' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>&nbsp;
                    ";
                } else {
                    $action = '';
                }
                $nestedData['action'] = $action;

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

    public function getAjuanById(Request $request)
    {

        $id = $request->input('id');
        $ajuan = Ajuan::where('id', $id)->first();

        echo json_encode($ajuan);
    }

    public function kirimAjuanById(Request $request)
    {
        $ajuan = Ajuan::find($request->input('id'));
        $ajuan->status = 1;
        try {
            //code...
            $ajuan->save();
            return response()->json([
                'message' => 'Sukses kirim pengajuan'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function cancelAjuanById(Request $request)
    {
        $ajuan = Ajuan::find($request->input('id'));
        $ajuan->status = 4;
        try {
            //code...
            $ajuan->save();
            return response()->json([
                'message' => 'Sukses hapus data'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
