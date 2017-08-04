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
                            <img :src="i.img">
                        </div>
                        <div class="pro-item title-container">
                            <div class="title">@{{ i.name }}</div>
                            <div class="spec">规格:@{{ i.specName }}</div>
                        </div>
                        <div class="pro-item price-container">
                            <div class="price"><small class="pri-mark">￥</small>@{{ i.commission }}</div>
                            <div class="num">&times; @{{ i.buyCount }}</div>
                        </div>
                    </li>
                </ul>
                <div class="total">
                    <div class="inner">共<span class="pri">@{{ item.totalCount }}</span>件商品&nbsp;合计佣金：<span class="pri"><small class="pri-mark">￥</small>@{{ item.commission }}</span></div>
                </div>
            </div>
        </div>

        <ul class="prolist" v-else>
            <li class="noData">
                <img src="{{ fct_cdn('/images/no_data.png') }}">
                <span class="no">当前没有相关数据哟~</span>
            </li>
        </ul>
        <p v-if="pager.next == 0" class="empty_data">没有更多了</p>
        <footer class="loader_more" v-show="preventRepeatReuqest">正在加载更多...</footer>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
            </section>
        </div>
    </template>
@endsection
@section('javascript')
    <script>
        config.commissionUrl = "{{ url('my/account/settlement') }}";
        config.status = {{ $status }};
        config.commissionlist = {!! json_encode($settlements, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/common/tools.js') }}"></script>
    <script src="{{ fct_cdn('/js/commission.js') }}"></script>
@endsection