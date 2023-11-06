<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Verifikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingVerifikatorController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'setting-verifikator';
    }

    public function index()
    {
        return view('admin.setting-verifikator.index', [
            'nav' => $this->nav,
        ]);
    }

    public function create()
    {
        $lastVerifikator = DB::table('verifikators')->orderBy('id', 'desc')->limit(1)->first();

        $lastVerifikatorNumber = 0;

        if ($lastVerifikator) {
            $lastVerifikatorNumber = $lastVerifikator->no += 1;
        } else {
            $lastVerifikatorNumber = 1;
        }

        return view('admin.setting-verifikator.add', [
            'nav' => $this->nav,
            'lastVerifikatorNumber' => $lastVerifikatorNumber,
        ]);
    }

    public function store(Request $request)
    {
        try {
            Verifikator::insert([
                'no' => $request->input('no'),
                'user_id' => $request->input('user_id'),
            ]);

            Session::flash('message', 'Berhasil tambah verifikator');
            Session::flash('alert-class', 'alert-success');

            return redirect('/admin/setting-verifikator');
        } catch (\Throwable $th) {
            return redirect('/admin/setting-verifikator/tambah-verifikator')->withErrors($th->getMessage());
        }
    }

    public function assign($id)
    {
        $verifikator = Verifikator::find($id);

        return view('admin.setting-verifikator.assign', [
            'nav' => $this->nav,
            'data' => $verifikator,
        ]);
    }

    public function doAssign(Request $request, $id)
    {

        $verifikator = Verifikator::find($id);

        $verifikator->user_id = $request->user_id;

        try {
            $verifikator->save();

            Session::flash('message', 'Berhasil Assign Verifikator No.' . $verifikator->no);
            Session::flash('alert-class', 'alert-success');

            return redirect('/admin/setting-verifikator');
        } catch (\Throwable $th) {
            Session::flash('message', $th->getMessage());
            Session::flash('alert-class', 'alert-danger');
            return redirect('/admin/setting-verifikator/assign' . $id)->withErrors($th->getMessage());
        }
    }

    public function getVerifikatorJSON(Request $request)
    {

        $columns = array(
            0 => 'no',
            1 => 'name',
            2 => 'action',
        );
        $verifikator = DB::table('verifikators')
            ->leftJoin('users', 'verifikators.user_id', '=', 'users.id')
            ->select('verifikators.*', 'users.name', 'users.role_id');

        $totalData = $verifikator->count();

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
            $verifikators = $verifikator->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $verifikators = $verifikator->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('no', 'LIKE', "%{$search}%");
            })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = $verifikator->where('name', 'LIKE', "%{$search}%")
                ->orWHere('no', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->count();
        }

        $data = array();
        if (!empty($verifikators)) {
            $i = $start + 1;
            foreach ($verifikators as $verifikator) {
                $nestedData['no'] = $i;
                $nestedData['name'] = $verifikator->name;
                if ($verifikator->name) {
                    $title = "UBAH VERIFIKATOR";
                } else {
                    $title = "ASSIGN VERIFIKATOR";
                }
                $nestedData['action'] = "<a href='" . url('/admin/setting-verifikator/assign') . '/' . $verifikator->id . "' title='ASSIGN' data='{$verifikator->id}' class='btn btn-primary btn-sm'>$title</a>
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
