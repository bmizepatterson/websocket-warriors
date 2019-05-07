<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Gugi">

    <title>@yield('title')</title>
</head>
<body>
    <div class="d-flex flex-column h-100 justify-content-center align-items-center">
        <div id="app"></div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
