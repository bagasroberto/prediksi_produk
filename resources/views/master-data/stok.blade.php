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
                        <li class="breadcrumb-item"><a href="data-barang">Stok</a></li>
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
                            <h5>Data Stok</h5>
                        </div>
                        <div class="col">
                            <button style="float: right" type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#CreateArticleModal"><i class="fas mr-2 fa-plus"></i>
                                Tambah
                                Data</button>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered datatable">
                        <thead>
                            <tr>
                                <th style="width : 10%;">No</th>
                                <th>Nama Barang / Bahan Baku</th>
                                <th style="width:20%;">Stok</th>
                                <th style="width : 20%;" class="text-center">Action</th>
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

    <div class="modal" id="CreateArticleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Data telah ditambahkan.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <select class="form-control" name="barang_id" id="barang_id">
                            <option value="">Pilih Barang</option>
                            @foreach ($databarang as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_barang }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_bahan_baku">Nama Bahan Baku</label>
                        <select class="form-control" name="bahan_baku_id" id="bahan_baku_id">
                            <option value="">Pilih Barang</option>
                            @foreach ($databahanbaku as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_bahan_baku }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok:</label>
                        <input type="text" class="form-control" name="stok" id="stok">
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitCreateArticleForm">Create</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Article Modal -->
    <div class="modal" id="EditArticleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data</h5>
                    <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                        <strong>Success!</strong>Data updated successfully.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="EditArticleModalBody">

                    </div>

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="SubmitEditArticleForm">Update</button>
                    <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Article Modal -->
    <div class="modal" id="DeleteArticleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->

                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Deleted Data Successfully.
                </div>
                <div class="modal-header">
                    <h4 class="modal-title">Data Delete</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <h4>Are you sure want to delete this Data?</h4>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="SubmitDeleteArticleForm">Yes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@push('script')

<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
@endpush

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script type="text/javascript">
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

</script>

<script type="text/javascript">
    $(document).ready(function() {
        // init datatable.
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 10,
            // scrollX: true,
            "order": [[ 0, "asc" ]],
            ajax: '{{ route('stok-get') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'id'},
                {data: 'nama_barang_bahan_baku', name: 'nama_barang_bahan_baku'},
                {data: 'stok', name: 'stok'},
                {data: 'Actions', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
            ]
        });

        // Create article Ajax request.
        $('#SubmitCreateArticleForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('stok.store') }}",
                // enctype: 'multipart/form-data',
                // processData: false,  // Important!
                // contentType: false,
                // cache: false,
                method: 'post',
                data: {
                    barang_id: $('#barang_id').val(),
                    bahan_baku_id: $('#bahan_baku_id').val(),
                    stok: $('#stok').val(),
                    // image: $('#image').val(),
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function(){
                            $('.alert-success').hide();
                            $('#CreateArticleModal').modal('hide');
                            location.reload();
                        }, 2000);
                    }
                }
            });
        });

        // Get single article in EditModel
        $('.modelClose').on('click', function(){
            $('#EditArticleModal').hide();
        });
        var id;
        $('body').on('click', '#getEditArticleData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "stok/"+id+"/edit",
                method: 'GET',
                // data: {
                //     id: id,
                // },
                success: function(result) {
                    console.log(result);
                    $('#EditArticleModalBody').html(result.html);
                    $('#EditArticleModal').show();
                }
            });
        });

        // Update article Ajax request.
        $('#SubmitEditArticleForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "stok/"+id,
                method: 'PUT',
                data: {
                    barang_id: $('#editNamaBarang').val(),
                    bahan_baku_id: $('#editNamaBahanBaku').val(),
                    stok: $('#editStok').val(),
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function(){
                            $('.alert-success').hide();
                            $('#EditArticleModal').hide();
                            location.reload();

                        }, 2000);
                    }
                }
            });
        });
    });

</script>
