<?php

namespace App\Http\Controllers;

use App\Models\DataBahanBaku;
use App\Models\DataBarang;
use App\Models\Stok;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stok = Stok::all();
        $databarang = DataBarang::all();
        $databahanbaku = DataBahanBaku::all();

        return view('master-data.stok', compact('stok', 'databarang', 'databahanbaku'));
    }

    public function getDataStok(Request $request, Stok $stok)
    {

        if ($request->ajax()) {

            $datastok = Stok::leftJoin('data_barang', 'data_barang.id', '=', 'stok.barang_id')
                ->leftJoin('data_bahan_baku', 'data_bahan_baku.id', '=', 'stok.bahan_baku_id')
                ->select('stok.*', 'data_barang.nama_barang', 'data_bahan_baku.nama_bahan_baku')
                ->get();

            // dd($datastok);

            // $data = Stok::select('*');
            return Datatables::of($datastok)
                ->addColumn('nama_barang_bahan_baku', function ($row) {
                    // dd($row);
                    if (!empty($row->barang_id)) {
                        $nama_barang_bahan_baku = $row->nama_barang;
                        // dd($nama_barang_bahan_baku);
                    } elseif (!empty($row->bahan_baku_id)) {
                        $nama_barang_bahan_baku = $row->nama_bahan_baku;
                    }
                    else {
                        $nama_barang_bahan_baku = 'Data Kosong';
                    }
                    return $nama_barang_bahan_baku;
                })
                ->addColumn('Actions', function ($data) {
                    return '<button type="button" class="btn btn-info btn-sm" id="getEditArticleData" data-id="' . $data->id . '">Edit</button>';
                    //    <!-- <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteArticleModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>'; -->
                })
                ->rawColumns(['Actions', 'nama_barang_bahan_baku'])
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
    public function store(Request $request, Stok $stok)
    {
        $validator = Validator::make($request->all(), [
            'barang_id' => '',
            'bahan_baku_id' => '',
            'stok' => 'required',
            // 'image' => '',
        ]);

        // dd($request->all());

        // if ($request->file('image')) {
        //     $validatedData['image'] = $request->file('image')->store('data-images');
        // }

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // dd($request->all());

        $stok->storeData($request->all());

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
        $databarang2 = DataBarang::all();
        $databr = $databarang->findData($id);

        $databahanbaku = new DataBahanBaku;
        $databahanbaku2 = DataBahanBaku::all();
        $databb = $databahanbaku->findData($id);

        $datastok = new Stok;
        $datastk = $datastok->findData($id);

        // dd($datastk);

        $datastok = Stok::leftJoin('data_barang', 'data_barang.id', '=', 'stok.barang_id')
            ->select('stok.*', 'data_barang.*')
            ->whereNotNull('stok.barang_id')
            ->get();

        $datastok2 = Stok::leftJoin('data_bahan_baku', 'data_bahan_baku.id', '=', 'stok.bahan_baku_id')
            ->select('stok.*', 'data_bahan_baku.*')
            ->whereNotNull('stok.bahan_baku_id')
            ->get();


        // dd($datastok);
        $databarangselect = DataBarang::where('id', $datastk->barang_id)->first();
        $databahanbakuselect = DataBahanBaku::where('id', $datastk->bahan_baku_id)->first();

        $testing = $databarangselect ? $databarangselect->nama_barang : 'Data Kosong';
        $testing2 = $databahanbakuselect ? $databahanbakuselect->nama_bahan_baku : 'Data Kosong';

        // dd($databahanbakuselect->id);

        $html = '
        <div class="form-group">
            <label for="nama_barang">Nama Barang</label>
            <select class="form-control" name="barang_id" id="editNamaBarang">
                <option value="'.$datastk->barang_id.'">' . $testing . '</option>
                <option value="">------------------------------</option>';
        foreach ($databarang2 as $item) {
            $html .= '<option value="' . $item->id . '">' . $item->nama_barang . '</option>';
        }
        $html .= '
            </select>
        </div>

        <div class="form-group">
            <label for="nama_bahan_baku">Nama Bahan Baku</label>
            <select class="form-control" name="bahan_baku_id" id="editNamaBahanBaku">
            <option  value="'.$datastk->bahan_baku_id.'">' . $testing2 . '</option>
            <option value="">------------------------------</option>';
        foreach ($databahanbaku2 as $item) {
            $html .= '<option value="' . $item->id . '">' . $item->nama_bahan_baku . '</option>';
        }
        $html .= '
            </select>
        </div>
        <div class="form-group">
            <label for="stok">Stok:</label>
            <input type="text" class="form-control" name="stok" id="editStok" value="' . $datastk->stok . '">
        </div>';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(), [
            'barang_id' => '',
            'bahan_baku_id' => '',
            'stok' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // dd($validator);

        // dd($request->all());
        $stok = new Stok;
        $stok->updateData($id, $request->all());

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
