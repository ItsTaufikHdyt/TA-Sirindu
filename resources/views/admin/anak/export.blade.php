@extends('admin::layouts.app')
@section('title')
Admin
@endsection
@section('title-content')
Data
@endsection
@section('item')
Data
@endsection
@section('item-active')
Export Data Anak
@endsection
@section('content')
<form method="post" action="{{route('admin.formViewExport')}}">
    @csrf
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>From Date <font color="red">*</font></label>
                <input type="date" name="from_date" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>To Date <font color="red">*</font></label>
                <input type="date" name="to_date" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Kecamatan <font color="red">*</font></label>
                <select id="kec" name="id_kec" class="form-control" require>
                    <option value="">== Select Kecamatan ==</option>
                    @foreach ($kec as $id => $data)
                    <option value="{{$data->id}}">{{$data->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Puskesmas <font color="red">*</font></label>
                <select id="puskesmas" name="id_puskesmas" class="form-control" require>
                    <option value="">== Select Puskesmas ==</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Kelurahan <font color="red">*</font></label>
                <select id="kel" name="id_kel" class="form-control" require>
                    <option value="">== Select Kelurahan ==</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Posyandu <font color="red">*</font></label>
                <select id="posyandu" name="id_posyandu" class="form-control" require>
                    <option value="">== Select Posyandu ==</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>RT <font color="red">*</font></label>
                <select id="rt" name="id_rt" class="form-control" require>
                    <option value="">== Select RT ==</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-warning">Export</button>
            <a href="{{route('admin.exportAllExcel')}}"  class="btn btn-success">Export Data All</a>
        </div>
    </div>
</form>

@endsection
@section('custom_scripts')
<script type="text/javascript">
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#kec').on('change', function() {
            var id = $(this).val();
            $.ajax({
                    url: '{{url("admin/get-kel-dasar-anak")}}' + '/' + id,
                    success: function(response) {
                        $('#kel').empty();
                        $('#kel').append(new Option('====== Kelurahan ======', 0));
                        $.each(response, function(id, name) {
                            $('#kel').append(new Option(name, id))
                        })
                    }
                }),
                $.ajax({
                    url: '{{url("admin/get-puskesmas-dasar-anak")}}' + '/' + id,
                    success: function(response) {
                        $('#puskesmas').empty();
                        $('#puskesmas').append(new Option('====== Puskesmas ======', 0));
                        $.each(response, function(id, name) {
                            $('#puskesmas').append(new Option(name, id))
                        })
                    }
                })
        });

        $('#puskesmas').on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("admin/get-posyandu-dasar-anak")}}' + '/' + id,
                success: function(response) {
                    $('#posyandu').empty();
                    $('#posyandu').append(new Option('====== Posyandu ======', 0));
                    $.each(response, function(id, name) {
                        $('#posyandu').append(new Option(name, id))
                    })
                }
            })
        });

        $('#posyandu').on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("admin/get-rt-dasar-anak")}}' + '/' + id,
                success: function(response) {
                    $('#rt').empty();
                    $('#rt').append(new Option('====== RT ======', 0));

                    $.each(response, function(id, name) {
                        $('#rt').append(new Option(name, id))
                    })
                }
            })
        });
    });
</script>
@endsection