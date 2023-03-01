<?php

namespace App\Http\Controllers;

use App\Models\DataBarang;
use DataTables;
use Illuminate\Http\Request;

class DataBarangController extends Controller
{

    public function index()
    {
        return view('master-barang.data-barang');
    }

    public function getDataBarang(Request $request)
    {
        if ($request->ajax()) {
            $data = DataBarang::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
