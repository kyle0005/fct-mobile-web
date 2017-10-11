@extends("layout")
@section('content')
    <div class="index-container" id="welcome" v-cloak>
        <m-swipe swipeid="swipe" ref="swiper" :autoplay="0" effect="slide" @slideindex="slideindex">
            <div v-for="(top, index) in tops" class="swiper-slide" slot="swiper-con">
                <a :href="top.url" class="link">
                    <img :data-src="top.image" class="swiper-lazy silde-img">
                </a>
                <a href="{{ url('/') }}" class="enter"  v-if="index==0"></a>
            </div>
        </m-swipe>
        <transition name="fade">
            <div class="top" v-if="flagIndex">
                <div class="inner">
                    <div class="text">
                        <div class="title">方寸堂</div>
                        <div class="vtitle">只为不同</div>
                    </div>
                    <img src="{{ fct_cdn('/img/mobile/logo2.png') }}" class="logo">
                    <div class="btn-container">
                        <a href="{{ url('/') }}" class="btn">进入</a>
                    </div>
                </div>
            </div>
        </transition>
    </div>

    <script type="text/x-template" id="m_swipe">
        <div class="swiper-container" :class="swipeid">
            <div class="swiper-wrapper">
                <slot name="swiper-con"></slot>
            </div>
            <!-- 分页器 -->
            <div :class="{'swiper-pagination':pagination}"></div>
        </div>
    </script>
@endsection
@section('javascript')
    <script>
        config.slides = {!! $slides !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/swiper.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/welcome.js') }}"></script>
    {!! wechat_share($share) !!}
    <script>
        var _mtac = {};
        (function() {
            var mta = document.createElement("script");
            mta.src = "http://pingjs.qq.com/h5/stats.js?v2.0.2";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500500357");
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        })();
    </script>
@endsection
