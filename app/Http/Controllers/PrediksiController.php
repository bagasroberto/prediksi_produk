<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class PrediksiController extends Controller
{
    public function perhitungan(){

        $kategori = Kategori::all();

        return view('prediksi.perhitungan-produksi', compact('kategori'));
    }

    public function hasilperhitungan(){
        return view('prediksi.hasil-perhitungan');
    }
}
