<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Verifikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $nav;

    public function __construct()
    {
        $this->nav = 'master-user';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.user.index', ['nav' => $this->nav]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.add', ['nav' => $this->nav,]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'role_id' => 'required',
        ]);

        try {
            $user = User::insert([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'password' => Hash::make('12345678'),
                'role_id' => $request->input('role_id'),
                'kode_desa' => $request->input('kode_desa') ?? null,
            ]);

            dd($user);
            
            if($request->input("role_id") == 2){

                Verifikator::insert([
                    'user_id' => $user->id,
                ]);

            }

            Session::flash('message', 'Berhasil tambah user');
            Session::flash('alert-class', 'alert-success');

            return redirect('/admin/master-user');
        } catch (\Throwable $th) {
            return redirect('/admin/master-user/tambah-user')->withErrors($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'unique:users,username,' . $id . ',id',
            'role_id' => 'required'
        ]);

        try {
            $user = User::find($id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getUserJSON(Request $request)
    {

        $columns = array(
            0 => 'no',
            1 => 'name',
            2 => 'username',
            3 => 'role',
            4 => 'nama_desa',
            5 => 'action',
        );
        $user = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->leftJoin('desas', 'users.kode_desa', '=', 'desas.kode_desa')
            ->select('users.*', 'roles.role', 'desas.nama_desa')
            ->whereNot('role_id', '=', '1');

        $totalData = $user->count();

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
            $users = $user->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $users = $user->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%")
                    ->orWhere('nama_desa', 'LIKE', "%{$search}%")
                    ->orWhere('role', 'LIKE', "%{$search}%");
            })->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();

            $totalFiltered = $user->where('name', 'LIKE', "%{$search}%")
                ->orWHere('username', 'LIKE', "%{$search}%")
                ->orWHere('nama_desa', 'LIKE', "%{$search}%")
                ->orWHere('role', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->count();
        }

        $data = array();
        if (!empty($users)) {
            $i = $start + 1;
            foreach ($users as $user) {
                $nestedData['no'] = $i;
                $nestedData['name'] = $user->name;
                $nestedData['username'] = $user->username;
                $nestedData['role'] = $user->role;
                $nestedData['nama_desa'] = $user->nama_desa;
                $nestedData['action'] = "<a href='" . url('/admin/master-user/edit') . '/' . $user->id . "' title='EDIT' data='{$user->id}' class='btn btn-primary btn-sm'><i class='fa fa-pen'></i></a>
                <a href='javascript:void(0)' title='HAPUS' data-id='{$user->id}' id='btn-hapus' class='btn btn-danger btn-sm'><i class='fa fa-trash'></i></a>
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

    public function getUserById(Request $request)
    {

        $id = $request->input('id');
        $user = User::where('id', $id)->first();

        echo json_encode($user);
    }

    public function deleteUserById(Request $request)
    {
        DB::table('users')
            ->where('id', $request->input('id'))
            ->delete();

        return response()->json([
            'message' => 'Sukses hapus data'
        ]);
    }
}
