@extends("layout")
@section('content')
    <div class="share-container" id="share" v-cloak>
        <section class="top">
            <div class="inner">
                <div class="item sort">
                    <select class="sel" v-model="sortsel" @change="sel">
                        <option v-for="(item, index) in sort" :value="index">@{{ item }}</option>
                    </select>
                </div>
                <div class="item category">
                    <select class="sel" v-model="categary" @change="cate">
                        <option v-for="(item, index) in productsType" :value="item.code">@{{ item.name }}</option>
                    </select>
                </div>
                <div class="item search">
                    <a href="javascript:;" class="search-link" @click="subSearch">
                        <i class="fa fa-search"></i>
                    </a>
                    <input type="search" class="search-input" placeholder="宝贝名称" v-model="search">
                    <a href="javascript:;" class="fork-link" @click="clear">
                        <i class="fa fa-times-circle"></i>
                    </a>
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
                           class="title">方寸堂 - 只为不同</a>
                        <span class="t2 overTextH2">汇聚东方美学匠心之作的紫砂交流电商平台。</span>
                    </div>
                </div>
                <a href="javascript:;" class="right" @click="popqrcode(true)"><img src="{{ fct_cdn('/img/mobile/share.png') }}"></a>
            </li>
        </ul>
        <ul class="list" v-load-more="nextPage" type="1" v-if="shareList && shareList.length > 0">
            <li v-for="(item, index) in shareList">
                <div class="link">
                    <a :href="'/products/' + item.id + '{{ '?' . env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}'"
                       class="left item"><img v-view="item.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}"></a>
                    <div class="center item">
                        <a :href="'/products/' + item.id + '{{ '?' . env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}'" class="title">@{{ item.name }}</a>
                        <span class="t1" v-if="item.price.length > 1">价格：<small class="pri-mark">￥</small>@{{ item.price[0] }}&sim;<small class="pri-mark">￥</small>@{{ item.price[1] }}</span>
                        <span class="t1" v-else>价格：<small class="pri-mark">￥</small>@{{ item.price }}</span>
                        <span class="t2" v-if="item.commission.length > 1">佣金：<strong class="pri"><small class="pri-mark">￥</small>@{{ item.commission[0] }}&sim;<small class="pri-mark">￥</small>@{{ item.commission[1] }}</strong></span>
                        <span class="t2" v-else>佣金：<strong class="pri"><small class="pri-mark">￥</small>@{{ item.commission }}</strong></span>
                    </div>
                </div>
                <a href="javascript:;" class="right" @click="popqrcode(false, item)"><img src="{{ fct_cdn('/img/mobile/share.png') }}"></a>
            </li>
        </ul>

        <no-data v-if="nodata"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="pager-loader" v-if="pagerloading">
        <div class="qrcode-container" :class="{show:show}">
            <div class="inner">
                <img :src="qrurl" class="qrcode">
                <div class="qrtitle">@{{ qrname }}</div>
                <a href="javascript:;" class="fork" @click="popqrcode()"><img src="{{ fct_cdn('/img/mobile/share_fork2.png') }}"></a>
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
        config.shareTopUrl = "https://pan.baidu.com/share/qrcode?w=300&h=300&url={{ env('APP_URL') }}";
        config.shareProUrl = "https://pan.baidu.com/share/qrcode?w=300&h=300&url={{env('APP_URL')}}/products";
        config.sort = ['综合排序', '人气最高', '利润最高'];
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.share = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/share.js') }}"></script>
@endsection