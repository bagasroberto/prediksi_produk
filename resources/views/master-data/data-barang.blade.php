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
                        <li class="breadcrumb-item"><a href="data-barang">Data Barang</a></li>
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
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Stok</th>

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

<!-- Create Article Modal -->
{{-- <form action="POST" enctype="multipart/form-data" id="SubmitCreateArticleForm">
    @csrf --}}


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
                        <label for="nama_produk">Nama Produk:</label>
                        <input type="text" class="form-control" name="nama_barang" id="nama_barang">
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga:</label>
                        <input type="text" class="form-control" name="harga_barang" id="harga_barang">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok:</label>
                        <input type="text" class="form-control" name="stok_barang" id="stok_barang">
                    </div>
{{--
                    <div class="form-group">
                        <label for="image">Foto Barang</label>
                        <img class="img-preview img-fluid mb-3 col-sm-5">

                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image"
                            name="image" onchange="previewImage()">

                    </div> --}}

                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Kategori</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option selected>Pilih Kategori</option>
                            @foreach ($kategori as $item)

                            <option value="{{ $item->id }}" id="kategori_id">{{ $item->nama_kategori }}
                            </option>
                            @endforeach
                        </select>
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

    {{--
</form> --}}

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
                    <strong>Success!</strong>Article was added successfully.
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


    $(document).ready(function() {
        // init datatable.
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 10,
            // scrollX: true,
            "order": [[ 0, "asc" ]],
            ajax: '{{ route('data-barang-get') }}',
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'nama_barang', name: 'nama_barang'},
                {data: 'harga_barang', name: 'harga_barang'},
                {data: 'stok_barang', name: 'stok_barang'},
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
                url: "{{ route('data-barang.store') }}",
                // enctype: 'multipart/form-data',
                // processData: false,  // Important!
                // contentType: false,
                // cache: false,
                method: 'post',
                data: {
                    nama_barang: $('#nama_barang').val(),
                    harga_barang: $('#harga_barang').val(),
                    stok_barang: $('#stok_barang').val(),
                    kategori_id: $('#kategori_id').val(),
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
                url: "data-barang/"+id+"/edit",
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
                url: "data-barang/"+id,
                method: 'PUT',
                data: {
                    nama_barang: $('#editNamaBarang').val(),
                    harga_barang: $('#editHargaBarang').val(),
                    stok_barang: $('#editStokBarang').val(),
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

        // Delete article Ajax request.
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteArticleForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "data-barang/"+id,
                method: 'DELETE',
                success: function(result) {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function(){
                            $('#CreateArticleModal').modal('hide');
                            location.reload();
                        }, 2000);

                }
                // success: function(result) {
                //     $('#DeleteArticleModal').hide();
                //     $('.alert-danger').hide();
                //     $('.alert-success').show();
                //     location.reload();
                //                         setInterval(function(){
                //         $('.datatable').DataTable().ajax.reload();
                //         $('#DeleteArticleModal').hide();
                //     }, 1000);

                // }
                // success: function(result) {
                //     setInterval(function(){
                //         $('.datatable').DataTable().ajax.reload();
                //         $('#DeleteArticleModal').hide();
                //     }, 1000);
                // }
            });
        });
    });

    // function previewImage() {
    //         const image = document.querySelector('#image');
    //         const imgPreview = document.querySelector('.img-preview');

    //         imgPreview.style.display = 'block';

    //         const oFReader = new FileReader();
    //         oFReader.readAsDataURL(image.files[0]);

    //         oFReader.onload = function(oFREvent) {
    //             imgPreview.src = oFREvent.target.result;
    //         }
    //     }
</script>
