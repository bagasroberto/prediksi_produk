<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\Kategori;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();

        return view('master-data.kategori', compact('kategori'));
    }

    public function getDataKategori(Request $request, Kategori $kategori)
    {

        if ($request->ajax()) {
            $data = Kategori::select('*');
            return Datatables::of($data)
                ->addColumn('Actions', function ($data) {
                    return '<button type="button" class="btn btn-info btn-sm" id="getEditArticleData" data-id="' . $data->id . '">Edit</button>';
                    //    <!-- <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>'; -->
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
    public function store(Request $request, Kategori $kategori)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            // 'image' => '',
        ]);

        // if ($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('data-images');
        // }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $kategori->storeData($request->all());

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
        $kategori = new Kategori;
        $data = $kategori->findData($id);

        $html = '<div class="form-group">
                     <label for="nama_kategori">Nama Kategori:</label>
                     <input type="text" class="form-control" name="nama_kategori" id="editNamaKategori" value="' . $data->nama_kategori . '">
                 </div>';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(), [
            'nama_kategori' => '',
            // 'image' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // dd($validator);

        $kategori = new Kategori;
        $kategori->updateData($id, $request->all());

        return response()->json(['success' => 'Article updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            $kategori = new Kategori;
            $kategori->deleteData($id);

            // return redirect('data-barang')->with(['success' => 'Berhasil Hapus Data']);
            return response()->json(['success' => 'Article deleted successfully']);

        }
    }
}
