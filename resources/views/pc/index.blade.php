<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>方寸堂</title>
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
<img src="{{ fct_cdn('/img/fct/yw-share-cover.png') }}" style="position:absolute;left:-99em">
<div id="ywBarX" class="yw-bar">
    <div class="yw-constr">
        <div class="yw-hd-bar">
            <a href="{{ url('/') }}" class="yw-logo"><h1>方寸堂</h1></a>
        </div>
        <div id="ywHdBar" class="yw-hd-bar">
            <a href="{{ url('/') }}" class="yw-logo"><h1>方寸堂</h1></a>
            <a href="javascript:" id="ywMnavBtn" class="yw-hd-curnav"><span id="ywMnavName">紫砂细作</span></a>
            <div id="ywMnav" class="yw-nav">
                <a href="#copyright" class="yw-nav-a active">紫砂细作</a>
                <a href="#mobile" class="yw-nav-a">移动平台</a>
                <a href="#brand" class="yw-nav-a">守艺人</a>
                <a href="#news" class="yw-nav-a">新闻中心</a>
                <a href="#contact" class="yw-nav-a">联系我们</a>
            </div>
        </div>
    </div>
</div>
<div id="ywPage" class="yw-page">
    <div id="ywHeader" class="yw-header">
        <div class="yw-constr">
            <div class="yw-hd-slide-x">
                <div id="hdSlide1" class="yw-hd-slide-li yw-hd-slide-1 active"><s class="yw-hd-slide-bg"></s>
                    <div class="yw-hd-slide-con"><h2 class="yw-hd-slide-h">方寸之间，大于天地</h2>
                        <p class="yw-hd-slide-p">引领紫砂行业，发掘实力派<span class="hidden"><br></span>让紫砂走进千家万户！</p></div>
                </div>
                <div id="hdSlide2" class="yw-hd-slide-li yw-hd-slide-2"><s class="yw-hd-slide-bg"></s>
                    <div class="yw-hd-slide-con">
                        <h2 class="yw-hd-slide-h">&nbsp;</h2>
                        <p class="yw-hd-slide-p">&nbsp;</p>
                    </div>
                </div>
                <div id="hdSlide3" class="yw-hd-slide-li yw-hd-slide-3">
                    <s class="yw-hd-slide-bg"></s>
                    <div class="yw-hd-slide-con">
                        <h2 class="yw-hd-slide-h yw-font-helv">&nbsp;</h2>
                        <p class="yw-hd-slide-p">&nbsp;</p>
                    </div>
                </div>
            </div>
            <div id="hdDotX" class="yw-hd-dot-x">
                <a href="javascript:" class="yw-hd-dot-a active" data-rel="hdSlide1">1</a>
                <a href="javascript:" class="yw-hd-dot-a" data-rel="hdSlide2">2</a>
                <a href="javascript:" class="yw-hd-dot-a" data-rel="hdSlide3">3</a>
            </div>
        </div>
    </div>

    <div class="yw-data">
        <div class="yw-constr">
            <div class="yw-data-view">
                <dl class="yw-data-dl yw-data-dl-1">
                    <dt class="yw-data-dt"><i class="icons-pbm-p"></i><span class="yw-data-num">108</span>位实力派</dt>
                    <dd class="yw-data-dd">完善的实力派孵化和培养体系，打造紫砂艺人、消费收藏者、平台互生共荣的文化生态体系。</dd>
                </dl>
                <dl class="yw-data-dl yw-data-dl-2">
                    <dt class="yw-data-dt"><i class="icons-pbm-b"></i>上万把紫砂作品</dt>
                    <dd class="yw-data-dd">原创实力派紫砂壶作品已覆盖行业 90% 以上，覆盖100多种紫砂品类。</dd>
                </dl>
                <dl class="yw-data-dl yw-data-dl-3">
                    <dt class="yw-data-dt"><i class="icons-pbm-m"></i>千万用户</dt>
                    <dd class="yw-data-dd">完善的实力派孵化和培养体系，打造紫砂艺人、消费收藏者、平台互生共荣的文化生态体系。</dd>
                </dl>
            </div>
            <p class="yw-data-desc">宜兴方寸堂文化传播有限公司，是一家由十多年从事紫砂艺术收藏的资深藏家组成的实力团队，公司设有紫砂研发中心、创作团队及新人培养基地，设立此平台的目的在于给天下壶友和紫砂艺人间搭建一个透明、便捷、真实的紫砂创作、交流平台。</p></div>
    </div>

    <div id="copyright" class="yw-copyright">
        <h3 class="yw-home-h3">紫砂细作</h3>
        <div id="ywCopyX" class="yw-copy-x">
            <ul class="yw-copy-center">
                <?php $series = 0;?>
                @foreach($products as $key => $product)
                    @if (!($key % 2))
                <li class="yw-copy-li">
                    <div class="yw-copy-part {{ $series ? 'yw-copy-part-l' : 'yw-copy-part-s'}}">
                        <img class="yw-ip-img" data-src="{{$series ? $product->defaultImage : $product->videoImage }}" alt="{{ $product->name }}">
                        <div class="yw-ip-desc">
                            <div class="yw-mid-con">
                                <h6 class="yw-ip-name">{{ $product->name }}</h6>
                                <i class="yw-copy-line"></i>
                                <p class="yw-ip-text"><img src="{{ $qrcodeUrl.env('APP_URL') . '/products/' . $product->id }}"></p>
                            </div>
                            <i class="yw-mid-i"></i>
                        </div>
                    </div>
                    <?php $series = ($key % 3) ? 0 : 1;?>
                    @else
                    <div class="yw-copy-part {{ $series ? 'yw-copy-part-l' : 'yw-copy-part-s'}}">
                        <img class="yw-ip-img" data-src="{{$series ? $product->defaultImage : $product->videoImage }}" alt="{{ $product->name }}">
                        <div class="yw-ip-desc">
                            <div class="yw-mid-con">
                                <h6 class="yw-ip-name">{{ $product->name }}</h6>
                                <i class="yw-copy-line"></i>
                                <p class="yw-ip-text"><img src="{{ $qrcodeUrl.env('APP_URL') . '/products/' . $product->id }}"></p>
                            </div>
                            <i class="yw-mid-i"></i>
                        </div>
                    </div>
                </li>
                <?php $series = ($key % 3) ? 1 : 0;?>
                @endif
                @endforeach
                @if(count($products) % 2)
                </li>
                @endif
            </ul>
        </div>
    </div>

    <div id="mobile" class="yw-home-app">
        <div class="yw-constr"><h3 class="yw-home-h3">移动平台</h3>
            <div id="tabApp" class="yw-tab-tab"><a href="javascript:" class="yw-tab-a active" data-rel="tabPanel1">微信公众号</a> <a
                        href="javascript:" class="yw-tab-a" data-rel="tabPanel2">移动web版</a> <a href="javascript:" class="yw-tab-a"
                                                                                               data-rel="tabPanel3">微信小程序</a> <i
                        class="yw-tab-bot-line"></i> <i id="tabLine" class="yw-tab-hline"></i></div>
            <ul class="yw-tab-panel">
                <li id="tabPanel1" class="yw-tab-panel-li active">
                    <div class="yw-app-desc"><h3 class="yw-app-slogon">方寸堂微信公众号</h3>
                        <p class="yw-app-desc-detail">微信搜索“方寸堂”或"fangcuntang"。</p>
                        <div class="check-code">
                            <a href="javascript:" target="_blank" class="yw-btn-blue pop-btn" title="查看详情">查看详情 &gt;</a>
                            <div class="qrcode-contianer">
                                <div class="triangle_border_left">
                                    <span></span>
                                </div>
                                <div>
                                    <img src="{{ fct_cdn('/img/fct/qrcode-gzh.jpg') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="yw-app-img-x"><img src="{{ fct_cdn('/img/fct/platform-wxgxh.png') }}"
                                                   class="yw-app-img"></div>
                </li>
                <li id="tabPanel2" class="yw-tab-panel-li ">
                    <div class="yw-app-desc"><h3 class="yw-app-slogon">方寸堂移动Web</h3>
                        <p class="yw-app-desc-detail">官方域名：https://m.fangcun.com，支持所有浏览器终端访问。</p>
                        <div class="check-code">
                            <a href="javascript:" target="_blank" class="yw-btn-blue pop-btn" title="查看详情">查看详情 &gt;</a>
                            <div class="qrcode-contianer">
                                <div class="triangle_border_left">
                                    <span></span>
                                </div>
                                <div>
                                    <img src="{{ fct_cdn('/img/fct/qrcode-wap.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="yw-app-img-x"><img src="{{ fct_cdn('/img/fct/platform-wap.png') }}"
                                                   class="yw-app-img"></div>
                </li>
                <li id="tabPanel3" class="yw-tab-panel-li ">
                    <div class="yw-app-desc"><h3 class="yw-app-slogon">方寸堂小程序</h3>
                        <p class="yw-app-desc-detail">与时俱进，感受极致赏壶体验。</p>
                        <div class="check-code">
                            <a href="javascript:" target="_blank" class="yw-btn-blue pop-btn" title="查看详情">查看详情 &gt;</a>
                            <div class="qrcode-contianer">
                                <div class="triangle_border_left">
                                    <span></span>
                                </div>
                                <div>
                                    <img src="{{ fct_cdn('/img/fct/qrcode-gzh.jpg') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="yw-app-img-x"><img src="{{ fct_cdn('/img/fct/platform-wxxcx.png') }}"
                                                   class="yw-app-img"></div>
                </li>
            </ul>
        </div>
    </div>

    <div id="brand" class="yw-brand">
        <div class="yw-constr"><h3 class="yw-home-h3">守艺人</h3>
            <ul id="brandDescX" class="yw-brand-desc">
            @foreach($artists as $key => $artist)
                <li class="yw-brand-desc-li {{ $key ? '' : 'in' }}">
                    <p class="yw-brand-p">{!! $artist->intro !!}</p>
                    <div class="brands-qrcode">
                        <img src="{{ $qrcodeUrl.env('APP_URL') . '/artists/' . $artist->id }}">
                        <br><span>扫一扫，了解更多</span>
                    </div>

                </li>
            @endforeach
            </ul>

            <div id="brandNavX" class="yw-brand-nav-x">
            @foreach($artists as $key => $artist)
                <a href="javascript:;" target="_blank" class="yw-brand-nav-a {{ $key ? '' : 'active' }}" title="{{ $artist->name }}">
                    <img src="{{ $artist->headPortrait }}" alt="{{ $artist->name }}"><br><span>{{ $artist->name }}</span>
                </a>
            @endforeach
            </div>
        </div>
    </div>
    <div id="news" class="yw-news">
        <div class="yw-constr">
            <h3 class="yw-home-h3">新闻中心</h3>

            <div class="yw-news-x" id="yw-news-x">
            @if ($articles)
            @foreach($articles as $article)
                <div class="yw-news-li">
                    <div class="yw-news-detail">
                        <h5 class="yw-news-title"><a href="javascript:;" data-urltype="{{ $article->urlType }}" class="news-link"
                                                     data-url="{{ $article->urlType ? url('articles/' . $article->id).'?current=1' : $article->url }}" target="_blank">{{ $article->title }}</a></h5>
                        <div class="yw-news-time">
                            <span class="yw-news-tag">{{ $article->categoryName }}</span>
                            <time>{{ date('Y-m-d', intval($article->createTime / 1000)) }}</time>
                        </div>
                        <p class="yw-news-sum">{!! $article->intro !!}</p>
                        <p class="yw-news-more">
                            <a href="javascript:;" data-urltype="{{ $article->urlType }}" class="news-link yw-news-more-a"
                               data-url="{{ $article->urlType ? url('articles/' . $article->id).'?current=1' : $article->url }}" target="_blank">阅读更多 &gt;</a>
                        </p>
                    </div>
                </div>
            @endforeach
            @endif
                <a href="javascript:" class="yw-btn-blue" id="moreNews" data-page="1">查看更多 &gt;</a>
            </div>
        </div>
    </div>
    <div id="contact" class="yw-footer">
        <div class="yw-constr">
            <div class="yw-footerbox">
                <p class="yw-footer-copyright">
                    Copyright&nbsp&copy;&nbsp;<script>document.write((new Date).getFullYear())</script>&nbsp;,宜兴方寸堂文化传媒有限公司<span class="br">版权所有</span></p>
                <p class="yw-footer-copyrightmore">苏公安备32028202000436号&nbsp;苏ICP备14043090号-4</p>
                <p class="yw-footer-copyrightmore">联系电话：<a href="tel:4000510570" class="law">400-0510-570</a></p></div>
            <div class="yw-footer-share">
                <a href="{{ fct_cdn('/img/fct/fct-qrcode.png') }}"
                   class="icon-share icon-share-weixin" title="方寸堂官方微信公众号" target="_blank">方寸堂官方微信公众号</a>
                <a href="javascript:;" class="icon-share icon-share-weibo" title="方寸堂官方微博" target="_blank">方寸堂官方微博</a>
            </div>
        </div>
    </div>
</div>

<div id="ywOverlay" class="yw-overlay">
    <div class="yw-mid-con"></div>
    <i class="yw-mid-i"></i></div>
<div id="ywNewslay" class="yw-overlay">
    <div class="yw-mid-con yw-news-lay">
        <a href="javascript:" class="yw-news-lay-shut jsShut">×</a>
        <div class="yw-news-lay-x">
            <div id="news-list" class="news-list">
                <a href="javascript:" class="yw-btn-blue jsLayMore" data-page="2">查看更多</a>
            </div>
            <div id="news-detail" class="news-list">
            </div>

        </div>
    </div>
    <i class="yw-mid-i"></i>
</div>
<script src="{{ fct_cdn('/js/fastclick.js') }}"></script>
<script src="{{ fct_cdn('/js/pc.index.js') }}"></script>
<script>
    var URLLIB = "{{ fct_cdn('/js/jquery-1.9.0.js') }}";
    history.pushState, function (t) {'addEventListener' in t && t.addEventListener('DOMContentLoaded', function () {FastClick.attach(t.body)}, !1), YUEWEN.urlNewsList = '{{ url('articles') }}', YUEWEN.load(URLLIB, function () {this.init(), this.slide('#hdDotX a')})}(document)
</script>
</body>
</html>