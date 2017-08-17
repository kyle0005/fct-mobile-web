@extends("layout")
@section('content')
    <div class="encyclopedias-container" id="encyclopediasdetail" v-cloak>
        <head-top></head-top>
        <section class="artist">
            <div class="intro">
                <span class="photo">
                  <img :src="detail.image">
                </span>
                <span class="artist-info">
                    <span class="artist-name">@{{ detail.name }}</span><br>
                    <span v-html="detail.intro"></span>
                </span>
            </div>
            <div v-html="detail.description"></div>
            <div class="comment" v-if="detail.productList && detail.productList.length > 0">
                <ul class="others">
                    <li v-for="p in detail.productList">
                        <a :href="'{{ url('products') }}/' + p.id" class="item">
                            <img v-view="p.defaultImage" src="{{ fct_cdn('/images/img_loader.gif') }}">
                            <span class="p-title">@{{ p.name }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </section>
    </div>
@endsection
@section('javascript')
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.detail = {!! json_encode($entry, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/encyclopedias_detail.js') }}"></script>
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