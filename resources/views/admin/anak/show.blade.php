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
Show Data Anak
@endsection
@section('content')
<div class="table-responsive">
    <table class="table">
        <tr>
            <td>Nama</td>
            <td>{{$anak->nama}}</td>
        </tr>
        <tr>
            <td>Nama Ibu</td>
            <td>{{$anak->nama_ibu}}</td>
        </tr>
        <tr>
            <td>Nama Ayah</td>
            <td>{{$anak->nama_ayah}}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>@if ($anak->jk == 1)
                <span class="badge badge-success">Laki-Laki</span>
                @elseif ($anak->jk == 2)
                <span class="badge badge-warning">Perempuan</span>
                @endif
            </td>
        </tr>
        <tr>
            <td>Tempat Lahir</td>
            <td>{{$anak->tempat_lahir}}</td>
        </tr>
        <tr>
            <td>Tanggal Lahir</td>
            <td>{{$anak->tgl_lahir}}</td>
        </tr>
    </table>
    <h3>Data Berkala</h3>
    <table class="table">
        @foreach ($hasilx as $hasil)
        <tr>
            <td style="background-color:#e1f1e0">Bulan</td>
            <td style="background-color:#e1f1e0">{{$hasil['bln']}}</td>
        </tr>
        <tr>
            <td>Tinggi Badan</td>
            <td>{{$hasil['tinggi']}}</td>
        </tr>
        <tr>
            <td>Berat Badan</td>
            <td>{{$hasil['berat']}}</td>
        </tr>
        <tr>
            <td>Indeks Massa Tubuh (IMT) / Umur</td>
            <td>{{$hasil['imt']}}</td>
        </tr>
        <tr>
            <td>Berat Badan / Umur</td>
            <td>{{$hasil['bb']}}</td>
        </tr>
        <tr>
            <td>Tinggi Badan / Umur</td>
            <td>{{$hasil['tb']}}</td>
        </tr>
        <tr>
            <td>Berat Badan / Tinggi Badan</td>
            <td>{{$hasil['bt']}}</td>
        </tr>
        @endforeach

    </table>
</div>
@endsection