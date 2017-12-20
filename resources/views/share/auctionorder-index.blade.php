@extends("layout")
@section('content')
    <div class="orderlist-container" id="orderlist" v-cloak>
        <div class="tabs">
            <div class="item" v-for="(item, index) in tabs" :class="{chosen: (index - 1)===tab_num}" @click="category(index - 1)">
                <a href="javascript:;" class="link">@{{ item }}</a>
            </div>
            <div class="search-container" :class="{show:show_search}">
                <div class="cancel-search">
                    <a href="javascript:;" class="fork" @click="search(0)">取消</a>
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
                    <li class="product">
                        <div class="pro-item img-container">
                            <img v-view="item.goodsImg" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                        </div>
                        <div class="pro-item title-container">
                            <div class="title">@{{ item.goodsName }}</div>
                        </div>
                        <div class="pro-item price-container">
                            <div class="price"><small class="pri-mark">￥</small>@{{ item.bidPrice }}</div>
                            <div class="num"></div>
                        </div>
                    </li>
                </ul>
                <div class="total">
                    <div class="inner">合计佣金:<span class="payAmount pri"><small class="pri-mark">￥</small>@{{ item.commission }}</span></div>
                </div>
            </div>
        </div>

        <no-data v-if="nodata" imgurl="{{ fct_cdn('/img/mobile/no_data.png') }}" :text="'当前没有相关数据哟~'"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="pager-loader" v-if="pagerloading">
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <confirm v-if="showConfirm" :showHide="showConfirm" @ok="ok" @no="no" :callback="callback" :obj="orderId" :msg="msg"></confirm>
    </div>
@endsection
@section('javascript')
    <script>
        config.status = {{ $status }};
        config.orderlist = {!! json_encode($orderlist, JSON_UNESCAPED_UNICODE) !!};
        config.orderlist_url = "{{ url('my/share/auction/orders', [], env('APP_SECURE')) }}"; // /my/share/orders
        config.search_url = "{{ url('my/share/auction/orders', [], env('APP_SECURE')) }}"; // /my/share/orders
        config.detail_url = "{{ url('my/share/auction/orders', [], env('APP_SECURE')) }}"; // /my/share/orders/12345678912345678
    </script>
    <script src="{{ fct_cdn('/js/mobile/orderlist_m.js') }}"></script>

@endsection