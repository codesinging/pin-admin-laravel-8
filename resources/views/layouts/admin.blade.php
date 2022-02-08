<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', admin_config('name'))</title>
    <link rel="icon" href="{{ admin_asset('images/favicon.ico') }}">
    <link rel="stylesheet" href="{{ admin_mix('css/admin.css') }}">
    @yield('header')
</head>
<body>

<script src="{{ admin_mix('js/admin.js') }}"></script>

@yield('body')

</body>
</html>