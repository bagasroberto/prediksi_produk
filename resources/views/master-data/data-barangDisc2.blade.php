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
                        <li class="breadcrumb-item"><a href="data-barangDisc">Data Barang Discontinue</a></li>
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
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-striped table-bordered datatable table-responsive-md" style="width:100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Stok Barang</th>
                                <th>Stok Rusak</th>
                                <th>Status</th>
                                <th>Action</th>
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

<!-- Modal -->
<div class="modal fade" id="ajaxModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelHeading"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="barangDiscForm" name="barangDiscForm" class="form-horizontal">
                    <input type="hidden" class="barangDisc_id" name="barangDisc_id" id="barangDisc_id">

                    <div class="form-group">
                        <label for="nama_produk">Nama Produk :</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang" disabled>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok Barang Saat Ini :</label>
                        <input type="number" class="form-control" name="stok_barang" id="stok_barang" disabled>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok Rusak :</label>
                        <input type="number" class="form-control" name="stok_rusak" id="stok_rusak">
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
            ajax: "{{ route('data-barangDisc.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_barang_bahan_baku',
                    name: 'nama_barang_bahan_baku'
                },
                {
                    data: 'stok',
                    name: 'stok'
                },
                {
                    data: 'stok_rusak',
                    name: 'stok_rusak'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // Edit Data Barang Discontinue
        $('body').on('click', '.edit-barangDisc', function() {
            var barang_id = $(this).data('id');
            $.get("{{ route('data-barangDisc.index') }}" + '/' + barang_id + '/edit', function(
                data) {
                $('#modelHeading').html("EDIT DATA BARANG DISCONTINUE");
                $('#saveBtn').val("edit-barang");
                $('#ajaxModel').modal('show');
                $('#barangDisc_id').val(data.id);
                $('#nama_barang').val(data.nama_barang);
                $('#stok_barang').val(data.stok_barang);
                // $('#stok_rusak').val(data.stok_rusak);
            })
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var formData = $('#barangDiscForm').serialize();

            $.ajax({
                url: "{{ route('data-barangDisc.store') }}",
                // method: 'post',
                data: {
                    id: $('#barangDisc_id').val(),
                    nama_barang: $('#nama_barang').val(),
                    stok_barang: $('#stok_barang').val(),
                    stok_rusak: $('#stok_rusak').val(),
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
