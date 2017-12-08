@extends("layout")
@section('content')
    <div class="auctionorderlist-container" id="orderlist" v-cloak>
        <div class="tabs">
            <div class="item" v-for="(item, index) in tabs" :class="{chosen: (index - 1)===tab_num}" @click="category(index - 1)">
                <a href="javascript:;" class="link">@{{ item }}</a>
            </div>
            <div class="search-container" :class="{show:show_search}">
                <div class="cancel-search">
                    <a href="javascript:;" class="fork">
                        <subpost :txt="subText" ref="subpost" @callback="search(0)" @succhandle="succhandle"></subpost>
                    </a>
                </div>
                <input type="search" class="search-input" :placeholder="placeholder" v-model="keywords">
                <a href="javascript:;" class="search-link" @click="search(1)">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </div>
        <div class="orders-list" v-load-more="nextPage" type="1" v-if="orderlist && orderlist.length > 0">
            <div class="items" v-for="(item, index) in orderlist">
                <div class="info">
                    <div class="left">订单号：@{{ item.orderId }}</div>
                    <div class="right">@{{ item.statusName }}</div>
                </div>
                <ul class="list">
                    <li class="product" @click="todetail(item)">
                        <div class="pro-item img-container">
                            <img :src="item.goodsImg">
                        </div>
                        <div class="pro-item title-container">
                            <div class="title">@{{ item.goodsName }}</div>
                            <div class="spec">保证金：@{{ item.deposit }}</div>
                        </div>
                        <div class="pro-item price-container">
                            <div class="price"><small class="pri-mark">￥</small>@{{ item.bidPrice }}</div>
                        </div>
                    </li>
                </ul>
                <div class="btn clearfix">
                    <div class="price">应付：<small class="pri-mark">￥</small>@{{ item.payAmount }}</div>
                    <div class="btn-container">
                        <a :href="'{{sprintf('%s?tradetype=auction_order&tradeid=', env('PAY_URL'))}}' + item.orderId"
                           class="black" v-if="item.status == 0">我要付款</a>
                    </div>
                </div>
            </div>
        </div>
        <no-data v-if="nodata"></no-data>
        <img src="{{fct_cdn('/img/mobile/img_loader_s.gif')}}" class="list-loader" v-if="listloading">
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <confirm v-if="showConfirm" :showHide="showConfirm" @ok="ok" @no="no" :callback="callback" :obj="orderId" :msg="msg"></confirm>
    </div>
@endsection
@section('javascript')
    <script>
        config.status = {{$status}};
        config.orderlist_url = "{{url('my/auction/order', [], env('APP_SECURE'))}}";
        config.search_url = "{{url('my/auction/order', [], env('APP_SECURE'))}}";
        config.detail_url = "{{url('my/auction/order', [], env('APP_SECURE'))}}";
        config.orderlist = {!! json_encode($orders, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{fct_cdn('/js/mobile/auction_orderlist.js')}}"></script>
@endsection