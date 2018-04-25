@extends("layout")
@section('content')
    <div class="auctionorderdetail-container" id="order" v-cloak>
        <head-top></head-top>
        <section class="info">
            <div class="text">
              <span v-if="order_detail.status == 0">
                <img src="{{fct_cdn('/img/mobile/fork_w.png')}}">待付款
              </span>
                <span v-if="order_detail.status !== 0 && order_detail.status !== 4">
                <img src="{{fct_cdn('/img/mobile/check_w.png')}}">付款成功
                <span class="status">@{{ order_detail.statusName }}</span>
              </span>
                <span v-if="order_detail.status == 4">
                <img src="{{fct_cdn('/img/mobile/fork_w.png')}}">订单关闭
              </span>
            </div>
        </section>
        <section class="detail">
            <div class="express" v-if="order_detail.orderReceiver.expressNO">
                <a :href="'{{ url('express', [], env('APP_SECURE')) }}?name=' + order_detail.orderReceiver.expressPlatform + '&number=' + order_detail.orderReceiver.expressNO" class="link">
                    <span class="img-container item">
                        <img src="{{ fct_cdn('/img/mobile/order_transport.png') }}">
                    </span>
                    <span class="item t">@{{ order_detail.orderReceiver.expressPlatform }}(@{{ order_detail.orderReceiver.expressNO }})<br><span class="time">@{{ order_detail.orderReceiver.deliveryTime }}</span></span>
                    <span class="wei-arrow-right"></span>
                </a>
            </div>
            <div class="addr">
                <div class="img-container">
                    <img src="{{fct_cdn('/img/mobile/order_addr.png')}}">
                </div>
                <div class="addr-info">
                    <div class="item">收货人：@{{ order_detail.orderReceiver.name }}</div>
                    <div class="item right">@{{ order_detail.orderReceiver.phone }}</div>
                </div>
                <div class="address">收货地址：@{{ order_detail.orderReceiver.province + "&nbsp;" + order_detail.orderReceiver.city + "&nbsp;" +  order_detail.orderReceiver.region + "&nbsp;" + order_detail.orderReceiver.address }}</div>
            </div>
        </section>
        <section class="">
            <div class="product">
                <div class="pro-item img-container">
                    <img :src="order_detail.goodsImg">
                </div>
                <div class="pro-item title-container">
                    <div class="title">@{{ order_detail.goodsName }}</div>
                    <div class="spec">保证金：@{{ order_detail.deposit }}</div>
                </div>
                <div class="pro-item price-container">
                    <div class="price"><small class="pri-mark">￥</small>@{{ order_detail.price }}</div>
                </div>
            </div>
        </section>
        <section class="total">
            <div class="inner">
                共<span class="pri-color">@{{ order_detail.buyTotalCount }}</span>件商品&nbsp;
                合计:<span class="pri-color"><small class="pri-mark">￥</small>@{{ order_detail.payAmount }}</span>（含运费）
            </div>
        </section>
        <section class="order-detail">
            <div class="inner">
                <span v-if="order_detail.orderId">订单编号：@{{ order_detail.orderId }}<br></span>
                <span v-if="order_detail.payOrderId">支付单号：@{{ order_detail.payOrderId }}<br></span>
                <span v-if="order_detail.payPlatform">支付方式：@{{ order_detail.payPlatform }}<br></span>
                <span v-if="order_detail.createTime">创建时间：@{{ order_detail.createTime }}<br></span>
                <span v-if="order_detail.payTime">付款时间：@{{ order_detail.payTime }}<br></span>
                <span v-if="order_detail.expiresTime">发货时间：@{{ order_detail.expiresTime }}<br></span>
                <span v-if="order_detail.finishTime">完成时间：@{{ order_detail.finishTime }}</span>
            </div>
        </section>
        <footer class="footer">
            <div class="inner">
                <a href="{!! api_chat_url(url('my/auction/order/'.$entity->orderId, [], env('APP_SECURE')), '拍卖订单：'.$entity->orderId) !!}"
                   class="chat"><img src="{{fct_cdn('/img/mobile/order_chat.png')}}"><span class="text">在线客服</span></a>
                <div class="comment">
                    <a :href="'{{sprintf('%s?tradetype=auction_order&tradeid=', env('PAY_URL'))}}' + order_detail.orderId"
                       v-if="order_detail.status === 0">我要付款</a>
                    <a href="javascript:;" @click="confirm(order_detail.orderId, finish)" v-if="order_detail.status === 2">确认收货</a>
                </div>
            </div>
        </footer>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <confirm v-if="showConfirm" :showHide="showConfirm" @ok="ok" @no="no" :callback="callback" :obj="orderId" :msg="msg"></confirm>
    </div>
@endsection
@section('javascript')
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.finish_url = "{{url('my/auction/order', [], env('APP_SECURE'))}}";
        config.order_detail = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/head.js') }}"></script>
    <script src="{{fct_cdn('/js/mobile/auction_orderdetail.js')}}"></script>
@endsection