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
        <div>
            <a href="{{route('opd.exportAllExcel')}}" class="btn btn-success">
                <font color="white"><i class="fa fa-cloud-download" aria-hidden="true"></i> Export Data</font>
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabel-anak" class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Nama Ibu</th>
                        <th scope="col">Nama Ayah</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
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
            ajax: "{{ route('opd.getAnak') }}",
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
            ],
            columnDefs: [{
                targets: 3,
                function(data, type, row) {
                    return data.substr(0, 50);
                }
            }]
        });
    });

</script>
@endsection