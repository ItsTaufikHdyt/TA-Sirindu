@extends('admin::layouts.app')
@section('title')
Si Rindu
@endsection
@section('title-content')
Home
@endsection
@section('item')
Admin Posyandu
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