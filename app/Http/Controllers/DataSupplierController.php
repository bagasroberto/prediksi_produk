<?php

namespace App\Http\Controllers;

use App\Models\DataSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DataSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $suppliers = DataSupplier::all();
            return Datatables::of($suppliers)
                ->addIndexColumn()
                ->addColumn('nama', function ($supplier) {
                    return strtoupper($supplier->nama_supplier);
                })
                ->addColumn('email_supplier', function ($supplier) {
                    return ucfirst($supplier->email_supplier);
                })
                ->addColumn('alamat_supplier', function ($supplier) {
                    return ucfirst($supplier->alamat_supplier);
                })
                ->addColumn('status', function ($supplier) {
                    if ($supplier->status_supplier == 'aktif') {
                        return '<div class="badge badge-success">' . ucfirst($supplier->status_supplier) . '</div>';
                    } else {
                        return '<div class="badge badge-danger">' . ucfirst($supplier->status_supplier) . '</div>';
                    }
                })
                ->addColumn('action', function ($supplier) {

                    if ($supplier->status_supplier == 'aktif') {
                        $button = 'ARSIPKAN';
                        $class = 'danger';
                    } else {
                        $class = 'success';
                        $button = 'AKTIFKAN';
                    }

                    $btn = '<button id="edit-supplier" data-id="' . $supplier->id . '" class="btn btn-primary btn-sm edit-supplier" data-original-title="Edit">EDIT</button>';


                    $btn = $btn . ' <button id="delete-supplier" data-id="' . $supplier->id . '" class="btn btn-'.$class.' btn-sm">' . $button . '</button>';

                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('master-data.data-supplier');
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
    public function store(Request $request, DataSupplier $supplier)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama_supplier' => 'required',
            'email_supplier' => 'required',
            'alamat_supplier' => 'required',
            'tlp_supplier' => 'required',
            'kategori_supplier' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        //Create or Update Data Supplier
        // $supplier->storeData($request->all());

        $supplier = DataSupplier::updateOrCreate([
            'id' => $request->id
        ], [
            'nama_supplier' => $request->nama_supplier,
            'email_supplier' => $request->email_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'tlp_supplier' => $request->tlp_supplier,
            'kategori_supplier' => $request->kategori_supplier,

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
    public function show(DataSupplier $dataSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dataSupplier = DataSupplier::find($id);
        return response()->json($dataSupplier);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DataSupplier $dataSupplier)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataSupplier $dataSupplier)
    {
        if ($dataSupplier->status_supplier == 'non-aktif') {
            $dataSupplier->update([
                'status_supplier' => 'aktif'
            ]);
            return response()->json(['status' => 'Berhasil Menampilkan Data!']);
        } else {
            $dataSupplier->update([
                'status_supplier' => 'non-aktif'
            ]);

            return response()->json(['status' => 'Berhasil Mengarsipkan Data!']);
        }
    }
}
