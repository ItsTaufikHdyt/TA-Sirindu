@extends('admin::layouts.app')
@section('title')
Admin - Si Rindu
@endsection
@section('title-content')
Data
@endsection
@section('item')
Data Himpunan Fuzzy
@endsection
@section('item-active')
Himpunan Fuzzy
@endsection
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        Fungsi Keanggotaan BB/U (Anak Usia 0 - 60 Bulan)
        <a data-toggle="modal" data-target="#createFuzzyModal" type="button" class="btn btn-primary">
            <font color="white"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Tambah Data</font>
        </a>
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Himpunan Fuzzy</td>
                    <td>Tipe</td>
                    <td>Range Nilai</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                @php
                $no=1;
                @endphp
                @foreach($fuzzy1 as $data)
                <tr>
                    <td>
                        {{ $no++ }}
                    </td>
                    <td>
                        {{ $data->name }}
                    </td>
                    <td>
                        @if($data->type == 1)
                        Linear Naik
                        @elseif($data->type == 2)
                        Linear Turun
                        @elseif($data->type == 3)
                        Segitiga
                        @elseif($data->type == 4)
                        Trapesium
                        @endif
                    </td>
                    <td>@if($data->type == 1)
                        [{{ $data->a }}] [{{ $data->b }}]
                        @elseif($data->type == 2)
                        [{{ $data->a }}] [{{ $data->b }}]
                        @elseif($data->type == 3)
                        [{{ $data->a }}] [{{ $data->b }}] [{{ $data->c }}]
                        @elseif($data->type == 4)
                        [{{ $data->a }}] [{{ $data->b }}] [{{ $data->c }}] [{{ $data->d }}]
                        @endif
                    </td>
                    <td>
                        <button data-toggle="modal" data-target="#editFuzzyModal{{ $data->id }}" type="button"
                            class="btn btn-warning" onclick="updateInputsx({{$data->id}})">Edit</button>
                        @include('admin.fuzzy.edit')
                        <button data-toggle="modal" data-target="#confirmationModal{{ $data->id }}" type="button"
                            class="btn btn-danger">Delete</button>
                        @include('admin.fuzzy.delete-confirmation')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header">
        Fungsi Keanggotaan PB/U atau TB/U (Anak Usia 0 - 60 Bulan)
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Himpunan Fuzzy</td>
                    <td>Tipe</td>
                    <td>Range Nilai</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                @php
                $no=1;
                @endphp
                @foreach($fuzzy2 as $data)
                <tr>
                    <td>
                        {{ $no++ }}
                    </td>
                    <td>
                        {{ $data->name }}
                    </td>
                    <td>
                        @if($data->type == 1)
                        Linear Naik
                        @elseif($data->type == 2)
                        Linear Turun
                        @elseif($data->type == 3)
                        Segitiga
                        @elseif($data->type == 4)
                        Trapesium
                        @endif
                    </td>
                    <td>@if($data->type == 1)
                        [{{ $data->a }}] [{{ $data->b }}]
                        @elseif($data->type == 2)
                        [{{ $data->a }}] [{{ $data->b }}]
                        @elseif($data->type == 3)
                        [{{ $data->a }}] [{{ $data->b }}] [{{ $data->c }}]
                        @elseif($data->type == 4)
                        [{{ $data->a }}] [{{ $data->b }}] [{{ $data->c }}] [{{ $data->d }}]
                        @endif
                    </td>
                    <td>
                        <button data-toggle="modal" data-target="#editFuzzyModal{{ $data->id }}" type="button"
                            class="btn btn-warning" onclick="updateInputsx({{$data->id}})">Edit</button>
                        @include('admin.fuzzy.edit')
                        <button data-toggle="modal" data-target="#confirmationModal{{ $data->id }}" type="button"
                            class="btn btn-danger">Delete</button>
                        @include('admin.fuzzy.delete-confirmation')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header">
        Fungsi Keanggotaan BB/PB atau BB/TB (Anak Usia 0 - 60 Bulan)
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Himpunan Fuzzy</td>
                    <td>Tipe</td>
                    <td>Range Nilai</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                @php
                $no=1;
                @endphp
                @foreach($fuzzy3 as $data)
                <tr>
                    <td>
                        {{ $no++ }}
                    </td>
                    <td>
                        {{ $data->name }}
                    </td>
                    <td>
                        @if($data->type == 1)
                        Linear Naik
                        @elseif($data->type == 2)
                        Linear Turun
                        @elseif($data->type == 3)
                        Segitiga
                        @elseif($data->type == 4)
                        Trapesium
                        @endif
                    </td>
                    <td>@if($data->type == 1)
                        [{{ $data->a }}] [{{ $data->b }}]
                        @elseif($data->type == 2)
                        [{{ $data->a }}] [{{ $data->b }}]
                        @elseif($data->type == 3)
                        [{{ $data->a }}] [{{ $data->b }}] [{{ $data->c }}]
                        @elseif($data->type == 4)
                        [{{ $data->a }}] [{{ $data->b }}] [{{ $data->c }}] [{{ $data->d }}]
                        @endif
                    </td>
                    <td>
                        <button data-toggle="modal" data-target="#editFuzzyModal{{ $data->id }}" type="button"
                            class="btn btn-warning" onclick="updateInputsx({{$data->id}})">Edit</button>
                        @include('admin.fuzzy.edit')
                        <button data-toggle="modal" data-target="#confirmationModal{{ $data->id }}" type="button"
                            class="btn btn-danger">Delete</button>
                        @include('admin.fuzzy.delete-confirmation')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<br>
<div class="card">
    <div class="card-header">
        Fungsi Keanggotaan IMT/U (Anak Usia 0 - 60 Bulan)
    </div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Nama Himpunan Fuzzy</td>
                    <td>Tipe</td>
                    <td>Range Nilai</td>
                    <td>Aksi</td>
                </tr>
            </thead>
            <tbody>
                @php
                $no=1;
                @endphp
                @foreach($fuzzy4 as $data)
                <tr>
                    <td>
                        {{ $no++ }}
                    </td>
                    <td>
                        {{ $data->name }}
                    </td>
                    <td>
                        @if($data->type == 1)
                        Linear Naik
                        @elseif($data->type == 2)
                        Linear Turun
                        @elseif($data->type == 3)
                        Segitiga
                        @elseif($data->type == 4)
                        Trapesium
                        @endif
                    </td>
                    <td>@if($data->type == 1)
                        [{{ $data->a }}] [{{ $data->b }}]
                        @elseif($data->type == 2)
                        [{{ $data->a }}] [{{ $data->b }}]
                        @elseif($data->type == 3)
                        [{{ $data->a }}] [{{ $data->b }}] [{{ $data->c }}]
                        @elseif($data->type == 4)
                        [{{ $data->a }}] [{{ $data->b }}] [{{ $data->c }}] [{{ $data->d }}]
                        @endif
                    </td>
                    <td>
                        <button data-toggle="modal" data-target="#editFuzzyModal{{ $data->id }}" type="button"
                            class="btn btn-warning" onclick="updateInputsx({{$data->id}})">Edit</button>
                        @include('admin.fuzzy.edit')
                        <button data-toggle="modal" data-target="#confirmationModal{{ $data->id }}" type="button"
                            class="btn btn-danger">Delete</button>
                        @include('admin.fuzzy.delete-confirmation')
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@include('admin.fuzzy.create')
@endsection
@section('custom_scripts')
<script type="text/javascript">
    const select = document.getElementById('type');
    const a = document.getElementById('a');
    const b = document.getElementById('b');
    const c = document.getElementById('c');
    const d = document.getElementById('d');

    a.style.display = 'none';
    b.style.display = 'none';
    c.style.display = 'none';
    d.style.display = 'none';
    // Function to update input fields based on selected option
    function updateInputs() {
        const selectedOption = select.value;
        if (selectedOption == 1) {
            a.style.display = 'block';
            b.style.display = 'block';
            c.style.display = 'none';
            d.style.display = 'none';
        } else if (selectedOption == 2) {
            a.style.display = 'block';
            b.style.display = 'block';
            c.style.display = 'none';
            d.style.display = 'none';
        } else if (selectedOption == 3) {
            a.style.display = 'block';
            b.style.display = 'block';
            c.style.display = 'block';
            d.style.display = 'none';
        } else if (selectedOption == 4) {
            a.style.display = 'block';
            b.style.display = 'block';
            c.style.display = 'block';
            d.style.display = 'block';
        }
    }

    // Event listener for select element
    select.addEventListener('change', updateInputs);

    // Initial call to update inputs based on default selected option
    updateInputs();


    //edit
    const selectx = document.getElementById('typex');
    const idx = document.getElementById('idx').value; 
    const ax = document.getElementById('ax');
    const bx = document.getElementById('bx');
    const cx = document.getElementById('cx');
    const dx = document.getElementById('dx');

    ax.style.display = 'none';
    bx.style.display = 'none';
    cx.style.display = 'none';
    dx.style.display = 'none';
    // Function to update input fields based on selected option
    function updateInputsx(idx) {
        // const idx = document.getElementById('idx'); 
        const selectx = document.getElementById('typex'+idx);
        const selectedOption = selectx.value;
        const ax = document.getElementById('ax'+idx);
        const bx = document.getElementById('bx'+idx);
        const cx = document.getElementById('cx'+idx);
        const dx = document.getElementById('dx'+idx);
        if (selectedOption == 1) {
            ax.style.display = 'block';
            bx.style.display = 'block';
            cx.style.display = 'none';
            dx.style.display = 'none';
        } else if (selectedOption == 2) {
            ax.style.display = 'block';
            bx.style.display = 'block';
            cx.style.display = 'none';
            dx.style.display = 'none';
        } else if (selectedOption == 3) {
            ax.style.display = 'block';
            bx.style.display = 'block';
            cx.style.display = 'block';
            dx.style.display = 'none';
        } else if (selectedOption == 4) {
            ax.style.display = 'block';
            bx.style.display = 'block';
            cx.style.display = 'block';
            dx.style.display = 'block';
        }
    }
    // Event listener for select element
    // selectx.addEventListener('change', updateInputsx);
    // Initial call to update inputs based on default selected option
    updateInputsx();

    $(".modal").on("hidden.bs.modal", function () {
        $(this).find('form').trigger('reset');
        a.style.display = 'none';
        b.style.display = 'none';
        c.style.display = 'none';
        d.style.display = 'none';
    });

</script>
@endsection