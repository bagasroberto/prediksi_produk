@extends('layouts.app')

@section('page-header')
<div class="pcoded-content">
    <!-- [ breadcrumb ] start -->
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Konfigurasi Sistem</h5>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="feather icon-home"></i></a>
                        </li>
                        <li class="breadcrumb-item"><a href="#!">Konfigurasi Sistem</a></li>
                        <li class="breadcrumb-item"><a href="user">Data User</a></li>
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
                            <h5>Data User</h5>
                        </div>
                        <div class="col">
                            <button style="float: right" type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                data-target="#modal-create" id="btn-create-supplier"><i class="fas mr-2 fa-plus"></i>
                                Tambah
                                Data</button>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <table class="table table-striped table-bordered datatable table-responsive-md" style="width:100%;"
                        id="myTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-supplier">
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
                <form id="supplierForm" name="supplierForm" class="form-horizontal">
                    <input type="hidden" class="supplier_id" name="supplier_id" id="supplier_id">
                    <div class="form-group">
                        <label for="name" class="control-label">Nama</label>
                        <input type="text" class="form-control" id="username" name="username">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-name"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email"></div>
                    </div>

                    <div class="form-group">
                        <label for="nama_barang">Role</label>
                        <select class="form-control" name="role_id" id="role_id">
                            <option selected disabled>Pilih Role</option>
                            <option value="admin-gudang" id="role_id">Admin Gudang</option>
                            <option value="penanggungjawab" id="role_id">Penanggung Jawab Gudang</option>
                            <option value="kepala-gudang" id="role_id">Kepala Gudang</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password">
                        <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-password"></div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">TUTUP</button>
                <button type="submit" class="btn btn-primary" id="saveBtn" value="create">SIMPAN</button>
            </div>
            </form>
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



<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>


@push('script')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
@endpush


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
            ajax: "{{ route('user.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {   data: 'Actions',
                    name: 'Actions',
                    orderable:false,
                    serachable:false,
                    sClass:'text-center'
                },
            ]
        });


        // Create New Supplier.
        $('#btn-create-supplier').click(function() {
            $('#saveBtn').val("create-supplier");
            $('#user_id').val('');
            $('#supplierForm').trigger("reset");
            $('#modelHeading').html("TAMBAH DATA SUPPLIER BARU");
            $('#ajaxModel').modal('show');
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var formData = $('#supplierForm').serialize();

            $.ajax({
                url: "{{ route('user.store') }}",
                // method: 'post',
                data: {
                    id: $('#user_id').val(),
                    username: $('#username').val(),
                    email: $('#email').val(),
                    role_id: $('#role_id').val(),
                    password: $('#password').val(),
                },
                // data: $('#supplierForm').serialize(),
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

                        $('#supplierForm').trigger("reset");
                        $('#saveBtn').html('SIMPAN');
                        $('#ajaxModel').modal('hide');

                        table.draw();
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
                url: "user/"+id+"/edit",
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
                url: "user/"+id,
                method: 'PUT',
                data: {
                    username: $('#editUsername').val(),
                    email: $('#editEmail').val(),
                    role_id: $('#editRole').val(),
                    password: $('#editPassword').val(),
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
                url: "user/"+id,
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

            });
        });

    });
</script>

{{-- <script>
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
            ajax: "{{ route('user.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {   data: 'Actions',
                    name: 'Actions',
                    orderable:false,
                    serachable:false,
                    sClass:'text-center'
                },
            ]
        });


        // Create New Supplier.
        $('#btn-create-supplier').click(function() {
            $('#saveBtn').val("create-supplier");
            $('#user_id').val('');
            $('#supplierForm').trigger("reset");
            $('#modelHeading').html("TAMBAH DATA SUPPLIER BARU");
            $('#ajaxModel').modal('show');
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var formData = $('#supplierForm').serialize();

            $.ajax({
                url: "{{ route('user.store') }}",
                // method: 'post',
                data: {
                    id: $('#user_id').val(),
                    username: $('#username').val(),
                    email: $('#email').val(),
                    role_id: $('#role_id').val(),
                    password: $('#password').val(),
                },
                // data: $('#supplierForm').serialize(),
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

                        $('#supplierForm').trigger("reset");
                        $('#saveBtn').html('SIMPAN');
                        $('#ajaxModel').modal('hide');

                        table.draw();
                    }
                }
            });
        });

       // Edit Data Supplier
       $('body').on('click', '.edit-supplier', function() {
            var user = $(this).data('id');
            $.get("{{ route('user.index') }}" + '/' + user + '/edit', function(
                data) {
                $('#modelHeading').html("EDIT DATA SUPPLIER");
                $('#saveBtn').val("edit-supplier");
                $('#ajaxModel').modal('show');
                $('#user_id').val(data.id);
                $('#nama-supplier').val(data.nama_supplier);
                $('#email-supplier').val(data.email_supplier);
                $('#alamat-supplier').val(data.alamat_supplier);
                $('#tlp-supplier').val(data.tlp_supplier);
            })
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

            });
        });

    });
</script> --}}
