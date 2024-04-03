@extends('admin::layouts.login')
@section('title')

@endsection
@section('content')
<div class="login-header box-shadow">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="brand-logo">
            <a href="#">
                <img src="{{asset('logo/spkgizi-black.png')}}" width="50" height="50" alt="">
            </a>
        </div>
        <div class="login-menu">

            <div class="row justify-content-center">
                @if(session('error'))
                <div class="alert alert-danger text-center" id="login-error">
                    {{ session('error') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="login-wrap d-flex align-items-center flex-wrap justify-content-center" id="login">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-7">
                <img src="{{asset('admin/vendors/images/medicine.svg')}}" alt="">
            </div>
            <div class="col-md-6 col-lg-5">
                <div class="login-box bg-white box-shadow border-radius-10">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="login-title">
                        <h2 class="text-center text-primary">Login</h2>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="input-group custom">
                            <input id="nik" type="text" name="email" class="form-control @error('nik') is-invalid @enderror form-control-lg" value="{{ old('email') }}" placeholder="Email">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror form-control-lg" placeholder="**********">
                            <div class="input-group-append custom">
                                <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <div class="captcha">
                                <span>{!! captcha_img('math') !!}</span>
                                <button type="button" class="btn btn-danger" class="reload" id="reload">
                                    &#x21bb;
                                </button>
                            </div>
                        </div>
                        <div class="input-group custom">
                            <div class="form-group mb-4">
                                <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="input-group mb-0">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" value="Sign In">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('#reload').click(function() {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function(data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
    setTimeout(function() {
        var loginError = document.getElementById('login-error');
        if (loginError) {
            loginError.style.display = 'none';
        }
    }, 3000);
</script>
@endsection