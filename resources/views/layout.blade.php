<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- build:css styles/main.css -->
    <link rel="stylesheet" href="css/app.css">
    <!-- endbuild -->
</head>
<body>
    @yield('header')
    @yield('content')
    <script src="js/vue.js"></script>
    @yield('javascript')
</body>
</html>
