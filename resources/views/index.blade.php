@extends("layout")
@section('content')
    <div class="main-container" id="main" v-cloak>
        <head-top @changelist="getprolist" :isindex="isindex"></head-top>
        <section class="cat-container">
            <ul class="category clearfix">
                <li class="item" v-for="(ranks, index) in ranks_list" :class="{chosen: index===tab_num}" @click="getprolist('', ranks.id, index)">
                    <img :src= "ranks.img">
                    <span>@{{ ranks.name }}</span>
                </li>
            </ul>
        </section>
        <div class="prolist-container">
            <ul class="prolist" v-if="pro_list && pro_list.length > 0" v-load-more="nextPage" type="1">
                <li class="item" v-for="item in pro_list">
                    <a :href="'/products/' + item.id">
                        <span class="pro-main"><img v-view="item.videoImg" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}"></span>
                        <span class="title">@{{ item.name }}</span>
                        <span class="description" v-html="item.intro"></span>
                        <span class="pro-lists">
                            <span class="imgs" v-for="image in item.multiImages">
                                <img v-view="image" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                            </span>
                        </span>
                        <span class="ops">
                          <img src="{{ fct_cdn('/img/mobile/clickAmount.png') }}"><span>@{{ item.viewCount }}</span>
                          <img src="{{ fct_cdn('/img/mobile/saleAmount.png') }}"><span>@{{ item.commentCount }}</span>
                        </span>
                    </a>
                </li>
            </ul>

            <no-data v-if="nodata" imgurl="{{ fct_cdn('/img/mobile/no_data.png') }}" :text="'当前没有相关数据哟~'"></no-data>
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="pager-loader" v-if="pagerloading">
        </div>
        <div class="copyright-container">
            <div class="info">
                Copyright&nbsp&copy;&nbsp;2018&nbsp;,宜兴方寸堂版权所有
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        config.isindex = true;
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.productsRank = {!! json_encode($levels, JSON_UNESCAPED_UNICODE) !!};
        config.products = {!! json_encode($products, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/main.js') }}"></script>

    {!! wechat_share($share) !!}
    {{--<script>
        var _mtac = {};
        (function() {
            var mta = document.createElement("script");
            mta.src = "https://pingjs.qq.com/h5/stats.js?v2.0.2";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500500357");
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        })();
    </script>--}}
@endsection