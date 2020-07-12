<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    
    @include('includes/head_tags')
    @stack('stylesheets')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div id="app" class="wrapper">
        @include('includes/nav_header')
        @include('includes/sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    @yield('script')
    @stack('scripts')
    @include('includes/foot_tags')
    <!--<script src="{{ asset('js/app.js') }}" defer></script>-->
</body>
</html>
