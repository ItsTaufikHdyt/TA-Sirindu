<!DOCTYPE html>
<html>
@section('htmlheader')
@include('admin::layouts.partials.htmlheader')
@show

<body>
    @include('admin::layouts.partials.mainheader')
    @include('admin::layouts.partials.rightsidebar')
    @include('admin::layouts.partials.leftsidebar')
    
    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="title">
                                <h4>@yield('title-content')</h4>
                            </div>
                            @include('admin::layouts.partials.breadcrumb')
                        </div>
                    </div>
                </div>
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                    @yield('content')
                </div>
            </div>
            <div class="footer-wrap pd-20 mb-20 card-box">
           SPK Gizi  © 2024 Taufik Hidayat 
        </div>
    </div>
    @section('scripts')
    @include('admin::layouts.partials.scripts')
    @show
</body>

</html>