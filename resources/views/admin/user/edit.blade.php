@extends('admin::layouts.app')
@section('title')
Admin - Si Rindu
@endsection
@section('title-content')
User
@endsection
@section('item')
User
@endsection
@section('item-active')
Edit User
@endsection
@section('content')
@if($errors->any())
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    @foreach ($errors->all() as $error)
    <ul>
        <li> <strong>{{ $error }}</strong></li>
    </ul>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<form method="post" action="{{route('admin.updateUser',$user->id)}}">
    @csrf
    <input type="hidden" name="_method" value="PUT">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Nama</label>
                <input name="name" value="{{$user->name}}" class="form-control" type="text" placeholder="Nama">
                @error('name') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Email</label>
                <input name="email" value="{{$user->email}}" class="form-control" type="email" placeholder="mail">
                @error('email') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="form-group">
                <label>Type</label>
                <select class="form-control" name="type">
                    <option value="0" {{$user->type == 'admin' ? 'selected' : ''}}>Admin</option>
                    <option value="1" {{$user->type == 'opd' ? 'selected' : ''}}>OPD</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <input type="checkbox" id="gantiPassword" name="centang" class="i-checks" onclick="passwordChange()"> Ganti Password<br>
            <div class="form-group">
                <label>Password</label>
                <input id="pass" name="password" class="form-control" type="password" disabled="true" placeholder="***********">
                @error('password') <span class="text-danger">{{ $message }}</span>@enderror
            </div>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
@endsection
@section('custom_scripts')
<script type="text/javascript">
    function passwordChange() {
        var cb = document.getElementById('gantiPassword');
        var pass = document.getElementById('pass');

        if (cb.checked) {
            pass.disabled = false;
            pass.focus();
        } else {
            pass.disabled = true;
        }
    }

    function lokasi() {
        var cb = document.getElementById('gantiLokasi');
        var kecx = document.getElementById('kecx');
        var kelx = document.getElementById('kelx');
        var posyandux = document.getElementById('posyandux');
        var puskesmasx = document.getElementById('puskesmasx');

        if (cb.checked) {
            kecx.disabled = false;
            kecx.focus();
            posyandux.disabled = false;
            posyandux.focus();
            puskesmasx.disabled = false;
            puskesmasx.focus();
            kelx.disabled = false;
            kelx.focus();
            
        } else {
            kecx.disabled = true;
            puskesmasx.disabled = true;

            posyandux.disabled = true;

            kelx.disabled = true;

        }
    }

    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#kecx').on('change', function() {
            var id = $(this).val();
            $.ajax({
                    url: '{{url("admin/get-kel-dasar-anak")}}' + '/' + id,
                    success: function(response) {
                        $('#kelx').empty();

                        $.each(response, function(id, name) {
                            $('#kelx').append(new Option(name, id))
                        })
                    }
                }),
                $.ajax({
                    url: '{{url("admin/get-puskesmas-dasar-anak")}}' + '/' + id,
                    success: function(response) {
                        $('#puskesmasx').empty();

                        $.each(response, function(id, name) {
                            $('#puskesmasx').append(new Option(name, id))
                        })
                    }
                })
        });

        $('#puskesmasx').on('change', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("admin/get-posyandu-dasar-anak")}}' + '/' + id,
                success: function(response) {
                    $('#posyandux').empty();

                    $.each(response, function(id, name) {
                        $('#posyandux').append(new Option(name, id))
                    })
                }
            })
        });
    });
</script>
@endsection