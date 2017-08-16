@extends("layout")


@section('content')
    <div class="encyclopedias-container" id="encyclopedias" v-cloak>
        <head-top></head-top>
        <section class="nav-bar">
            <ul>
                <li class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="linkTo(index)">
                    <a href="javascript:;">
                        @{{ item }}
                    </a>
                </li>
            </ul>
            <div class="search-container" :class="{show:show_search}">
                <div class="cancel-search">
                    <a href="javascript:;" class="fork" @click="search(0)">取消</a>
                </div>
                <input type="search" class="search-input">
                <a href="javascript:;" class="search-link" @click="search(0)">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </section>
        <section class="list">
            <div class="tab-list">
                <m-swipe swipeid="swipe" ref="swiper" :autoplay="0" effect="slide">
                    <div v-for="(item, index) in list" class="swiper-slide inner-container" :key="index" slot="swiper-con">
                        <div class="items" v-for="(i_item, i_index) in item" :key="i_index">
                            <a :href="'{{ url('wiki/item') }}?from_type=category&from_id=' + i_item.id" class="link">
                                <img v-view="i_item.image" src="{{ fct_cdn('/images/img_loader.gif') }}">
                                <span>@{{ i_item.name }}</span>
                            </a>
                        </div>
                    </div>
                </m-swipe>
            </div>
        </section>
        <section class="nav-bar">
            <ul>
                <li class="item chosen">
                    <a href="javascript:;">泥料</a>
                </li>
            </ul>
            <div class="search-container" :class="{show:show_search_d}">
                <div class="cancel-search">
                    <a href="javascript:;" class="fork" @click="search(1)">取消</a>
                </div>
                <input type="search" class="search-input">
                <a href="javascript:;" class="search-link" @click="search(1)">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </section>

        <section class="list">
            <div class="tab-list down">
                <m-swipe swipeid="swipet" ref="swipert" :autoplay="0" effect="slide">
                    <div v-for="(item, index) in list_t" class="swiper-slide inner-container" :key="index" slot="swiper-con">
                        <div class="items" v-for="(i_item, i_index) in item" :key="i_index">
                            <a :href="'{{ url('wiki/item') }}?from_type=material&from_id=' + i_item.id"
                               class="link overText">@{{ i_item.name }}</a>
                        </div>
                    </div>
                </m-swipe>
            </div>
        </section>
        <div class="copyright-container">
            <div class="info">
                Copyright&nbsp;&copy;&nbsp;2017&nbsp;,fangcuntang&nbsp;Co.,Ltd.All&nbsp;Rights&nbsp;Reserved.<br>
                宜兴方寸堂文化传媒有限公司&ensp;|&ensp;<a href="" class="law">法律声明</a><br>
                <span class="bottom">沪ICP备12022967号-1&nbsp;沪公网安备11010502025474</span>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.wikiCategories = {!! json_encode($wikiCategories, JSON_UNESCAPED_UNICODE) !!};
        config.materials = {!! json_encode($materials, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/swiper.js') }}"></script>
    <script type="text/x-template" id="m_swipe">
        <div class="swiper-container tab-container" :class="swipeid">
            <div class="swiper-wrapper">
                <slot name="swiper-con"></slot>
            </div>
            <!-- 分页器 -->
            <div :class="{'swiper-pagination':pagination}"></div>
        </div>
    </script>
    <template id="info">
        <div class="alet_container">
            <section class="ency-container">
                <img v-view="msg.img" class="photo" src="{{ fct_cdn('/images/img_loader.gif') }}">
                <p class="title">@{{ msg.name }}</p>
                <p class="text">@{{ msg.text }}</p>
                <a href="javascript:;" class="close" @click="close()"></a>
            </section>
        </div>
    </template>
    <script src="{{ fct_cdn('/js/encyclopedias.js') }}"></script>
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