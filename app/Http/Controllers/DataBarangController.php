<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables as DataTables;

class DataBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $kategori = Kategori::all();
        return view('master-data.data-barang', compact('kategori'));
    }

    public function getDataBarang(Request $request, DataBarang $databarang)
    {

        $data = DataBarang::all();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('Actions', function ($data) {
                    return '<button type="button" class="btn btn-success btn-sm" id="getEditArticleData" data-id="' . $data->id . '">Edit</button>
                    <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
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
    public function store(Request $request, DataBarang $databarang)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'harga_barang' => 'required',
            'stok_barang' => 'required',
            // 'kategori_id' => 'required',
            // 'image' => '',
        ]);

        // if ($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('data-images');
        // }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // dd($request->all());
        $databarang->storeData($request->all());

        return response()->json(['success' => 'Article added successfully']);
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

        $databarang = new DataBarang;
        $data = $databarang->findData($id);

        $html = '<div class="form-group">
                    <label for="nama_barang">Nama Produk:</label>
                    <input type="text" class="form-control" name="nama_barang" id="editNamaBarang" value="' . $data->nama_barang . '">
                </div>
                <div class="form-group">
                    <label for="harga_barang">Harga:</label>
                    <input type="text" class="form-control" name="harga_barang" id="editHargaBarang" value="' . $data->harga_barang . '">
                </div>
                <div class="form-group">
                    <label for="stok_barang">Stok:</label>
                    <input type="text" class="form-control" name="stok_barang" id="editStokBarang" value="' . $data->stok_barang . '">
                </div>';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'harga_barang' => 'required',
            'stok_barang' => 'required',
            'kategori_id' => '',
            'image' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $databarang = new DataBarang;
        $databarang->updateData($id, $request->all());

        return response()->json(['success' => 'Article updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    { {
            $databarang = new DataBarang;
            $databarang->deleteData($id);

            // return redirect('data-barang')->with(['success' => 'Berhasil Hapus Data']);
            return response()->json(['success' => 'Article deleted successfully']);
        }
    }
}
