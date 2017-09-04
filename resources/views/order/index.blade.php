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
                    <li class="product" v-for="(good, index) in item.orderGoods" @click="todetail(item)">
                        <div class="pro-item img-container">
                            <img v-view="good.img" src="{{ fct_cdn('/images/img_loader.gif') }}">
                        </div>
                        <div class="pro-item title-container">
                            <div class="title">@{{ good.name }}</div>
                            <div class="spec" v-if="good.specName && good.specName != null">规格:@{{ good.specName }}</div>
                        </div>
                        <div class="pro-item price-container">
                            <div class="price"><small class="pri-mark">￥</small>@{{ good.price }}</div>
                            <div class="num">&times; @{{ good.buyCount }}</div>
                        </div>
                    </li>
                </ul>
                <div class="total">
                    <div class="inner">共@{{ item.buyTotalCount }}件宝贝&nbsp;合计:<small class="pri-mark">￥</small><span class="payAmount">@{{ toFloat(item.payAmount) }}</span>（含运费）</div>
                </div>
                <div class="btn clearfix" v-if="item.status == 0">
                    <div class="btn-container">
                        <a :href="'{{  sprintf('%s?tradetype=buy&tradeid=', env('PAY_URL')) }}' + item.orderId" class="black">我要付款</a>
                    </div>
                    <div class="btn-container">
                        <a href="javascript:;" class="grey" @click="confirm(item.orderId, cancel)">关闭订单</a>
                    </div>
                </div>

                <div class="btn clearfix" v-if="item.status == 3 && item.commentStatus == 0">
                    <div class="btn-container">
                        <a :href="'{{ url('my/orders') }}/' + item.orderId + '/comments/create'" class="black">评价</a>
                    </div>
                </div>
            </div>
        </div>

        <no-data v-if="nodata"></no-data>
        <img src="{{ fct_cdn('/images/img_loader_s.gif') }}" class="list-loader" v-if="listloading">

        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <confirm v-if="showConfirm" :showHide="showConfirm" @ok="ok" @no="no" :callback="callback" :obj="orderId" :msg="msg"></confirm>
    </div>
@endsection
@section('javascript')
    <script>
        config.status = {{ $status }};
        config.orderlist = {!! json_encode($orderlist, JSON_UNESCAPED_UNICODE) !!};
        config.orderlist_url = "{{ url('my/orders') }}"; // /my/orders
        config.search_url = "{{ url('my/orders') }}"; // /my/orders
        config.detail_url = "{{ url('my/orders') }}"; // /my/orders/12345678912345678
        config.cancel_url = "{{ url('my/orders') }}"; // /my/orders/12345678912345678/cancel
    </script>
    <script src="{{ fct_cdn('/js/orderlist.js') }}"></script>

@endsection