@extends('layouts.app')

@section('page-header')
<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Master Barang</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Master Barang</a></li>
                        <li class="breadcrumb-item"><a href="keluar-barang">Data Pengeluaran Barang</a></li>
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
                            <h5>Data Barang</h5>
                        </div>
                        <div class="col">
                            <button style="float: right" type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#modal-create" id="btn-create-keluar-barang"><i
                                    class="fas mr-2 fa-plus"></i>
                                Tambah
                                Data</button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <table class="table table-striped table-bordered datatable table-responsive-md" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Supplier</th>
                                <th>Nama Barang</th>
                                <th>Stok Barang</th>
                                <th>Stok Keluar</th>
                                <th>Tanggal Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- [ form-element ] start -->

        <!-- [ form-element ] end -->
    </div>
    <!-- [ Main Content ] end -->

</div>

{{-- Modal Edit Barang Discontinue --}}
<div class="modal fade" id="ajaxModel">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="keluarBarangForm" name="keluarBarangForm" class="form-horizontal">
                    <input type="hidden" class="keluarBarang_id" name="keluarBarang_id" id="keluarBarang_id">

                    <div class="form-group">
                        <label for="nama_supplier">Nama Supplier</label>
                        <select class="form-control" name="supplier_id" id="supplier_id">
                            <option selected disabled>Pilih Supplier</option>
                            @foreach ($supplier as $item)
                            <option value="{{ $item->id }}" id="supplier_id">
                                {{ strtoupper($item->nama_supplier) }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <select class="form-control" name="barang_id" id="barang_id">
                            <option selected disabled>Pilih Barang</option>
                            @foreach ($barang as $item)
                            <option value="{{ $item->id }}" id="barang_id">{{ strtoupper($item->nama_barang) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok Barang :</label>
                        <input type="number" class="form-control" name="stok_barang" id="stok_barang">
                    </div>
                    <div class="form-group">
                        <label for="stok">Tanggal Keluar:</label>
                        <input type="date" class="form-control" name="tgl_keluar" id="tgl_keluar">
                    </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
                <button type="button" class="btn btn-success" id="saveBtn">SIMPAN</button>
            </div>
            </form>
        </div>
    </div>
</div>
{{-- End Modal --}}
@endsection

@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
@endpush

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Rendering Table
        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('keluar-barang.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'supplier_id',
                    name: 'supplier_id.nama_supplier'
                },
                {
                    data: 'barang_id',
                    name: 'barang_id.nama_barang'
                },
                {
                    data: 'stok_barang',
                    name: 'stok_barang.stok_barang'
                },
                {
                    data: 'stok_keluar',
                    name: 'stok_keluar'
                },
                {
                    data: 'tgl_keluar',
                    name: 'tgl_keluar',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // Create Barang Keluar
        $('#btn-create-keluar-barang').click(function() {
            $('#saveBtn').val("create-keluar-barang");
            $('#keluarBarang_id').val('');
            $('#keluarBarangForm').trigger("reset");
            $('#modelHeading').html("TAMBAH DATA KELUAR BARANG");
            $('#ajaxModel').modal('show');
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var formData = $('#keluarBarangForm').serialize();

            $.ajax({
                url: "{{ route('keluar-barang.store') }}",
                // method: 'post',
                data: {
                    id: $('#keluarBarang_id').val(),
                    supplier_id: $('#supplier_id').val(),
                    barang_id: $('#barang_id').val(),
                    stok_barang: $('#stok_barang').val(),
                    tgl_keluar: $('#tgl_keluar').val(),
                },
                // data: $('#barangDiscForm').serialize(),
                type: "POST",
                dataType: 'json',

                success: function(response) {
                    console.log(response)
                    if (response.errors) {
                        $('.alert-danger').html('');
                        $.each(response.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>' + value +
                                '</li></strong>');
                        });
                        $('#saveBtn').html('SIMPAN');

                    } else {
                        $('.alert-danger').hide();

                        swal({
                            type: 'success',
                            icon: 'success',
                            title: `${response.message}`,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        $('#barangDiscForm').trigger("reset");
                        $('#saveBtn').html('SIMPAN');
                        $('#ajaxModel').modal('hide');

                        table.draw();
                    }
                }
            });
        });

    });
</script>
