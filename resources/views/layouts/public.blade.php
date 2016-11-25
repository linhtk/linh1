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