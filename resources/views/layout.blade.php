<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <title>{{ $title or "404" }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="//cdn.fangcun.com/static/img/favicon.png" type="image/png" />
    <!-- build:css styles/main.css -->
    <link rel="stylesheet" href="{{ fct_cdn('/css/app.css?_rd=20170811') }}">
    <!-- endbuild -->
</head>
<body>
    @yield('header')
    @yield('content')
    <script src="{{ fct_cdn('/js/vue.js') }}"></script>
    <script src="{{ fct_cdn('/js/api/index.js?_rd=2017072418') }}"></script>
    <script src="{{ fct_cdn('/js/common/tools.js') }}"></script>
    <script type="text/x-template" id="head_top">
        <header class="head-container">
            <ul class="nav">
                <li class="toggle" @click="toggle()">
                    <i class="fa fa-bars"></i>
                </li>
                <li class="logo" @click="toIndex()">
                    <img src="{{ fct_cdn('/images/logo.png') }}">
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
                            <a href="{{ url('artists') }}">
                                <img src="{{ fct_cdn('/images/menu1.png') }}">
                                <span>守艺人</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="{{ url('wiki') }}">
                                <img src="{{ fct_cdn('/images/menu2.png') }}">
                                <span>百科</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="{{ url('welcome') }}">
                                <img src="{{ fct_cdn('/images/menu5.png') }}">
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
            "index": "{{ url('/') }}",
            "login": "{{ url('my') }}",
            "product_url": "{{ url('/') }}"
        }
    </script>
    @yield('javascript')
</body>
</html>
