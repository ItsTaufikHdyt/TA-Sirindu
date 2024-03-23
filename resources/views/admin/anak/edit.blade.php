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
                <label>Nama Ibu <font color="red">*</font></label>
                <input type="text" name="nama_ibu" value="{{$anak->nama_ibu}}" class="form-control" require>
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
<svg id="wave" style="transform:rotate(180deg); transition: 0.3s" viewBox="0 0 1440 120" version="1.1" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="sw-gradient-0" x1="0" x2="0" y1="1" y2="0">
            <stop stop-color="rgba(62, 102.987, 243, 1)" offset="0%"></stop>
            <stop stop-color="rgba(239.418, 239.418, 239.418, 0.14)" offset="100%"></stop>
        </linearGradient>
    </defs>
    <path style="transform:translate(0, 0px); opacity:1" fill="url(#sw-gradient-0)" d="M0,24L21.8,20C43.6,16,87,8,131,4C174.5,0,218,0,262,14C305.5,28,349,56,393,70C436.4,84,480,84,524,72C567.3,60,611,36,655,38C698.2,40,742,68,785,84C829.1,100,873,104,916,92C960,80,1004,52,1047,50C1090.9,48,1135,72,1178,70C1221.8,68,1265,40,1309,26C1352.7,12,1396,12,1440,28C1483.6,44,1527,76,1571,80C1614.5,84,1658,60,1702,48C1745.5,36,1789,36,1833,48C1876.4,60,1920,84,1964,92C2007.3,100,2051,92,2095,84C2138.2,76,2182,68,2225,70C2269.1,72,2313,84,2356,76C2400,68,2444,40,2487,40C2530.9,40,2575,68,2618,82C2661.8,96,2705,96,2749,90C2792.7,84,2836,72,2880,68C2923.6,64,2967,68,3011,62C3054.5,56,3098,40,3120,32L3141.8,24L3141.8,120L3120,120C3098.2,120,3055,120,3011,120C2967.3,120,2924,120,2880,120C2836.4,120,2793,120,2749,120C2705.5,120,2662,120,2618,120C2574.5,120,2531,120,2487,120C2443.6,120,2400,120,2356,120C2312.7,120,2269,120,2225,120C2181.8,120,2138,120,2095,120C2050.9,120,2007,120,1964,120C1920,120,1876,120,1833,120C1789.1,120,1745,120,1702,120C1658.2,120,1615,120,1571,120C1527.3,120,1484,120,1440,120C1396.4,120,1353,120,1309,120C1265.5,120,1222,120,1178,120C1134.5,120,1091,120,1047,120C1003.6,120,960,120,916,120C872.7,120,829,120,785,120C741.8,120,698,120,655,120C610.9,120,567,120,524,120C480,120,436,120,393,120C349.1,120,305,120,262,120C218.2,120,175,120,131,120C87.3,120,44,120,22,120L0,120Z"></path>
</svg>
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
                    <option value="H" @if($data->posisi == 'H') selected @endif>H</option>
                    <option value="L" @if($data->posisi == 'L') selected @endif>L</option>
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
