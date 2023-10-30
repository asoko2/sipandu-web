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
        $user = DB::table('users')
            ->leftJoin('desas', 'users.kode_desa', '=', 'desas.kode_desa')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'desas.nama_desa', 'roles.role')
            ->where('users.id', $id)
            ->first();

        return view('admin.user.edit', [
            'nav' => $this->nav,
            'data' => $user,
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
            'name' => 'required',
            'username' => 'unique:users,username,' . $id . ',id',
            'role_id' => 'required'
        ]);

        try {
            $user = Anggaran::find($id);
            $user->name = $request->input('name');
            $user->username = $request->input('username');
            $user->role_id = $request->input('role_id');
            $user->kode_desa = $request->input('kode_desa') ?? null;
            $user->save();

            Session::flash('message', 'Berhasil edit user');
            Session::flash('alert-class', 'alert-success');

            return redirect('/admin/master-user/');
        } catch (\Throwable $th) {
            return redirect('/admin/master-user/edit/' . $id)->withErrors($th->getMessage());
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
                $nestedData['total_anggaran'] = $anggaran->total_anggaran;
                $nestedData['tahun_anggaran'] = $anggaran->tahun_anggaran;
                $nestedData['action'] = "<a href='" . url('/admin/master-anggaran/edit') . '/' . $anggaran->id . "' title='DETAIL' data='{$anggaran->id}' class='btn btn-primary btn-sm'><i class='fa fa-pen'></i></a>
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
