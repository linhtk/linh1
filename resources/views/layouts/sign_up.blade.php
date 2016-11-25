<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="@yield('author')">
    <meta name="description" content="@yield('description')">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{{ csrf_token() }}}">

    <title>@yield('title', 'My Website')</title>

    <script type="text/javascript" src="{{ URL::asset('js/jquery-1.11.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/bootstrap-datepicker.js') }}"></script>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
    <!-- Font -->
    <link href="{{ asset('/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" >
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&amp;subset=vietnamese" rel="stylesheet">

    <link href="{{ asset('/css/slick.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('/css/slick-theme.css') }}" rel="stylesheet" type="text/css" >
    <!-- style plugin -->

    <link href="{{ asset('/css/fonts.css') }}" rel="stylesheet" type="text/css" >

    <!-- Style -->
    <link href="{{ asset('/css/sign_up.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('/css/default.css') }}" rel="stylesheet" type="text/css" >
    <link href="{{ asset('/css/media_all.css') }}" rel="stylesheet" type="text/css" >

    @yield('styles')
    @yield('scripts')
    @yield('head')
</head>
<body>
@section('header')
    <a href="{{ url('/') }}"> Home </a>                                                                                                                </Home></a> <br/> <br/>
@show

@yield('content')


@section('footer')
@show


</body>
</html>