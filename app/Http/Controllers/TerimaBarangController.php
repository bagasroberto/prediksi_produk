<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\DataSupplier;
use App\Models\TerimaBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TerimaBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $terimas = TerimaBarang::all();
            return DataTables::of($terimas)
                ->addIndexColumn()
                ->addColumn('supplier_id', function ($terima) {
                    return strtoupper($terima->supplier->nama_supplier);
                })
                ->addColumn('barang_id', function ($terima) {
                    return strtoupper($terima->barang->nama_barang);
                })
                ->addColumn('stok_barang', function ($terima) {
                    return strtoupper($terima->barang->stok_barang);
                })
                ->addColumn('stok_terima', function ($terima) {
                    return $terima->stok_barang;
                })
                ->addColumn('tgl_terima', function ($terima) {
                    return $terima->tgl_terima;
                })
                ->rawColumns(['tgl_terima'])
                ->make(true);
        }

        $supplier = DataSupplier::where('status_supplier', 'aktif')->get();
        $barang = DataBarang::where('status', 'aktif')->get();

        return view('master-data.terima-barang', compact('supplier', 'barang'));
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
    public function store(Request $request, TerimaBarang $terimaBarang)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'supplier_id' => 'required',
            'barang_id' => 'required',
            'stok_barang' => 'required',
            'tgl_terima' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //Create Terima Barang
        $terimaBarang->storeData($request->all());

        // Update Stock
        $barang = DataBarang::find($request->barang_id);
        $barang->update([
            'stok_barang' => $barang->stok_barang + $request->stok_barang,
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
    public function show(TerimaBarang $terimaBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TerimaBarang $terimaBarang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TerimaBarang $terimaBarang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TerimaBarang $terimaBarang)
    {
        //
    }
}
