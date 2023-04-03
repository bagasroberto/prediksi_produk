@extends('layouts.app')

@section('page-header')

<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Prediksi</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Prediksi</a></li>
                        <li class="breadcrumb-item"><a href="data-barang">Perhitungan Produksi</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- [ breadcrumb ] end -->

    <!-- [ Main Content ] start -->
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h5>Form Prediksi Produksi</h5>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <form>

                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">Kategori Prediksi</label>
                                    <select class="form-control" id="exampleFormControlSelect1">
                                        <option selected>Pilih Kategori Produk</option>
                                        @foreach ($kategori as $item)

                                        <option>{{ $item->nama_kategori }}</option>

                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Penjualan Bulan Kemarin</label>
                                    <input type="number" class="form-control" id="penjualan"
                                        aria-describedby="emailHelp" placeholder="Masukkan Jumlah Penjualan Bulan Kemarin">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Persediaan</label>
                                    <input type="number" class="form-control" id="persediaan"
                                        aria-describedby="emailHelp" placeholder="Masukkan Jumlah Persediaan">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Permintaan</label>
                                    <input type="number" class="form-control" id="permintaan"
                                        placeholder="Masukkan Jumlah Permintaan">
                                </div>
                                <button type="submit" class="btn  btn-primary">Hitung Prediksi</button>
                            </form>
                        </div>

                    </div>

                </div>
                <!-- [ form-element ] start -->

                <!-- [ form-element ] end -->
            </div>
            <!-- [ Main Content ] end -->

        </div>
    </div>
</div>

@endsection

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js">
</script>
