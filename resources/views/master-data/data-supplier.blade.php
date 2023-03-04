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
                            <li class="breadcrumb-item"><a href="data-supplier">Data Suppliers</a></li>
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
                                    <th>Nama Supplier</th>
                                    <th>Alamat</th>
                                    <th>Email</th>
                                    <th>Telepon</th>
                                    <th>Status</th>
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
                            <input type="text" class="form-control" id="nama-supplier" name="nama-supplier">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama-supplier"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <input type="email" class="form-control" id="email-supplier" name="email-supplier">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-email-supplier"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">Alamat</label>
                            <textarea name="alamat-supplier" id="alamat-supplier" class="form-control" rows="3"></textarea>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat-supplier"></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">No Telepon</label>
                            <input type="number" class="form-control" id="tlp-supplier" name="tlp-supplier">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tlp-supplier"></div>
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
            ajax: "{{ route('data-supplier.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'email_supplier',
                    name: 'email_supplier'
                },
                {
                    data: 'alamat_supplier',
                    name: 'alamat_supplier'
                },
                {
                    data: 'tlp_supplier',
                    name: 'tlp_supplier'
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


        // Create New Supplier.
        $('#btn-create-supplier').click(function() {
            $('#saveBtn').val("create-supplier");
            $('#supplier_id').val('');
            $('#supplierForm').trigger("reset");
            $('#modelHeading').html("TAMBAH DATA SUPPLIER BARU");
            $('#ajaxModel').modal('show');
        });

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $(this).html('Sending..');
            var formData = $('#supplierForm').serialize();

            $.ajax({
                url: "{{ route('data-supplier.store') }}",
                // method: 'post',
                data: {
                    id: $('#supplier_id').val(),
                    nama_supplier: $('#nama-supplier').val(),
                    email_supplier: $('#email-supplier').val(),
                    alamat_supplier: $('#alamat-supplier').val(),
                    tlp_supplier: $('#tlp-supplier').val(),
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
            var supplier_id = $(this).data('id');
            $.get("{{ route('data-supplier.index') }}" + '/' + supplier_id + '/edit', function(
                data) {
                $('#modelHeading').html("EDIT DATA SUPPLIER");
                $('#saveBtn').val("edit-supplier");
                $('#ajaxModel').modal('show');
                $('#supplier_id').val(data.id);
                $('#nama-supplier').val(data.nama_supplier);
                $('#email-supplier').val(data.email_supplier);
                $('#alamat-supplier').val(data.alamat_supplier);
                $('#tlp-supplier').val(data.tlp_supplier);
            })
        });


        // Arsipkan Data
        $('body').on('click', '#delete-supplier', function() {

            swal({
                    title: "Apakah anda yakin?",
                    text: "Setelah diNon-Aktifkan, Data Tidak Bisa Melakukan Transaksi Lagi!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })

                .then((willDelete) => {
                    if (willDelete) {
                        var supplier_id = $(this).data("id");
                        $.ajax({
                            type: "DELETE",
                            url: 'data-supplier/' + supplier_id,
                            data: supplier_id,
                            success: function(response) {
                                swal(response.status, {
                                        icon: "success",
                                    })
                                    .then((result) => {
                                        table.draw();
                                    });
                            }
                        });
                    } else {
                        swal("Cancel!", "Perintah dibatalkan!", "error");

                    }
                });
        });

    });
</script>
