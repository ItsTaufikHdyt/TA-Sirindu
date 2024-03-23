@extends('admin::layouts.app')
@section('title')
Admin - SiRindu
@endsection
@section('title-content')
Data
@endsection
@section('item')
Data
@endsection
@section('item-active')
Data Anak
@endsection
@section('content')
<form method="post" action="{{route('admin.storeDataAnak')}}">
    @csrf
    <div class="row">
        <input type="hidden" name="id_anak" value="{{$anak->id}}" class="form-control" require>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama <font color="red">*</font></label>
                <input type="text" name="nama" value="{{$anak->nama}}" class="form-control" require readonly>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Umur (Bulan) <font color="red">*</font></label>
                <input type="text" name="bln" value="{{$bulanSekarang}}" class="form-control" require readonly>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Posisi<font color="red">*</font></label>
                <select name="posisi" class="form-control" require>
                    <option value="H">H</option>
                    <option value="L">L</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tinggi Badan <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="number" step="any" name="tb" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Berat Badan <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="number" step="any" name="bb" class="form-control" require>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>

@endsection