<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <title>{{ $title or "404" }}</title>
    <meta name="apple-mobile-web-app-title" content="方寸堂">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="dns-prefetch" href="//cdn.fangcun.com"/>
    <link rel="shortcut icon" href="//cdn.fangcun.com/static/img/favicon.png" type="image/png" />
    <!-- build:css styles/main.css -->
    <link rel="stylesheet" href="{{ fct_cdn('/css/app.css') }}">
    <!-- endbuild -->
</head>
<body>
    @yield('header')
    @yield('content')
    <script src="{{ fct_cdn('/js/mobile/vue.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/api/index.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/common/tools.js') }}"></script>
    <script type="text/x-template" id="head_top">
        <header class="head-container">
            <ul class="nav">
                <li class="toggle" @click="toggle()">
                    <i class="fa fa-bars"></i>
                </li>
                <li class="logo" @click="toIndex()">
                    <img src="{{ fct_cdn('/img/mobile/logo.png') }}">
                </li>
                <li class="user" @click="toLogin()">
                    <span class="img-container">
                      <img src="{{ $shareAvatar }}">
                    </span>
                </li>
            </ul>
            <div class="aside" :class="{open:open,docked:docked}" @click="toggle()">
                <div class="container">
                    <ul class="types">
                        <li class="item" v-for="(types, index) in typeList" @click="change(types.code)">
                            <span>@{{ types.name }}</span>
                            <i class="fa fa-angle-right"></i>
                        </li>
                    </ul>
                    <ul class="lines clearfix">
                        <li class="item">
                            <a href="{{ url('auction', [], env('APP_SECURE')) }}">
                                <img src="{{ fct_cdn('/img/mobile/pm_logo.png') }}">
                                <span>拍卖</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="{{ url('artists', [], env('APP_SECURE')) }}">
                                <img src="{{ fct_cdn('/img/mobile/menu1.png') }}">
                                <span>守艺人</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="{{ url('wiki', [], env('APP_SECURE')) }}">
                                <img src="{{ fct_cdn('/img/mobile/menu2.png') }}">
                                <span>百科</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="{{ url('welcome', [], env('APP_SECURE')) }}">
                                <img src="{{ fct_cdn('/img/mobile/menu5.png') }}">
                                <span>品牌理念</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    </script>
    <script>
        var config = {
            "index": "{{ url('/', [], env('APP_SECURE')) }}",
            "login": "{{ url('my', [], env('APP_SECURE')) }}",
            "product_url": "{{ url('/', [], env('APP_SECURE')) }}"
        }
    </script>
    @yield('javascript')
</body>
</html>
