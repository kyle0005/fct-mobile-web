@extends("layout")
@section('content')
    <div class="encyclopedias-container" id="encyclopediasdetail" v-cloak>
        <head-top></head-top>
        <section class="encyclopedias-content">
            <div class="top-container">
                <div class="inner">
                    <ul class="top-list" name="top">
                        <li v-for="(item, index) in encyclopedias_list" :name="'list' + index" :class="{red:index===encynum}">
                            <a href="javascript:;" @click="loadsingle(index, item.id)">
                              <span class="img-container">
                                <img :src="item.image">
                              </span>
                                <span class="name-container overText">@{{ item.name }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <section class="content top-min">
                <div class="intro">
                    <span class="photo">
                      <img :src="detail.image">
                    </span>
                    <span class="intro-info">
                      <span class="intro-name">@{{ detail.name }}</span>
                      <span class="intro-content">@{{ detail.intro }}</span>
                    </span>
                </div>
            </section>
            <section class="text-container" v-html="detail.description"></section>
            <section class="comment" v-if="detail.productList && detail.productList.length > 0">
                <div class="lines">
                    <div class="text">相关宝贝</div>
                </div>
                <ul class="others" v-if="detail.productList && detail.productList.length > 0">
                    <li v-for="p in detail.productList">
                        <a :href="'{{ url('products') }}/' + p.id" class="item">
                            <img v-view="p.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                            <span class="p-title">@{{ p.name }}</span>
                        </a>
                    </li>
                </ul>
            </section>
            <no-data v-if="nodata"></no-data>
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        </section>
    </div>
@endsection
@section('javascript')
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.encyclopedias_list = {!! json_encode($entities, JSON_UNESCAPED_UNICODE) !!};
        config.detail = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
        config.ency_url = "{{ url('wiki/item') }}?from_type={{ $fromType }}&from_id=";
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