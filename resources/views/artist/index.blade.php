@extends("layout")
@section('content')
    <div class="artist-container" id="artist_list">
        <m-swipe swipeid="swipe" ref="swiper" :autoplay="0" effect="coverflow">
            <div v-for="(item, index) in artist" class="swiper-slide" slot="swiper-con">
                <a :href="'{{ url('artists', [], env('APP_SECURE')) }}/' + item.id" class="link-item">
                    <span class="img-con">
                        <img v-view="item.image" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}" class="silde-img">
                    </span>

                    <span class="art-con">
                        <span class="title">@{{ item.name }}</span><span class="">@{{ item.title }}</span><br>
                        <span class="product-num overText"><i class="fa fa-heart-o"></i>@{{ item.followCount }}</span>
                        <span class="product-num overText"><img src="{{ fct_cdn('/img/mobile/zhh.png') }}" class="i-img">@{{ item.goodsCount }}件</span>
                        <span class="overTextH3">@{{ item.intro }}</span>
                    </span>
                </a>
            </div>
        </m-swipe>
        <no-data v-if="nodata"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="pager-loader" v-if="pagerloading">
    </div>

    <script type="text/x-template" id="m_swipe">
        <div class="swiper-container" :class="swipeid">
            <div class="swiper-wrapper">
                <slot name="swiper-con"></slot>
            </div>
        </div>
    </script>

@endsection
@section('javascript')
    <script src="{{ fct_cdn('/js/mobile/swiper.js') }}"></script>
    <script>
        config.artist = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/artist_list.js') }}"></script>
    {!! wechat_share($share) !!}
    <script>
        var _mtac = {};
        (function() {
            var mta = document.createElement("script");
            mta.src = "https://pingjs.qq.com/h5/stats.js?v2.0.2";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500500357");
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        })();
    </script>
@endsection