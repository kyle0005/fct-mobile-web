@extends("layout")

@section('content')
    <div class="commission-container" id="commission" v-cloak>
        <div class="tabs">
            <div class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="category(index)">
                <a href="javascript:;" class="link">@{{ item }}</a>
            </div>
        </div>
        <div class="orders-list" v-load-more="nextPage" type="1" v-if="commissionlist && commissionlist.length > 0">
            <div class="items" v-for="(item, index) in commissionlist">
                <div class="info">
                    <div class="left">订单号：@{{ item.tradeId }}</div>
                    <div class="right">@{{ item.createTime }}</div>
                </div>
                <ul class="list">
                    <li class="product" v-for="(i, index) in item.orderGoods">
                        <div class="pro-item img-container">
                            <img v-view="i.img" src="{{ fct_cdn('/images/img_loader.gif') }}">
                        </div>
                        <div class="pro-item title-container">
                            <div class="title">@{{ i.name }}</div>
                            <div class="spec" v-if="i.specName && i.specName != null">规格:@{{ i.specName }}</div>
                        </div>
                        <div class="pro-item price-container">
                            <div class="price"><small class="pri-mark">￥</small>@{{ i.commission }}</div>
                            <div class="num">&times; @{{ i.buyCount }}</div>
                        </div>
                    </li>
                </ul>
                <div class="total">
                    <div class="inner">共<span class="pri">@{{ item.totalCount }}</span>件宝贝&nbsp;合计佣金：<span class="pri"><small class="pri-mark">￥</small>@{{ item.commission }}</span></div>
                </div>
            </div>
        </div>

        <div class="noData" v-else>
            <div class="inner">
                <img src="{{ fct_cdn('/images/no_data.png') }}">
                <span class="no">当前没有相关数据哟~</span>
            </div>
        </div>

        <img src="{{ fct_cdn('/images/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.commissionUrl = "{{ url('my/account/settlement') }}";
        config.status = {{ $status }};
        config.commissionlist = {!! json_encode($settlements, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/commission.js') }}"></script>
@endsection