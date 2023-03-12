<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DataSupplier;
use App\Models\KeluarBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KeluarBarangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $keluars = KeluarBarang::all();
            return DataTables::of($keluars)
                ->addIndexColumn()
                ->addColumn('supplier_id', function ($keluar) {
                    return strtoupper($keluar->supplier->nama_supplier);
                })
                ->addColumn('barang_id', function ($keluar) {
                    return strtoupper($keluar->barang->nama_barang);
                })
                ->addColumn('stok_barang', function ($keluar) {
                    return strtoupper($keluar->barang->stok_barang);
                })
                ->addColumn('stok_keluar', function ($keluar) {
                    return $keluar->stok_barang;
                })
                ->addColumn('tgl_keluar', function ($keluar) {
                    return $keluar->tgl_keluar;
                })
                ->rawColumns(['tgl_keluar'])
                ->make(true);
        }

        $supplier = DataSupplier::where('status_supplier', 'aktif')->get();
        $barang = DataBarang::where('status', 'aktif')->get();

        return view('master-data.keluar-barang', compact('supplier', 'barang'));
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
    public function store(Request $request, KeluarBarang $keluarBarang)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'barang_id' => 'required',
            'stok_barang' => 'required',
            'tgl_keluar' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        // dd($validator);

        //Create Terima Barang
        $keluarBarang->storeData($request->all());

        // Update Stock
        $barang = DataBarang::find($request->barang_id);
        $barang->update([
            'stok_barang' => $barang->stok_barang - $request->stok_barang,
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
    public function show(KeluarBarang $keluarBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KeluarBarang $keluarBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KeluarBarang $keluarBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TerimaBarang $keluarBarang)
    {
        //
    }
}
