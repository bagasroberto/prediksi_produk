<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataBarangDiscController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $barang = DataBarang::where('status', 'aktif')->get();
            return DataTables::of($barang)
                ->addIndexColumn()
                ->addColumn('nama_barang', function ($row) {
                    return ucfirst($row->nama_barang);
                })
                ->addColumn('stok_barang', function ($row) {
                    return ucfirst($row->stok_barang);
                })
                ->addColumn('stok_rusak', function ($row) {
                    if ($row->stok_rusak == null) {
                        return 0;
                    }else{
                        return $row->stok_rusak;
                    }
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 'aktif') {
                        return '<div class="badge badge-success">' . ucfirst($row->status) . '</div>';
                    } else {
                        return '<div class="badge badge-danger">' . ucfirst($row->status) . '</div>';
                    }
                })
                ->addColumn('action', function ($row) {

                    $btn = '<button id="edit-barangDisc" data-id="' . $row->id . '" class="btn btn-primary btn-sm edit-barangDisc" data-original-title="Edit">EDIT</button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('master-data.data-barangDisc');
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
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'stok_rusak' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //Update Data Barang Discontinue
        $data_barang = DataBarang::find($request->id);
        $stok_rusak = $data_barang->stok_barang - $request->stok_rusak;

        $data_barang->updateOrCreate([
            'id' => $request->id
        ], [
            'stok_barang' => $stok_rusak,
            'stok_rusak' => $data_barang->stok_rusak + $request->stok_rusak,
        ]);

        //return response
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data_barangDisc = DataBarang::find($id);
        return response()->json($data_barangDisc);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
