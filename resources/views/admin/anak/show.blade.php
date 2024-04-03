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
{{-- @php dd($bbu,$resultFuzzyBB_U) @endphp --}}
<div class="col">
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
            <tr>
                <td>Indeks Massa Tubuh (IMT) / Umur</td>
                <td>{{$hasil['imt']}}</td>
            </tr>
            @endforeach
        </table>
    </div>
    <div class="col">
        @foreach ($bbu as $index => $bbuData)
        <div class="py-2 my-1 text-center position-relative mx-2">
            <div class="position-absolute w-100 top-50 start-50 translate-middle" style="z-index: 2">
                <span class="d-inline-block bg-white px-2 text-muted">Bulan {{$bbuData['bln']}} </span>
            </div>
            <div class="position-absolute w-100 top-50 start-0 border-muted border-top"></div>
        </div>
        @if(isset($resultFuzzyBB_U[$index]))
        @php $fuzzyData = $resultFuzzyBB_U[$index]; @endphp
        <div class="card mb-4 mt-4 d-flex align-items-stretch">
            <div class="card-header">
                Nilai Z-Score Bulan {{$bbuData['bln']}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label>Median BB/U</label>
                            <input type="text" value="{{$bbuData['b']}}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>SB BB/U</label>
                            @if($bbuData['a'] == null)
                            <input type="text" value="{{$bbuData['c']}}" class="form-control" readonly>
                            @elseif($bbuData['c'] == null)
                            <input type="text" value="{{$bbuData['a']}}" class="form-control" readonly>
                            @endif
                        </div>
                        <div class="form-group">
                            <label>Z-Score BB/U</label>
                            <input type="text" value="{{$bbuData['bbu']}}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label>Median TB/U</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>SB TB/U</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Z-Score TB/U</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label>Median BB/TB</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>SB BB/TB</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Z-Score BB/TB</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col col-md-3">
                        <div class="form-group">
                            <label>Median IMT/U</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>SB IMT/U</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label>Z-Score IMT/U</label>
                            <input type="text" value="" class="form-control" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-3 d-flex align-items-stretch">
                <div class="card">
                    <div class="card-header">
                        Indeks BB/U Bulan {{$bbuData['bln']}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Berat Badan Sangat Kurang (severely
                                        underweight)</label>
                                    <input type="text" value="{{$fuzzyData['BBSK']}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Berat Badan Kurang (underweight)</label>
                                    <input type="text" value="{{$fuzzyData['BBK']}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Berat Badan Normal</label>
                                    <input type="text" value="{{$fuzzyData['BBN']}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Risiko Berat Badan Lebih</label>
                                    <input type="text" value="{{$fuzzyData['RBBL']}}" class="form-control" readonly>
                                </div>
                                <div class="col">
                                    <label for="">Status Gizi Balita Indeks BB/U</label>
                                    @if($fuzzyData['maxKey'] == 'BBSK')
                                    <input type="text" value="Berat Badan Sangat Kurang" class="form-control" readonly>
                                    @elseif($fuzzyData['maxKey'] == 'BBK')
                                    <input type="text" value="Berat Badan Kurang" class="form-control" readonly>
                                    @elseif($fuzzyData['maxKey'] == 'BBN')
                                    <input type="text" value="Berat Badan Normal" class="form-control" readonly>
                                    @elseif($fuzzyData['maxKey'] == 'RBBL')
                                    <input type="text" value="Risiko Berat Badan Lebih" class="form-control" readonly>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 d-flex align-items-stretch">
                <div class="card">
                    <div class="card-header">
                        Indeks BB/U Bulan {{$bbuData['bln']}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Sangat Pendek (severely Stunted)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Pendek (Stunted)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Normal</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Tinggi</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="col">
                                    <label for="">Status Gizi Balita Indeks TB/U</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 d-flex align-items-stretch">
                <div class="card">
                    <div class="card-header">
                        Indeks BB/TB Bulan {{$bbuData['bln']}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Gizi Buruk (Severely Wasted)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Gizi Kurang (Wasted)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Gizi Baik (Normal)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Berisiko Gizi Berlebih (possible risk of
                                        overweight)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Gizi lebih (overweight)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Obesitas (obese)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="col">
                                    <label for="">Status Gizi Balita Indeks BB/TB</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 d-flex align-items-stretch">
                <div class="card">
                    <div class="card-header">
                        Indeks IMT/U Bulan {{$bbuData['bln']}}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label>Gizi Buruk (Severely Wasted)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Gizi Kurang (Wasted)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Gizi Baik (Normal)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Berisiko Gizi Berlebih (possible risk of
                                        overweight)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Gizi lebih (overweight)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Obesitas (obese)</label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                                <div class="col">
                                    <label for="">Status Gizi Balita Indeks IMT/U </label>
                                    <input type="text" value="" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>

@endsection