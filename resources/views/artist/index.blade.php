@extends("layout")
@section("title", $title)
@section('content')
    <div class="artist-container" id="artist_list">
        <m-swipe swipeid="swipe" ref="swiper" :autoplay="0" effect="coverflow">
            <div v-for="item in artist" class="swiper-slide" slot="swiper-con">
                <a :href="'{{ url('artists') }}/' + item.id" class="link-item">
                    <span class="img-con">
                      <img :data-src="item.image" class="swiper-lazy silde-img">
                    </span>
                    <span class="art-con">
                        <span class="title">@{{ item.name }}</span><br>
                        <span class="product-num overText"><i class="fa fa-heart-o"></i>@{{ item.followCount }}</span>
                        <span class="product-num overText"><i class="fa fa-bar-chart"></i>@{{ item.goodsCount }}件</span>
                        <span class="overTextH3">@{{ item.intro }}</span>
                      </span>
                </a>
            </div>
        </m-swipe>
    </div>
@endsection
@section('javascript')
    {!! \App\FctCommon::weChatJs($share) !!}
    <script src="/js/swiper.js"></script>
    <script type="text/x-template" id="m_swipe">
        <div class="swiper-container" :class="swipeid">
            <div class="swiper-wrapper">
                <slot name="swiper-con"></slot>
            </div>
        </div>
    </script>
    <script>
        config.artist = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="/js/artist_list.js"></script>
@endsection