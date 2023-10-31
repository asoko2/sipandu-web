<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggaran;
use App\Http\Requests\StoreAnggaranRequest;
use App\Http\Requests\UpdateAnggaranRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AnggaranController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'master-anggaran';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.anggaran.index', ['nav' => $this->nav]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnggaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnggaranRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anggaran  $anggaran
     * @return \Illuminate\Http\Response
     */
    public function show(Anggaran $anggaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anggaran  $anggaran
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $anggaran = DB::table('anggarans')
            ->leftJoin('desas', 'anggarans.kode_desa', '=', 'desas.kode_desa')
            ->select('anggarans.*', 'desas.nama_desa')
            ->where('anggarans.id', $id)
            ->first();

        return view('admin.anggaran.edit', [
            'nav' => $this->nav,
            'data' => $anggaran,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnggaranRequest  $request
     * @param  \App\Models\Anggaran  $anggaran
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAnggaranRequest $request, $id)
    {
        $request->validate([
            'total_anggaran' => 'required',
        ]);

        try {
            $anggaran = Anggaran::find($id);

            $b = str_replace(".", "", $request->total_anggaran);
            $total_anggaran = str_replace(",", ".", $b);

            $anggaran->total_anggaran = $total_anggaran;
            $anggaran->save();

            Session::flash('message', 'Berhasil edit anggaran');
            Session::flash('alert-class', 'alert-success');

            return redirect('/admin/master-anggaran/');
        } catch (\Throwable $th) {
            return redirect('/admin/master-anggaran/edit/' . $id)->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anggaran  $anggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Anggaran $anggaran)
    {
        //
    }

    public function getAnggaranJSON(Request $request)
    {

        $columns = array(
            0 => 'no',
            1 => 'desa',
            2 => 'total_anggaran',
            3 => 'tahun_anggaran',
            4 => 'action',
        );
        $anggaran = DB::table('anggarans')
            ->leftJoin('desas', 'anggarans.kode_desa', '=', 'desas.kode_desa')
            ->select('anggarans.*', 'desas.nama_desa');

        $totalData = $anggaran->count();

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
            $anggarans = $anggaran->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $anggarans = $anggaran->where(function ($query) use ($search) {
                $query->where('name_desa', 'LIKE', "%{$search}%");
            })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = $anggaran->where('nama_desa', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->count();
        }

        $data = array();
        if (!empty($anggarans)) {
            $i = $start + 1;
            foreach ($anggarans as $anggaran) {
                $nestedData['no'] = $i;
                $nestedData['nama_desa'] = $anggaran->nama_desa;
                $nominal = number_format($anggaran->total_anggaran, 2, ',', '.');
                $nestedData['total_anggaran'] = $nominal;
                $nestedData['tahun_anggaran'] = $anggaran->tahun_anggaran;
                $nestedData['action'] = "<a href='" . url('/admin/master-anggaran/edit') . '/' . $anggaran->id . "' title='EDIT' data='{$anggaran->id}' class='btn btn-primary btn-sm'><i class='fa fa-pen'></i></a>
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

    public function getAnggaranById(Request $request)
    {

        $id = $request->input('id');
        $anggaran = Anggaran::where('id', $id)->first();

        echo json_encode($anggaran);
    }
}
