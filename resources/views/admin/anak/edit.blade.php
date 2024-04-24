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
Edit Anak
@endsection
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form method="post" action="{{route('admin.updateAnak',$anak->id)}}">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama <font color="red">*</font></label>
                <input type="text" name="nama" value="{{$anak->nama}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama Ayah <font color="red">*</font></label>
                <input type="text" name="nama_ayah" value="{{$anak->nama_ayah}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama Ibu <font color="red">*</font></label>
                <input type="text" name="nama_ibu" value="{{$anak->nama_ibu}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Jenis Kelamin <font color="red">*</font></label>
                <select name="jk" class="form-control">
                    <option value="1" @if ($anak->jk == 1) selected @endif >Laki - Laki</option>
                    <option value="2" @if ($anak->jk == 2) selected @endif>Perempuan</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tempat Lahir <font color="red">*</font></label>
                <input type="text" name="tempat_lahir" value="{{$anak->tempat_lahir}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tanggal Lahir <font color="red">*</font></label>
                <input type="date" name="tgl_lahir" value="{{$anak->tgl_lahir}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" value="{{$anak->alamat}}" class="form-control">
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Umur (Bulan) <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="text" name="bln" value="{{$dt->bln}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Tinggi Badan Lahir <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="text" name="tb" value="{{$dt->tb}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Berat Badan Lahir <font color="red">* gunakan titik (.) untuk koma</font></label>
                <input type="text" name="bb" value="{{$dt->bb}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
<br>
<div class="py-2 my-1 text-center position-relative mx-2">
    <div class="position-absolute w-100 top-50 start-50 translate-middle" style="z-index: 2">
        <span class="d-inline-block bg-white px-2 text-muted">Data Berkala Anak</span>
    </div>
    <div class="position-absolute w-100 top-50 start-0 border-muted border-top"></div>
</div>
<br>
<div class="row">
    @foreach ($dataAnak as $data)
    <form method="post" action="{{route('admin.updateDataAnak',$data->id)}}">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <div class="col">
            <label>Umur {{$data->bln}} Bulan</label>
            <div class="form-group">
                <label>Posisi</label>
                <select name="posisi" class="form-control" require>
                    <option value="H" @if($data->posisi == 'H') selected @endif>H (Berdiri)</option>
                    <option value="L" @if($data->posisi == 'L') selected @endif>L (Berbaring)</option>
                </select>
                <label>Tinggi Badan <font color="red">* titik (.) untuk koma</font></label>
                <input type="text" name="tb" value="{{$data->tb}}" class="form-control" require>
                <label>Berat Badan <font color="red">* titik (.) untuk koma</font></label>
                <input type="text" name="bb" value="{{$data->bb}}" class="form-control" require>
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    @endforeach
</div>
@endsection
