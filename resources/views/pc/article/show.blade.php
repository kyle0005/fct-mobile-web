<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit" />
    <meta dynamic-meta name="mobile-agent" content="format=html5; url={{ env('APP_URL') }}" />
    <title>{{ $title }}</title>
    <meta name="keywords" content="方寸网,方寸堂,全手工紫砂壶,真正宜兴紫砂壶,宜兴,宜兴紫砂陶,紫砂壶原产地,紫砂壶名家,紫砂壶鉴别">
    <meta name="description" content="方寸堂系紫砂壶线上门户综合平台，为壶友提供宜兴紫砂壶作品和官方权威的信息服务，每件作品都出自作者本人并采用纯天然宜兴紫砂泥料手工制作而成。">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="//cdn.fangcun.com/static/img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="{{ fct_cdn('/css/pc.app.css') }}">
    <script>!function (e, n) {
            var a = 0, o = 'M', t = e.documentElement
            window.screen && screen.width && (a = screen.width, a > 1920 ? o = 'L' : a < 480 && (o = 'S')), t.className = o, navigator.platform && (t.className += ' ' + navigator.platform.toLowerCase()), window.SIZE = o
        }(document, window)</script>
</head>
<body>
<div class="detail-container">
    <div class="yw-mid-con yw-news-lay">
        <div class="yw-news-lay-x">
            <div id="news-detail" class="news-list">
                {!! $html !!}
            </div>
        </div>
        <a href="/" class="back" id="back">
            <img src="{{ fct_cdn('/img/fct/p_back.png') }}"><span class="txt">返回全部</span>
        </a>
    </div>
</div>
