<?php

namespace App\Http\Controllers;

use App\Models\User;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $dataRole = User::leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*', 'roles.name', 'model_has_roles.*')
            ->get();

            // dd($dataRole);

            $users = User::all();
            // dd($users);
            return DataTables::of($dataRole)
                ->addColumn('name', function ($dataRole) {
                    return $dataRole->username;
                })
                ->addColumn('email', function ($dataRole) {
                    return $dataRole->email;
                })
                ->addColumn('role', function ($dataRole) {
                    // dd($dataRole);
                    return $dataRole->name;
                })
                ->addColumn('Actions', function ($data) {
                    return '<button type="button" class="btn btn-info btn-sm" id="getEditArticleData" data-id="' . $data->id . '">Edit</button>
                            <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
                })
                ->rawColumns(['Actions'])
                ->addIndexColumn()
                ->make(true);
        }

        $dataRoles = DB::table('model_has_roles')->select('*')->get();

        return view('master-data.user', compact('dataRoles'));

    }

    public function getDataUser(Request $request, User $user)
    {

        if ($request->ajax()) {
            $data = User::select('users.*', 'roles.id', 'model_has_roles.*')
                ->leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->get();
            return Datatables::of($data)
                ->addColumn('action', function ($data) {
                    $btn = '<button id="edit-supplier" data-id="' . $data->id . '" class="btn btn-primary btn-sm edit-supplier" data-original-title="Edit">EDIT</button>';
                    $btn = $btn . ' <button id="delete-supplier" data-id="' . $data->id . '" class="btn btn-danger btn-sm">DELETE</button>';

                    return $btn;
                })
                ->rawColumns(['Actions'])
                ->addIndexColumn()
                ->make(true);
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {

        $data = $request->all();

        $objects = $user;
        $objects->username = $request->username;
        $objects->email = $request->email;
        $objects->password = Hash::make($request->password);
        $objects->save();
        $objects->assignRole($request->role_id);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {

        $user = User::
        leftJoin('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->select('users.*', 'roles.name', 'model_has_roles.*')
        ->get();

        $data = $user->find($id);

        $html = '<div class="form-group">
                     <label for="username">Username:</label>
                     <input type="text" class="form-control" name="username" id="editUsername" value="' . $data->username . '">
                 </div>
                 <div class="form-group">
                     <label for="email">Email:</label>
                     <input type="email" class="form-control" name="email" id="editEmail" value="' . $data->email . '">
                 </div>
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select class="form-control" name="role_id" id="editRole">
                        <option value="admin-gudang" id="role_id">Admin Gudang</option>
                        <option value="penanggungjawab" id="role_id">Penanggung Jawab Gudang</option>
                        <option value="kepala-gudang" id="role_id">Kepala Gudang</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="text" class="form-control" name="password" id="editPassword" value="">
                </div>';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $data = $request->all();

        $objects = new User;
        $objects->username = $request->username;
        $objects->email = $request->email;
        $objects->password = Hash::make($request->password);

        $objects = User::find($id);
        $objects->update($data);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $objects->assignRole($request->role_id);

        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            $objects = User::find($id);
            $objects->delete($id);
            DB::table('model_has_roles')->where('model_id',$id)->delete();

            return response()->json(['success' => 'Article deleted successfully']);

        }

    }
}
