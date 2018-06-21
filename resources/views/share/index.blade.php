@extends("layout")
@section('content')
    <div class="share-container" id="share" v-cloak>
        <section class="top">
            <div class="inner">
                <div class="item sort">
                    <a href="javascript:;" class="link" @click="toggle(0)">
                        <span class="txt">综合</span>
                        <img src="{{ fct_cdn('/img/mobile/arr_down.png')}}" class="arr">
                    </a>
                </div>
                <div class="item category">
                    <a href="javascript:;" class="link" @click="toggle(1)">
                        <span class="txt">作者</span>
                        <img src="{{ fct_cdn('/img/mobile/arr_down.png')}}" class="arr">
                    </a>
                </div>
                <div class="item search">
                    <a href="javascript:;" class="search-link" @click="subSearch">
                        <i class="fa fa-search"></i>
                    </a>
                    <input type="search" class="search-input" placeholder="宝贝名称" v-model="search">
                    <a href="javascript:;" class="fork-link" v-if="search" @click="clear">
                        <i class="fa fa-times-circle"></i>
                    </a>
                </div>
                <div class="sorts-pop">
                    <div class="aside" :class="{open:open,docked:docked}" @click="toggle(-1)">
                        <div class="container">
                            <div class="head-sorts" v-if="showPop==0" @click.stop="">
                                <ul class="types">
                                    <li class="types-item" v-for="(types, index) in sorts" :class="{chosen:index===sort_tab}"
                                        @click="sortsV(types, index)">
                                        @{{ types.name }}
                                    </li>
                                </ul>
                            </div>
                            <div class="head-artists" v-if="showPop==1" @click.stop="">
                                <ul class="types">
                                    <li class="types-item" v-for="(types, index) in artists" :class="{chosen:index===art_tab}"
                                        @click="artistsV(types, index)">
                                        @{{ types.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="cover" @click="toggle(-1)"></div>
                    </div>
                </div>
            </div>
        </section>
        <ul class="list">
            <li>
                <div class="link">
                    <a href="{{ url('/', [], env('APP_SECURE')) .'?' . env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}"
                       class="left"><img src="{{ fct_cdn('/img/mobile/logo2.png') }}"></a>
                    <div class="center">
                        <a href="{{ url('/', [], env('APP_SECURE')) .'?' . env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}"
                           class="title">方寸堂 - 不止不同</a>
                        <span class="t2 overTextH2">汇聚东方美学匠心之作的紫砂交流电商平台。</span>
                    </div>
                </div>
                <a href="/my/share/0" class="right"><img src="{{ fct_cdn('/img/mobile/qr_code.png') }}"></a>
            </li>
        </ul>
        <ul class="list" v-load-more="nextPage" type="1" v-if="shareList && shareList.length > 0">
            <li v-for="(item, index) in shareList">
                <div class="link">
                    <a :href="'/products/' + item.id + '{{ '?' . env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}'"
                       class="left item"><img v-view="item.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}"></a>
                    <div class="center item">
                        <a :href="'/products/' + item.id + '{{ '?' . env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}'" class="title">@{{ item.artistName }}《@{{ item.name }}》</a>
                        <span class="t1" v-if="item.price.length > 1">价格：<small class="pri-mark">￥</small>@{{ item.price[0] }}&sim;<small class="pri-mark">￥</small>@{{ item.price[1] }}</span>
                        <span class="t1" v-else>价格：<small class="pri-mark">￥</small>@{{ item.price[0] }}</span>
                        <span class="t2" v-if="item.commission.length > 1">佣金：<strong class="pri"><small class="pri-mark">￥</small>@{{ item.commission[0] }}&sim;<small class="pri-mark">￥</small>@{{ item.commission[1] }}</strong></span>
                        <span class="t2" v-else>佣金：<strong class="pri"><small class="pri-mark">￥</small>@{{ item.commission[0] }}</strong></span>
                    </div>
                </div>
                <a :href="'/my/share/' + item.id" class="right"><img src="{{ fct_cdn('/img/mobile/qr_code.png') }}"></a>
            </li>
        </ul>

        <no-data v-if="nodata" imgurl="{{ fct_cdn('/img/mobile/no_data.png') }}" :text="'当前没有相关数据哟~'"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <div class="pager-loading-txt" v-if="pagerloading">加载中...</div>
        <div class="pager-loaded" v-if="isLastPage">
            <div class="title">
                <div class="lines">
                    <div class="text">我是有底线的</div>
                </div>
            </div>
        </div>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>

        <footer class="footer">
            <div class="inner">
                <a href="{{ url('my/share/orders', [], env('APP_SECURE')) }}" class="link">
                    <img src="{{ fct_cdn('/img/mobile/share_point.png') }}"><br>销售订单
                </a>
                <a href="{{ url('my/share/auction/orders', [], env('APP_SECURE')) }}#/list?id=16" class="link">
                    <img src="{{ fct_cdn('/img/mobile/s_pm_order.png') }}"><br>拍卖订单
                </a>
                <a href="{{ url('my/account/settlement', [], env('APP_SECURE')) }}" class="link">
                    <img src="{{ fct_cdn('/img/mobile/share_detail.png') }}"><br>结算明细
                </a>
            </div>

        </footer>
    </div>
@endsection
@section('javascript')
    <script>
        config.shareUrl = "{{ url('my/share', [], env('APP_SECURE')) }}";
        config.shareParam = "{{ env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}";
        config.sorts = {!! json_encode($sorts, JSON_UNESCAPED_UNICODE) !!};
        config.artists = {!! json_encode($artists, JSON_UNESCAPED_UNICODE) !!};
        config.share = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/share.js') }}"></script>
@endsection