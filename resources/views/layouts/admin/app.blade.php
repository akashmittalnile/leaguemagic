<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    {{-- <link href="{{ asset('public/css/app.css') }}" rel="stylesheet"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/header-footer.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/css/setting.css') }}">

    <!-- Google Fonts -->
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css"> --}}
    {{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css"> --}}
    {{-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> --}}
    <link href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

    @stack('css')

    <!-- Scripts -->
    {{-- <script src="{{ asset('public/js/app.js') }}" defer></script> --}}

    <!-- jQuery -->
    <script src="{{ asset('public/admin/js/jquery-3.7.0.min.js') }}"></script>
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <!-- Bootstrap -->
    <script src="{{ asset('public/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('public/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- custom js -->
    <script src="{{ asset('public/admin/js/function.js') }}"></script>
    <script src="{{ asset('public/admin/js/function.js') }}"></script>
    <script src="{{ asset('public/admin/js/admin.js') }}"></script>


    @stack('js')
</head>

<body class="main-site">
    <div id="app" class="page-body-wrapper">

        {{-- SIDEBAR LEFT --}}
        @include('backend.partials.sidebar')

        <div class="body-wrapper ">
            {{-- MAIN NAVIGATION BAR --}}
            @include('backend.partials.navbar')

            <div class="body-main-content">
                @yield('content')
            </div>
        </div>

        {{-- <footer class="main-footer">
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer> --}}
    </div>

    <script src="https://unpkg.com/sweetalert2@7.19.3/dist/sweetalert2.all.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}

    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}', 'Error', {
                    closeButtor: true,
                    progressBar: true
                });
            @endforeach
        @endif
    </script>
</body>

</html>
