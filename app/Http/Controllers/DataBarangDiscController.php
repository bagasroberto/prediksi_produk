<?php

namespace App\Http\Controllers;

use App\Models\DataBahanBaku;
use App\Models\DataBarang;
use App\Models\Kategori;
use App\Models\Stok;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataBarangDiscController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $stok = Stok::all();
        $kategori = Kategori::all();
        $databarang = DataBarang::all();
        $databahanbaku = DataBahanBaku::all();
        return view('master-data.data-barangDisc', compact('kategori', 'databarang', 'stok', 'databahanbaku'));

    }

    public function getDataReturn(Request $request, Stok $stok)
    {

        if ($request->ajax()) {

            $datastok = DB::table('stok')
                ->leftJoin('data_barang', 'data_barang.id', '=', 'stok.barang_id')
                ->leftJoin('data_bahan_baku', 'data_bahan_baku.id', '=', 'stok.bahan_baku_id')
                ->select('stok.*', 'data_barang.*', 'data_bahan_baku.*', DB::raw('COALESCE (`data_barang`.`status`,`data_bahan_baku`.`status`) as status'))
                ->get();

            return Datatables::of($datastok)
                ->addColumn('nama_barang_bahan_baku', function ($row) {
                    if (!empty($row->barang_id)) {
                        $nama_barang_bahan_baku = $row->nama_barang;
                        // dd($nama_barang_bahan_baku);
                    } elseif (!empty($row->bahan_baku_id)) {
                        $nama_barang_bahan_baku = $row->nama_bahan_baku;
                    }
                    return $nama_barang_bahan_baku;
                })
                ->addColumn('stok', function ($row) {
                    return ucfirst($row->stok);
                })
                ->addColumn('stok_rusak', function ($row) {
                    if ($row->stok_rusak == null) {
                        return 0;
                    } else {
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
                ->addColumn('Actions', function ($datastok) {
                    return '<button type="button" class="btn btn-info btn-sm" id="getEditArticleData" data-id="' . $datastok->id . '">Edit</button>';
                })
                ->rawColumns(['status', 'Actions', 'nama_barang_bahan_baku'])
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
        $barangAll = $databarang->findData($id);

        $dataBahanBaku = new DataBahanBaku;
        $bahanBakuAll = DataBahanBaku::all();

        $datastok = DB::table('stok')
        ->leftJoin('data_barang', 'data_barang.id', '=', 'stok.barang_id')
        ->leftJoin('data_bahan_baku', 'data_bahan_baku.id', '=', 'stok.bahan_baku_id')
        ->select('stok.*', 'data_barang.*', 'data_bahan_baku.*')
        ->get();

        $html = '<div class="form-group">
                     <label for="stok">Stok Saat Ini:</label>
                     <input type="number" class="form-control" name="stok" id="editStok" value="' . $datastok->stok . '" disabled>
                 </div>
                <div class="form-group">
                     <label for="stok_rusak">Stok:</label>
                     <input type="number" class="form-control" name="stok_rusak" id="editStok" value="">
                 </div>';

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

    }

}
