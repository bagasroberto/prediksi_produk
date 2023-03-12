<?php

namespace App\Http\Controllers;

use App\Models\DataBahanBaku;
use App\Models\DataBarang;
use App\Models\DataSupplier;
use App\Models\Kategori;
use App\Models\Stok;
use App\Models\TerimaBarang;
use DataTables;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TerimaBarangController extends Controller
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

        return view('master-data.terima-barang', compact('kategori', 'databarang', 'databahanbaku', 'stok', 'datasupplier'));

    }

    public function getDataTerimaBarang(Request $request, TerimaBarang $terimabarang)
    {

        if ($request->ajax()) {

            $data = TerimaBarang::leftJoin('data_supplier', 'data_supplier.id', '=', 'terima_barang.supplier_id')
                ->leftJoin('data_barang', 'data_barang.id', '=', 'terima_barang.barang_id')
                ->leftJoin('data_bahan_baku', 'data_bahan_baku.id', '=', 'terima_barang.bahan_baku_id')
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
                ->addColumn('statusBadge', function ($row) {
                    if ($row->status == 'aktif') {
                        $status = '<button style="pointer-events:none" class="btn btn-success btn-sm">Aktif</button>';
                    } else {
                        $status = '<button style="pointer-events:none" class="btn btn-danger btn-sm">Non Aktif</button>';
                    }
                    return $status;
                })
                ->addColumn('Actions', function ($data) {
                    return '<button type="button" class="btn btn-info btn-sm" id="getEditArticleData" data-id="' . $data->id . '"><i class="feather icon-eye"></i></button>';
                })
                ->rawColumns(['Actions', 'statusBadge', 'nama_barang_bahan_baku'])
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
    public function store(Request $request, TerimaBarang $terimabarang)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'barang_id' => '',
            'bahan_baku_id' => '',
            'stok_diterima' => 'required',
            'stok_normal' => 'required',
            'stok_rusak' => 'required',
            'tgl_terima' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $terimabarang->storeData($request->all());

        // dd($request->all());

        if (!empty($request->barang_id)) {
            $stok_barang = DB::table('stok')->where('stok.barang_id', $request->barang_id)->first();
            $stok_barang1 = $stok_barang->stok + $request->input('stok_normal');
            $stok_barang2 = $stok_barang->stok_rusak + $request->input('stok_rusak');

            $stok_barang = DB::table('stok')->where('stok.barang_id', $request->barang_id)->update([
                'stok' => $stok_barang1,
                'stok_rusak' => $stok_barang2,
            ]);
        } elseif (!empty($request->bahan_baku_id)) {
            // dd('tes');
            $stok_bahan_baku = DB::table('stok')->where('stok.bahan_baku_id', $request->bahan_baku_id)->first();

            // dd($stok_bahan_baku);
            $stok_bahan_baku1 = $stok_bahan_baku->stok + $request->input('stok_normal');
            $stok_bahan_baku2 = $stok_bahan_baku->stok_rusak + $request->input('stok_rusak');

            $stok_bahan_baku = DB::table('stok')->where('stok.bahan_baku_id', $request->bahan_baku_id)->update([
                'stok' => $stok_bahan_baku1,
                'stok_rusak' => $stok_bahan_baku2,
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

        $databarang = new DataBarang;
        $databr = $databarang->findData($id);

        $databahanbaku = new DataBahanBaku;
        $databb = $databahanbaku->findData($id);

        $stok = new Stok;
        $datastok = $stok->findData($id);

        $datakategori = new Kategori;
        $kategoriAll = Kategori::all();

        $data = TerimaBarang::leftJoin('data_supplier', 'data_supplier.id', '=', 'terima_barang.supplier_id')
        ->leftJoin('data_barang', 'data_barang.id', '=', 'terima_barang.barang_id')
        ->leftJoin('data_bahan_baku', 'data_bahan_baku.id', '=', 'terima_barang.bahan_baku_id')
        ->select('terima_barang.stok_diterima', 'terima_barang.tgl_terima', 'terima_barang.stok_normal', 'terima_barang.stok_rusak', 'data_supplier.nama_supplier', 'data_supplier.alamat_supplier')
        ->first();

        // dd($data);

        $html = '
                <div class="form-group">
                    <label for="stok_diterima">Stok Diterima :</label>
                    <input type="text" class="form-control" name="stok_diterima" id="editStokDiterima" value="' . $data->stok_diterima . '" disabled>
                </div>
                <div class="form-group">
                    <label for="stok_normal">Stok Normal :</label>
                    <input type="text" class="form-control" name="stok_normal" id="editStokNormal" value="' . $data->stok_normal . '" disabled>
                </div>
                <div class="form-group">
                    <label for="stok_rusak">Stok Rusak :</label>
                    <input type="text" class="form-control" name="stok_rusak" id="editStokRusak" value="' . $data->stok_rusak . '" disabled>
                </div>
                <div class="form-group">
                    <label for="tgl_terima">Tanggal Terima :</label>
                    <input type="text" class="form-control" name="tgl_terima" id="editStokRusak" value="' . $data->tgl_terima . '" disabled>
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
