<!DOCTYPE html>
<html>
@section('htmlheader')
@include('admin::layouts.partials.htmlheader')
@show

<body class="login-page">
@yield('content')
    @section('scripts')
    @include('admin::layouts.partials.scripts')
    @show
</body>

</html>