@extends('admin::layouts.app')
@section('title')
Admin - Si Rindu
@endsection
@section('title-content')
Data
@endsection
@section('item')
Data
@endsection
@section('item-active')
Anak
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      Data Anak
      <a href="{{route('admin.createAnak')}}" class="btn btn-primary">
        <font color="white"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</font>
    </a>
    </div>
    <div class="card-body">
        @if (Auth::user()->type == 'super-admin')
        <br><br>
        <div class="table-responsive">
            <table id="tabel-anak" class="table table-striped">
                <thead>
                    <tr>               
                        <th scope="col">Nama</th>
                        <th scope="col">Nama Ibu</th>
                        <th scope="col">Nama Ayah</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @elseif (Auth::user()->type == 'admin')
        <div class="table-responsive">
            <table id="tabel-anak-adm" class="table table-striped">
                <thead>
                    <tr>               
                        <th scope="col">Nama</th>
                        <th scope="col">Nama Ibu</th>
                        <th scope="col">Nama Ayah</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        @endif
    </div>
  </div>
@endsection
@section('custom_scripts')
<script type="text/javascript">
    $(function() {
        var table = $('#tabel-anak').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.getAnak') }}",
            columns: [
                {
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu',
                },
                {
                    data: 'nama_ayah',
                    name: 'nama_ayah',
                },
                {
                    data: 'edit',
                    name: 'edit',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                targets: 3,
                function(data, type, row) {
                    return data.substr(0, 50);
                }
            }]
        });

    });

    //--------------Fungsi Delete ------------
    function deleteItemAnak(e) {

        let id = e.getAttribute('data-id');
        let token = '{{ csrf_token() }}';

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "DELETE",
                        url: '{{ url("admin/destroy-data-dasar-anak")}}' + '/' + id,
                        data: {
                            id: id,
                            '_token': token
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    "success"
                                );
                                $("#" + id + "").remove();
                                window.location.reload(true); // you can add name div to remove
                            }

                        }
                    });

                }

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                );
            }
        });

    }

    $(function() {
        var table = $('#tabel-anak-adm').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.getAnakAdm') }}",
            columns: [
                {
                    data: 'no_kk',
                    name: 'no_kk',
                },
                {
                    data: 'nik',
                    name: 'nik',
                },
                {
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'nik_ortu',
                    name: 'nik_ortu',
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu',
                },
                {
                    data: 'nama_ayah',
                    name: 'nama_ayah',
                },
                {
                    data: 'edit',
                    name: 'edit',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                targets: 5,
                function(data, type, row) {
                    return data.substr(0, 50);
                }
            }]
        });

    });

    //--------------Fungsi Delete ------------
    function deleteItemAnak(e) {

        let id = e.getAttribute('data-id');
        let token = '{{ csrf_token() }}';

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "DELETE",
                        url: '{{ url("admin/destroy-data-dasar-anak")}}' + '/' + id,
                        data: {
                            id: id,
                            '_token': token
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    "success"
                                );
                                $("#" + id + "").remove();
                                window.location.reload(true); // you can add name div to remove
                            }

                        }
                    });

                }

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                );
            }
        });

    }

    $(function() {
        var table = $('#tabel-anak-ps').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.getAnakPs') }}",
            columns: [
                {
                    data: 'no_kk',
                    name: 'no_kk',
                },
                {
                    data: 'nik',
                    name: 'nik',
                },
                {
                    data: 'nama',
                    name: 'nama',
                },
                {
                    data: 'nik_ortu',
                    name: 'nik_ortu',
                },
                {
                    data: 'nama_ibu',
                    name: 'nama_ibu',
                },
                {
                    data: 'nama_ayah',
                    name: 'nama_ayah',
                },
                {
                    data: 'edit',
                    name: 'edit',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'delete',
                    name: 'delete',
                    orderable: false,
                    searchable: false
                }
            ],
            columnDefs: [{
                targets: 5,
                function(data, type, row) {
                    return data.substr(0, 50);
                }
            }]
        });

    });

    //--------------Fungsi Delete ------------
    function deleteItemAnak(e) {

        let id = e.getAttribute('data-id');
        let token = '{{ csrf_token() }}';

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                if (result.isConfirmed) {

                    $.ajax({
                        type: "DELETE",
                        url: '{{ url("admin/destroy-data-dasar-anak")}}' + '/' + id,
                        data: {
                            id: id,
                            '_token': token
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Your file has been deleted.',
                                    "success"
                                );
                                $("#" + id + "").remove();
                                window.location.reload(true); // you can add name div to remove
                            }

                        }
                    });

                }

            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                Swal.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                );
            }
        });

    }
</script>
@endsection