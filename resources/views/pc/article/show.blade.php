<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit" />
    <meta dynamic-meta name="mobile-agent" content="format=html5; url={{ env('APP_URL') }}" />
    <title>{{ $title }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
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
            <img src="public/img/fct/p_back.png"><span class="txt">返回全部</span>
        </a>
    </div>
</div>
