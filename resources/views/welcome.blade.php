@extends("layout")


@section('content')
    <div class="index-container" id="welcome">
        <div class="btns">
            <div class="enter">
                <a href="{{ url('/') }}">
                    <span>进入商城</span>
                </a>
            </div>
            <div class="download">
                <a href="{{ url('download/app') }}">
                    <span>下载APP</span>
                </a>
            </div>
        </div>
        <m-swipe swipeid="swipe" ref="swiper" :autoplay="0" effect="slide">
            <div v-for="top in tops" class="swiper-slide" slot="swiper-con">
                <img :data-src="top.image" class="swiper-lazy silde-img">
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
