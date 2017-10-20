@extends("layout")
@section('content')
    <div class="order-container" id="order" v-cloak>
        <section class="info">
            <div class="text">
              <span v-if="order_detail.status == 0">
                <img src="{{ fct_cdn('/img/mobile/fork_w.png') }}">待付款
              </span>
                        <span v-if="order_detail.status !== 0 && order_detail.status !== 4">
                <img src="{{ fct_cdn('/img/mobile/check_w.png') }}">付款成功
                <span class="status">@{{ order_detail.statusName }}</span>
              </span>
              <span v-if="order_detail.status == 4">
                <img src="{{ fct_cdn('/img/mobile/fork_w.png') }}">订单关闭
              </span>
            </div>
        </section>
        <section class="detail">
            <div class="express" v-if="order_detail.orderReceiver.expressNO">
                <a href="javascript:;" class="link">
                    <span class="img-container item">
                        <img src="{{ fct_cdn('/img/mobile/order_transport.png') }}">
                    </span>
                    <span class="item t">@{{ order_detail.orderReceiver.expressPlatform }}(@{{ order_detail.orderReceiver.expressNO }})<br><span class="time">@{{ order_detail.orderReceiver.deliveryTime }}</span></span>
                    <span class="wei-arrow-right"></span>
                </a>
            </div>
            <div class="addr">
                <div class="img-container">
                    <img src="{{ fct_cdn('/img/mobile/order_addr.png') }}">
                </div>
                <div class="addr-info">
                    <div class="item">收货人：@{{ order_detail.orderReceiver.name }}</div>
                    <div class="item right">@{{ order_detail.orderReceiver.phone }}</div>
                </div>
                <div class="address">收货地址：@{{ order_detail.orderReceiver.province + "&nbsp;" + order_detail.orderReceiver.city + "&nbsp;" +  order_detail.orderReceiver.region + "&nbsp;" + order_detail.orderReceiver.address }}</div>
            </div>
        </section>
        <section class="">
            <div class="product" v-for="(item, index) in order_detail.orderGoods">
                <div class="pro-item img-container">
                    <a :href="'{{ url('products') }}/' + item.goodsId"><img v-view="item.img" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}"></a>
                </div>
                <div class="pro-item title-container">
                    <div class="title">@{{ item.name }}</div>
                    <div class="spec" v-if="item.specName && item.specName != null">规格:@{{ item.specName }}</div>
                </div>
                <div class="pro-item price-container">
                    <div class="price"><small class="pri-mark">￥</small>@{{ item.price }}</div>
                    <div class="num">&times; @{{ item.buyCount }}</div>
                </div>
            </div>
        </section>
        <section class="total">
            <div class="inner">
                共<span class="pri-color">@{{ order_detail.buyTotalCount }}</span>件宝贝&nbsp;
                佣金:<span class="pri-color"><small class="pri-mark">￥</small>{{(order_detail.commission).toFixed(2)}}</span>&nbsp;
                    合计:<span class="pri-color"><small class="pri-mark">￥</small>@{{ (order_detail.payAmount).toFixed(2) }}</span>（含运费）
            </div>
        </section>
        <section class="order-detail">
            <div class="inner">
                <span v-if="order_detail.orderId">订单编号：@{{ order_detail.orderId }}<br></span>
                <span v-if="order_detail.payName">支付方式：@{{ order_detail.payName }}（@{{ order_detail.status == 0 || order_detail.status == 4 ? '未付款' : '已付款' }}）<br></span>
                <span v-if="order_detail.createTime">创建时间：@{{ order_detail.createTime }}<br></span>
                <span v-if="order_detail.finishTime">完成时间：@{{ order_detail.finishTime }}</span>
            </div>
        </section>

        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <confirm v-if="showConfirm" :showHide="showConfirm" @ok="ok" @no="no" :callback="callback" :obj="orderId" :msg="msg"></confirm>
    </div>
@endsection
@section('javascript')
    <script>
        config.order_detail = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/order.js') }}"></script>
@endsection