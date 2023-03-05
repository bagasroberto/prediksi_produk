<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\Kategori;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DataBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $kategori = Kategori::all();
        $databarang = DataBarang::all();
        return view('master-data.data-barang', compact('kategori', 'databarang'));

    }

    public function getDataBarang(Request $request, DataBarang $databarang)
    {

        if ($request->ajax()) {
            $data = DataBarang::select('*');
            return Datatables::of($data)
                ->addColumn('statusBadge', function ($row) {
                    if ($row->status == 'aktif') {
                        $status = '<button style="pointer-events:none" class="btn btn-success btn-sm">Aktif</button>';
                    } else {
                        $status = '<button style="pointer-events:none" class="btn btn-danger btn-sm">Non Aktif</button>';
                    }
                    return $status;
                })
                ->addColumn('Actions', function ($data) {
                    return '<button type="button" class="btn btn-info btn-sm" id="getEditArticleData" data-id="' . $data->id . '">Edit</button>';
                    //    <!-- <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>'; -->
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->get('filter_status') == 'non-aktif' || $request->get('filter_status') == 'aktif') {
                        $instance->where('status', $request->get('filter_status'));
                    }
                })
                ->rawColumns(['Actions', 'statusBadge', 'filter_status'])
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
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'harga_barang' => 'required',
            'stok_barang' => 'required',
            'kategori_id' => 'required',
            'status' => 'required',
            // 'image' => '',
        ]);

        // if ($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('data-images');
        // }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

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

        $datakategori = new Kategori;
        $kategoriAll = Kategori::all();
        // $kategori = $datakategori->findData($id);

        $dtKategori = Kategori::where('id', $data->kategori_id)->get();

        // dd($dtKategori);

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
                 </div>
                 <div class="form-group">
                        <label for="exampleFormControlSelect1">Kategori</label>
                        <select class="form-control" id="editKategori" name="kategori_id">

                        <option value="' . $dtKategori[0]->id . '" selected>' . $dtKategori[0]->nama_kategori . '</option>
                        <option>----------------Pilih Kategori Baru-----------------</option>';
        foreach ($kategoriAll as $item) {
            $html .= '<option value="' . $item->id . '" name="kategori_id">' . $item->nama_kategori . '</option>';
        }

        $html .= '</select></div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" name="status" id="editStatus">
                        <option value="aktif" id="status">Aktif</option>
                        <option value="non-aktif" id="status">Non Aktif</option>
                    </select>
                </div>





        ';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(), [
            'nama_barang' => 'required',
            'harga_barang' => 'required',
            'stok_barang' => 'required',
            'kategori_id' => '',
            'status' => '',
            // 'image' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // dd($validator);

        $databarang = new DataBarang;
        $databarang->updateData($id, $request->all());

        return response()->json(['success' => 'Article updated successfully']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        {
            $databarang = new DataBarang;
            $databarang->deleteData($id);

            // return redirect('data-barang')->with(['success' => 'Berhasil Hapus Data']);
            return response()->json(['success' => 'Article deleted successfully']);

        }
    }


}
