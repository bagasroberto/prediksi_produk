(function () {

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('data-barang') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'id', name: 'id' },
            { data: 'nama_produk', name: 'nama_produk' },
            { data: 'harga', name: 'harga' },
            { data: 'stok', name: 'stok' },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
        ]
    });

});
