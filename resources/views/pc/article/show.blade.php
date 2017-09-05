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
<div>
    <div class="yw-mid-con yw-news-lay">
        <div class="yw-news-lay-x">
            <div>
                {!! $html !!}
            </div>
        </div>
        <a href="{{ url('/') }}" class="back">
            <img src="{{ fct_cdn('/img/fct/p_back.png') }}"><span class="txt">返回全部</span>
        </a>
    </div>
    <i class="yw-mid-i"></i>
</div>
<div id="ywPage" class="yw-page">
    <div id="contact" class="yw-footer">
        <div class="yw-constr">
            <div class="yw-footerbox">
                <p class="yw-footer-copyright">
                    Copyright&nbsp&copy;&nbsp;<script>document.write((new Date).getFullYear())</script>&nbsp;,宜兴方寸堂文化传媒有限公司<span class="br">版权所有</span></p>
                <p class="yw-footer-copyrightmore">苏公安备32028202000436号&nbsp;苏ICP备14043090号-4</p>
                <p class="yw-footer-copyrightmore">联系电话：<a href="tel:4000510570" class="law">400-0510-570</a></p></div>
            <div class="yw-footer-share">
                <a href="{{ fct_cdn('/img/fct/qrcode-gzh.jpg') }}"
                   class="icon-share icon-share-weixin" title="方寸堂官方微信公众号" target="_blank">方寸堂官方微信公众号</a>
                <a href="javascript:;" class="icon-share icon-share-weibo" title="方寸堂官方微博" target="_blank">方寸堂官方微博</a>
            </div>
        </div>
    </div>
</div>