@extends("layout")


@section('content')
    <div class="index-container" id="welcome" v-cloak>
        <a href="{{ url('/') }}" class="enter"></a>
        <m-swipe swipeid="swipe" ref="swiper" :autoplay="0" effect="slide">
            <div v-for="(top, index) in tops" class="swiper-slide" slot="swiper-con">
                <a :href="top.url">
                    <img :data-src="top.image" class="swiper-lazy silde-img">
                </a>
                <div class="top" v-if="index > 0">
                    <div class="inner">
                        <div class="text">
                            <div class="title">方寸堂</div>
                            <div class="vtitle">自有我天地</div>
                        </div>
                        <img src="{{ fct_title('/images/logo2.png') }}" class="logo">
                        <div class="btn-container">
                            <a href="{{ url('/') }}" class="btn">进入</a>
                        </div>
                    </div>
                </div>
            </div>
        </m-swipe>
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
    <script src="{{ fct_cdn('js/swiper.js') }}"></script>
    <script src="{{ fct_cdn('js/welcome.js') }}"></script>
@endsection
