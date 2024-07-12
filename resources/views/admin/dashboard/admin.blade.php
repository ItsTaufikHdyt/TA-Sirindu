@extends('admin::layouts.app')
@section('title')
Si Rindu
@endsection
@section('title-content')
Home
@endsection
@section('item')
Admin
@endsection
@section('item-active')
Home
@endsection
@section('content')
<div class="row align-items-center">
    <div class="col-md-4">
        <img src="{{asset('admin/vendors/images/banner-img.png')}}" alt="">
    </div>
    <div class="col-md-8">
        <h4 class="font-20 weight-500 mb-10 text-capitalize">
            Welcome back <div class="weight-600 font-30 text-blue">{{Auth::user()->name}}</div>
        </h4>
        <p class="font-18 max-width-600">
        </p>
    </div>
</div>
@endsection
@section('content2')
<div class="row">
    <div class="col-xl-3 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-header text-white">
                <h4 class="mb-0">Berat Badan Menurut Umur</h4>
            </div>
            <div class="card-body">
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Berat Badan Sangat Kurang</h5>
                        <span class="badge badge-danger">{{$totalBBSK}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Berat Badan Kurang</h5>
                        <span class="badge badge-warning">{{$totalBBK}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Berat Badan Normal</h5>
                        <span class="badge badge-success">{{$totalBBN}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Risiko Berat Badan Lebih</h5>
                        <span class="badge badge-info">{{$totalRBBL}}</span>
                    </div>
                </div>
                <hr>
                <canvas id="chartBBU"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-3 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-header text-white">
                <h4 class="mb-0">Tinggi Badan Menurut Umur</h4>
            </div>
            <div class="card-body">
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Sangat Pendek</h5>
                        <span class="badge badge-danger">{{$totalSP}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Pendek</h5>
                        <span class="badge badge-warning">{{$totalP}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Normal</h5>
                        <span class="badge badge-success">{{$totalN}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Tinggi</h5>
                        <span class="badge badge-info">{{$totalT}}</span>
                    </div>
                </div>
                <hr>
                <canvas id="chartTBU"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-3 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-header text-white">
                <h4 class="mb-0">Berat Badan Menurut Tinggi Badan</h4>
            </div>
            <div class="card-body">
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Gizi Buruk</h5>
                        <span class="badge badge-danger">{{$totalGBK}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Gizi Kurang</h5>
                        <span class="badge badge-warning">{{$totalGK}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Gizi Baik</h5>
                        <span class="badge badge-success">{{$totalGB}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Berisiko Gizi Lebih</h5>
                        <span class="badge badge-info">{{$totalBGL}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Gizi Lebih</h5>
                        <span class="badge badge-warning">{{$totalGL}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Obesitas</h5>
                        <span class="badge badge-danger">{{$totalO}}</span>
                    </div>
                </div>
                <hr>
                <canvas id="chartBBTB"></canvas>
            </div>
        </div>
    </div>

    <div class="col-xl-3 mb-30">
        <div class="card-box height-100-p widget-style1">
            <div class="card-header text-white">
                <h4 class="mb-0">Indeks Massa Tubuh Menurut Umur</h4>
            </div>
            <div class="card-body">
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Gizi Buruk</h5>
                        <span class="badge badge-danger">{{$totalGBK_IMT}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Gizi Kurang</h5>
                        <span class="badge badge-warning">{{$totalGK_IMT}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Gizi Baik</h5>
                        <span class="badge badge-success">{{$totalGB_IMT}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Berisiko Gizi Lebih</h5>
                        <span class="badge badge-info">{{$totalBGL_IMT}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Gizi Lebih</h5>
                        <span class="badge badge-warning">{{$totalGL_IMT}}</span>
                    </div>
                </div>
                <div class="widget-data">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Obesitas</h5>
                        <span class="badge badge-danger">{{$totalO_IMT}}</span>
                    </div>
                </div>
                <hr>
                <canvas id="chartIMTU"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection
@section('custom_scripts')
<script>
    const ctxBBU = document.getElementById('chartBBU').getContext('2d');
    const chartBBU = new Chart(ctxBBU, {
        type: 'pie',
        data: {
            labels: ['Berat Badan Sangat Kurang', 'Berat Badan Kurang', 'Berat Badan Normal', 'Risiko Berat Badan Lebih'],
            datasets: [{
                label: 'Persentase BB/U',
                data: [
                    {{ $percentages['BBSK'] }},
                    {{ $percentages['BBK'] }},
                    {{ $percentages['BBN'] }},
                    {{ $percentages['RBBL'] }}
                ],
                backgroundColor: [
                    '#dc3545',
                    '#ffc107',
                    '#28a745',
                    '#17a2b8'
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff'
                ],
                borderWidth: 1
            }]
        }
    });

    const ctxTBU = document.getElementById('chartTBU').getContext('2d');
    const chartTBU = new Chart(ctxTBU, {
        type: 'pie',
        data: {
            labels: ['Sangat Pendek', 'Pendek', 'Normal', 'Tinggi'],
            datasets: [{
                label: 'Persentase TB/U',
                data: [
                    {{ $percentages['SP'] }},
                    {{ $percentages['P'] }},
                    {{ $percentages['N'] }},
                    {{ $percentages['T'] }}
                ],
                backgroundColor: [
                    '#dc3545',
                    '#ffc107',
                    '#28a745',
                    '#17a2b8'
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff'
                ],
                borderWidth: 1
            }]
        }
    });

    const ctxBBTB = document.getElementById('chartBBTB').getContext('2d');
    const chartBBTB = new Chart(ctxBBTB, {
        type: 'pie',
        data: {
            labels: ['Gizi Buruk', 'Gizi Kurang', 'Gizi Baik', 'Berisiko Gizi Lebih', 'Gizi Lebih', 'Obesitas'],
            datasets: [{
                label: 'Persentase BB/TB',
                data: [
                    {{ $percentages['GBK'] }},
                    {{ $percentages['GK'] }},
                    {{ $percentages['GB'] }},
                    {{ $percentages['BGL'] }},
                    {{ $percentages['GL'] }},
                    {{ $percentages['O'] }}
                ],
                backgroundColor: [
                    '#dc3545',
                    '#ffc107',
                    '#28a745',
                    '#17a2b8',
                    '#ffc107',
                    '#dc3545'
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff'
                ],
                borderWidth: 1
            }]
        }
    });

    const ctxIMTU = document.getElementById('chartIMTU').getContext('2d');
    const chartIMTU = new Chart(ctxIMTU, {
        type: 'pie',
        data: {
            labels: ['Gizi Buruk', 'Gizi Kurang', 'Gizi Baik', 'Berisiko Gizi Lebih', 'Gizi Lebih', 'Obesitas'],
            datasets: [{
                label: 'Persentase IMT/U',
                data: [
                    {{ $percentages['GBK_IMT'] }},
                    {{ $percentages['GK_IMT'] }},
                    {{ $percentages['GB_IMT'] }},
                    {{ $percentages['BGL_IMT'] }},
                    {{ $percentages['GL_IMT'] }},
                    {{ $percentages['O_IMT'] }}
                ],
                backgroundColor: [
                    '#dc3545',
                    '#ffc107',
                    '#28a745',
                    '#17a2b8',
                    '#ffc107',
                    '#dc3545'
                ],
                borderColor: [
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff',
                    '#ffffff'
                ],
                borderWidth: 1
            }]
        }
    });
</script>
@endsection