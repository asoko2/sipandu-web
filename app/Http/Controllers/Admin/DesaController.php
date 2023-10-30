<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Desa;
use App\Http\Requests\StoreDesaRequest;
use App\Http\Requests\UpdateDesaRequest;
use Illuminate\Support\Facades\DB;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.desa.index');
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
     * @param  \App\Http\Requests\StoreDesaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDesaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Desa  $desa
     * @return \Illuminate\Http\Response
     */
    public function show(Desa $desa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Desa  $desa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $desa = Desa::where('id', $id)->first();

        return view('admin.desa.edit', [
            'nav' => 'desa',
            'data' => $desa,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDesaRequest  $request
     * @param  \App\Models\Desa  $desa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDesaRequest $request, $id)
    {
        try {
            $desa = Desa::find($id);
            $desa->nama_desa = $request->input('nama_desa');
            $desa->save();

            return redirect('/admin/master-desa/edit/' . $id);
        } catch (\Throwable $th) {
            return redirect('/admin/master-desa/edit/' . $id)->withErrors($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Desa  $desa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Desa $desa)
    {
        //
    }

    public function getDesaJSON(StoreDesaRequest $request)
    {

        $columns = array(
            0 => 'no',
            1 => 'kode_desa',
            2 => 'nama_desa',
            3 => 'action',
        );
        $desa = DB::table('desas')
            ->select('*');

        $totalData = $desa->count();

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
            $desas = $desa->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $desas = $desa->where(function ($query) use ($search) {
                $query->where('nama_desa', 'LIKE', "%{$search}%")
                    ->orWhere('kode_desa', 'LIKE', "%{$search}%");
            })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = $desa->where('nama_desa', 'LIKE', "%{$search}%")
                ->orWHere('kode_desa', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->count();
        }

        $data = array();
        if (!empty($desas)) {
            $i = $start + 1;
            foreach ($desas as $desa) {
                $nestedData['no'] = $i;
                $nestedData['kode_desa'] = $desa->kode_desa;
                $nestedData['nama_desa'] = $desa->nama_desa;
                $nestedData['action'] = "<a href='" . url('/admin/master-desa/edit') . '/' . $desa->id . "' title='DETAIL' data='{$desa->id}' class='btn btn-primary btn-sm'><i class='fa fa-pen'></i></a>
                <a href='javascript:void(0)' title='HAPUS' data-id='{$desa->id}' id='btn-hapus' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
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
