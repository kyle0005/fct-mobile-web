@extends("layout")

@section('content')
    <div class="order-container" id="order" v-cloak>
        <section class="info">
            <div class="text">
      <span v-if="order_detail.status == 0">
        <img src="{{ fct_cdn('/images/fork_w.png') }}">待付款
      </span>
                <span v-if="order_detail.status !== 0 && order_detail.status !== 4">
        <img src="{{ fct_cdn('/images/check_w.png') }}">付款成功
        <span class="status">@{{ order_detail.statusName }}</span>
      </span>
                <span v-if="order_detail.status == 4">
        <img src="{{ fct_cdn('/images/fork_w.png') }}">订单关闭
      </span>
            </div>
        </section>
        <section class="detail">
            <div class="express" v-if="order_detail.orderReceiver.expressNO">
                <a href="javascript:;" class="link">
        <span class="img-container item">
            <img src="{{ fct_cdn('/images/order_transport.png') }}">
          </span>
                    <span class="item t">@{{ order_detail.orderReceiver.expressPlatform }}(@{{ order_detail.orderReceiver.expressNO }})<br><span class="time">@{{ order_detail.orderReceiver.deliveryTime }}</span></span>
                    <span class="wei-arrow-right"></span>
                </a>
            </div>
            <div class="addr">
                <div class="img-container">
                    <img src="{{ fct_cdn('/images/order_addr.png') }}">
                </div>
                <div class="addr-info">
                    <div class="item">收货人：@{{ order_detail.orderReceiver.name }}</div>
                    <div class="item right">@{{ order_detail.orderReceiver.phone }}</div>
                </div>
                <div class="address">收货地址：@{{ order_detail.orderReceiver.province + "&nbsp;" + order_detail.orderReceiver.city + "&nbsp;" +  order_detail.orderReceiver.region + "&nbsp;" + order_detail.orderReceiver.address }}</div>
            </div>
            <div class="express invoice" v-if="order_detail.status == 3">
                <a href="javascript:;" class="link">
                    <span class="img-container item">
                        <img src="{{ fct_cdn('/images/order_invoice.png') }}">
                      </span>
                    <span class="item t">申请发票</span>
                    <span class="wei-arrow-right"></span>
                </a>
            </div>
        </section>
        <section class="">
            <div class="product" v-for="(item, index) in order_detail.orderGoods">
                <div class="pro-item img-container">
                    <img :src="item.img">
                </div>
                <div class="pro-item title-container">
                    <div class="title">@{{ item.name }}</div>
                    <div class="spec">规格:@{{ item.specName }}</div>
                </div>
                <div class="pro-item price-container">
                    <div class="price"><small class="pri-mark">￥</small>@{{ item.price }}</div>
                    <div class="num">&times; @{{ item.buyCount }}</div>
                    <a :href="'{{ url('my/refunds/create') }}?og_id=' + item.id"
                       class="after-sale" v-if="item.status == -1">申请售后</a>
                    <a href="javascript:;" class="after-sale" v-if="item.statusName">@{{ item.statusName }}</a>      <!-- href的url带参数status -->
                </div>
            </div>
        </section>
        <section class="total">
            <div class="inner">共<span class="pri-color">@{{ order_detail.buyTotalCount }}</span>件商品&nbsp;合计：<span class="pri-color"><small class="pri-mark">￥</small>@{{ order_detail.payAmount }}</span>（含运费）</div>
        </section>
        <section class="order-detail">
            <span v-if="order_detail.orderId">订单编号：@{{ order_detail.orderId }}<br></span>
            <span v-if="order_detail.payOrderId">支付单号：@{{ order_detail.payOrderId }}<br></span>
            <span v-if="order_detail.payName">支付方式：@{{ order_detail.payName }}（@{{ order_detail.status == 0 || order_detail.status == 4 ? '未付款' : '已付款' }}）<br></span>
            <span v-if="order_detail.createTime">创建时间：@{{ order_detail.createTime }}<br></span>
            <span v-if="order_detail.payTime">付款时间：@{{ order_detail.payTime }}<br></span>
            <span v-if="order_detail.expiresTime">发货时间：@{{ order_detail.expiresTime }}<br></span>
            <span v-if="order_detail.finishTime">完成时间：@{{ order_detail.finishTime }}</span>
        </section>
        <footer class="footer">
            <div class="inner">
                <a href="https://static.meiqia.com/dist/standalone.html?_=t&eid=62925&clientid={{ $member->memberId }}&metadata=订单帮助" class="chat"><img src="{{ fct_cdn('/images/order_chat.png') }}"></a>
{{--                <div class="del">
                    <a href="javascript:;">删除订单</a>
                </div>--}}
                <div class="comment" v-if="order_detail.status == 0">
                    <a :href="'{{  sprintf('%s?tradetype=buy&tradeid=', env('PAY_URL')) }}' + order_detail.orderId">我要付款</a>
                </div>
                <div class="comment" v-if="order_detail.status == 3">
                    <a :href="'{{ url('my/orders') }}/' + order_detail.orderId + '/comments/create'">我要评价</a>
                </div>
            </div>
        </footer>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
                <!--<div class="confrim" @click="close">确认</div>-->
            </section>
        </div>
    </template>
@endsection
@section('javascript')
    <script>
        config.order_detail = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/order.js') }}"></script>
@endsection