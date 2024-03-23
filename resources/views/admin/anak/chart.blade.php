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
Chart Data Anak
@endsection
@section('content')
<!-- <div class="container">
    <canvas id="myChart" height="100px"></canvas>
</div> -->
<input type="hidden" value="{{$anak->id}}" id="id-anak">
<div class="row">
       <div class="col-md-10 col-md-offset-1">
           <div class="panel panel-default">
               <div class="panel-heading"><b>Chart Data Tinggi Badan Anak {{$anak->nama}}</b></div>
               <div class="panel-body">
                   <canvas id="canvas" height="280" width="600"></canvas>
               </div>
           </div>
       </div>
       <div class="col-md-10 col-md-offset-1">
           <div class="panel panel-default">
               <div class="panel-heading"><b>Chart Data Berat Badan Anak {{$anak->nama}}</b></div>
               <div class="panel-body">
                   <canvas id="canvas2" height="280" width="600"></canvas>
               </div>
           </div>
       </div>
</div>
@endsection
@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
<script type="text/javascript">
    var id1 = document.getElementById("id-anak").value; 
    var Bln = new Array();
    var Tb = new Array();
    $(document).ready(function() {
        $.get('{{url("admin/get-chart-data-dasar-anak")}}' + '/' + id1, function(response) {

            data1 = JSON.parse(JSON.stringify(response.bln));
            data2 = JSON.parse(JSON.stringify(response.tb));

            data1.forEach(function(datax) {
                Bln.push(datax.bln);
            });
            data2.forEach(function(datax) {
                Tb.push(datax.tb);
            });
            
            var ctx = document.getElementById("canvas").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Bln,
                    datasets: [{
                        label: 'Tinggi Badan',
                        data: Tb,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    });
</script>
<script type="text/javascript">
    let id2 = document.getElementById("id-anak").value; 
    var Bln2 = new Array();
    var Bb = new Array();
    $(document).ready(function() {
        $.get('{{url("admin/get-chart-data-dasar-anak")}}' + '/' + id2, function(response) {

            data1 = JSON.parse(JSON.stringify(response.bln));
            data2 = JSON.parse(JSON.stringify(response.bb));

            data1.forEach(function(datax) {
                Bln2.push(datax.bln);
            });
         
            data2.forEach(function(datax) {
                Bb.push(datax.bb);
            });
            var ctx = document.getElementById("canvas2").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: Bln2,
                    datasets: [{
                        label: 'Berat Badan',
                        data: Bb,
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        });
    });
</script>
@endpush