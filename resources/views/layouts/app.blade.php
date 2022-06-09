<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="h-100">
<head>
    <meta charset="utf-8">
	<!-- PAGE TITLE HERE -->
	<title>{{config('app.name')}}</title>
	<!-- Style css -->
    <link href="{{ asset('admin/css/style.css')}}" rel="stylesheet">
</head>
<body class="vh-100">
    <div class="authincation h-100">
        @yield('content')
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
     <!-- Required vendors -->
     <script src="{{ asset('admin/js/global.min.js') }}"></script>
     <script src="{{ asset('admin/js/jquery.nice-select.min.js') }}"></script>
     <!-- Dashboard 1 -->
     <script src="{{ asset('admin/js/custom.min.js') }}"></script>
     <script src="{{ asset('admin/js/dlabnav-init.js') }}"></script>
     <script src="{{ asset('admin/js/demo.js') }}"></script>
</body>
</html>