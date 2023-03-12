<?php

namespace App\Http\Controllers;

use App\Models\DataBahanBaku;
use App\Models\DataBarang;
use App\Models\DataSupplier;
use App\Models\Kategori;
use App\Models\Stok;
use App\Models\KeluarBarang;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeluarBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $kategori = Kategori::all();
        $databarang = DataBarang::all();
        $datasupplier = DataSupplier::all();
        $databahanbaku = DataBahanBaku::all();
        $stok = Stok::all();

        return view('master-data.keluar-barang', compact('kategori', 'databarang', 'databahanbaku', 'stok', 'datasupplier'));

    }

    public function getDataKeluarBarang(Request $request, KeluarBarang $keluarbarang)
    {

        if ($request->ajax()) {

            $data = KeluarBarang::leftJoin('data_supplier', 'data_supplier.id', '=', 'keluar_barang.supplier_id')
                ->leftJoin('data_barang', 'data_barang.id', '=', 'keluar_barang.barang_id')
                ->leftJoin('data_bahan_baku', 'data_bahan_baku.id', '=', 'keluar_barang.bahan_baku_id')
                ->select('keluar_barang.*', 'data_supplier.nama_supplier', 'data_supplier.alamat_supplier', 'data_supplier.tlp_supplier', 'data_barang.nama_barang', 'data_bahan_baku.nama_bahan_baku')
                ->get();


            return Datatables::of($data)
                ->addColumn('nama_barang_bahan_baku', function ($row) {
                    // dd($row);
                    if (!empty($row->barang_id)) {
                        $nama_barang_bahan_baku = $row->nama_barang;
                        // dd($nama_barang_bahan_baku);
                    } elseif (!empty($row->bahan_baku_id)) {
                        $nama_barang_bahan_baku = $row->nama_bahan_baku;
                    }
                    return $nama_barang_bahan_baku;
                })
                ->addColumn('Actions', function ($data) {
                    return '<button type="button" class="btn btn-info btn-sm" id="getEditArticleData" data-id="' . $data->id . '"><i class="feather icon-eye"></i></button>';
                })
                ->rawColumns(['Actions','nama_barang_bahan_baku'])
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
    public function store(Request $request, KeluarBarang $keluarbarang)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'barang_id' => '',
            'bahan_baku_id' => '',
            'stok_keluar' => 'required',
            'tgl_keluar' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $keluarbarang->storeData($request->all());

        // dd($request->all());

        if (!empty($request->barang_id)) {
            $stok_barang = DB::table('stok')->where('stok.barang_id', $request->barang_id)->first();
            $stok_barang1 = $stok_barang->stok - $request->input('stok_keluar');

            $stok_barang = DB::table('stok')->where('stok.barang_id', $request->barang_id)->update([
                'stok' => $stok_barang1,
            ]);
        } elseif (!empty($request->bahan_baku_id)) {
            $stok_bahan_baku = DB::table('stok')->where('stok.bahan_baku_id', $request->bahan_baku_id)->first();

            $stok_bahan_baku1 = $stok_bahan_baku->stok - $request->input('stok_keluar');

            $stok_bahan_baku = DB::table('stok')->where('stok.bahan_baku_id', $request->bahan_baku_id)->update([
                'stok' => $stok_bahan_baku1,
            ]);
        }

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

        // dd('a');

        $databarang = new DataBarang;
        $databr = $databarang->findData($id);

        $databahanbaku = new DataBahanBaku;
        $databb = $databahanbaku->findData($id);

        $stok = new Stok;
        $datastok = $stok->findData($id);

        $datakategori = new Kategori;
        $kategoriAll = Kategori::all();

        $data = KeluarBarang::leftJoin('data_supplier', 'data_supplier.id', '=', 'keluar_barang.supplier_id')
        ->leftJoin('data_barang', 'data_barang.id', '=', 'keluar_barang.barang_id')
        ->leftJoin('data_bahan_baku', 'data_bahan_baku.id', '=', 'keluar_barang.bahan_baku_id')
        ->select('keluar_barang.tgl_keluar', 'keluar_barang.stok_keluar','data_supplier.nama_supplier', 'data_supplier.alamat_supplier')
        ->first();

        // dd($data);

        $html = '
                <div class="form-group">
                    <label for="stok_keluar">Stok Keluar :</label>
                    <input type="text" class="form-control" name="stok_keluar" id="editStokDiterima" value="' . $data->stok_keluar . '" disabled>
                </div>
                <div class="form-group">
                    <label for="tgl_keluar">Tanggal Keluar :</label>
                    <input type="text" class="form-control" name="tgl_keluar" id="editStokNormal" value="' . $data->tgl_keluar . '" disabled>
                </div>';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = \Validator::make($request->all(), [
            'stok_diterima' => '',
            'stok_rusak' => '',
            'stok_diterima' => '',
            // 'image' => '',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // dd($request->all());

        $terimabarang = new TerimaBarang;
        $terimabarang->updateData($id, $request->all());

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
