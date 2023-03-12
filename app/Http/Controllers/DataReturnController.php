<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use App\Models\Stok;
use DataTables;
use DB;
use Illuminate\Http\Request;

class DataReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stok = Stok::all();
        $databarang = DataBarang::all();

        return view('master-data.return-barang', compact('stok', 'databarang'));
    }

    public function getDataReturnBarang(Request $request, Stok $stok)
    {

        if ($request->ajax()) {

            $data = DB::table('stok')
                ->leftJoin('data_barang', 'data_barang.id', '=', 'stok.barang_id')
                ->select('stok.*', 'data_barang.*')
                ->whereNotNull('stok.barang_id')
                ->get();

                // dd($data);

            return Datatables::of($data)
                ->addColumn('stok_rusak', function ($row) {
                    if ($row->stok_rusak == null) {
                        return 0;
                    } else {
                        return $row->stok_rusak;
                    }
                })
                ->addColumn('statusBadge', function ($row) {
                    if ($row->status == 'aktif') {
                        return '<div class="badge badge-success">' . ucfirst($row->status) . '</div>';
                    } else {
                        return '<div class="badge badge-danger">' . ucfirst($row->status) . '</div>';
                    }
                })
                ->addColumn('Actions', function ($data) {
                    return '<button type="button" class="btn btn-info btn-sm" id="getEditArticleData" data-id="' . $data->id . '">Edit</button>';
                })
                ->rawColumns(['Actions', 'statusBadge'])
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
    public function store(Request $request)
    {
        //
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

        $stok = new Stok;
        $dataStok = $stok->findData($id);

        $data = DB::table('stok')
        ->leftJoin('data_barang', 'data_barang.id', '=', 'stok.barang_id')
        ->select('stok.*', 'data_barang.*')
        ->whereNotNull('stok.barang_id')
        ->get();

        // dd($dtKategori);

        $html = '<div class="form-group">
                     <label for="stok">Stok Barang:</label>
                     <input type="text" class="form-control" name="stok" id="editStok" value="' . $dataStok->stok . '" disabled>
                 </div>
                 <div class="form-group">
                     <label for="stok_rusak">Stok Rusak:</label>
                     <input type="number" class="form-control" name="input_stok_rusak" id="editStokRusak" value="">
                 </div>';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $validator = \Validator::make($request->all(), [
        //     'stok' => '',
        //     'stok_rusak' => 'required',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()->all()]);
        // }

        // dd($request->all());

        // $stok = new Stok;
        // $dataStok = $stok->findData($id);
        $stok = Stok::find($id);
        // dd($stok);
        $stok->stok = $stok->stok - $request->input('stok_rusak');
        // dd($stok->stok);
        $stok->stok_rusak = $request->input('stok_rusak');


        // dd($request->all());
        // dd($stok);
        // $stok->updateData($id, $request->all());
        $stok->save();

        // $stok_rusak = $kurangiStok;



        // dd($kurangiStok);

        // $stok->update([
        //     'stok' => $kurangiStok,
        // ]);


        // $data_barang->updateOrCreate([
        //     'id' => $request->id,
        // ], [
        //     'stok_barang' => $stok_rusak,
        //     'stok_rusak' => $data_barang->stok_rusak + $request->stok_rusak,
        // ]);
        // $stok->updateData($id, $request->all());

        return response()->json(['success' => 'Article updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
