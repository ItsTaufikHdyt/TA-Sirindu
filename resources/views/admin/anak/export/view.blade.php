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
View Export Data Anak
@endsection
@section('content')
<a href="{{Route('admin.formViewExportExcel')}}" class="btn btn-success">Export Data</a>
@include('admin.anak.export.table')
@endsection