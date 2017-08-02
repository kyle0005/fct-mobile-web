@extends("layout")

@section("title", $title)
@section('content')
    <div class="buy-container" id="buy" v-cloak>
        <form id="buyOrder">
            <section class="address no" v-if="!hasAddress">
                <a href="{{ url('my/address/create') . '?' . env('REDIRECT_KEY') .'=' . ${env('REDIRECT_KEY')} }}"
                   class="link">亲，请新建或选择默认收货地址以确保宝贝顺利到达<span class="wei-arrow-right"></span></a>
            </section>
            <section class="address" v-else>
                <a href="{{ url('address/choose') . '?' . env('REDIRECT_KEY') .'=' . ${env('REDIRECT_KEY')} }}" class="link">
        <span class="left item">
          <span class="overText">@{{ address.name }}</span>
          <span class="def">默认</span>
        </span>
                    <span class="right item">
          <span>@{{ address.cellPhone }}</span>
          <span class="overText">@{{ addressStr }}</span>
        </span>
                    <span class="wei-arrow-right"></span>
                </a>
            </section>
            <section class="product">
                <a href="javascript:;" class="link" v-for="(item, index) in carts">
      <span class="item intro">
        <img :src="item.img">
      </span>
                    <span class="item info">
        <span class="container overText">
          <span class="name">@{{ item.name }}</span>
          <span class="spec">@{{ item.specName }}</span>
          <span class="price">￥@{{ item.promotionPrice }}<del class="gray">￥@{{ item.price }}</del></span>
        </span>
      </span>
                    <span class="num">
        <span class="container overText">
          x@{{ item.buyCount }}
        </span>
      </span>
                </a>
            </section>
            <section class="options">
                <div class="line">
                    <div class="left">
                        订单优惠<span class="coupon" v-if="hasCoupon">(省@{{ coupon.couponAmount }}元)</span>
                    </div>
                    <div class="right clearfix">
                        <div class="switch-container" v-if="!hasCoupon">
                            <input class="switch" id="used_merit" name="used_merit" v-model="coupPri" @change="showCoup()" type="checkbox" unchecked>
                        </div>
                    </div>
                </div>
                <div class="line buy-ani" :class="{show:show_coup}">
                    <div class="left">
                        <input type="text" v-model="couponcode" class="coup-code" placeholder="请输入优惠券码">
                    </div>
                    <div class="right clearfix">
                        <div class="sub-container">
                            <a href="javascript:;" @click="getCoupon()" class="sub">使用</a>
                        </div>
                    </div>
                </div>
                <div class="line">
                    <div class="left">
                        订单积分<span class="coupon" v-if="!usePoint">(可用@{{ points }}积分)</span><span class="coupon" v-else>(已用@{{ usedPoint }}积分)</span>
                    </div>
                    <div class="right clearfix">
                        <div class="switch-container">
                            <input class="switch" id="used_points" name="used_points" @change="calculateAmount(1)" type="checkbox" unchecked>
                        </div>
                    </div>
                </div>
                <div class="line">
                    <div class="left">
                        订单余额<span class="coupon" v-if="!useAccountAmount">(可用@{{ accountAmount }}余额)</span><span class="coupon" v-else>(已用@{{ usedAccountAmount }}余额)</span>
                    </div>
                    <div class="right clearfix">
                        <div class="switch-container">
                            <input class="switch" id="used_accountAmount" name="used_accountAmount" @change="calculateAmount(2)" type="checkbox" unchecked>
                        </div>
                    </div>
                </div>
                <textarea name="remark" maxlength="150" v-model="remark" placeholder="告诉卖家您的要求吧...（限150个字）" class="msg"></textarea>
            </section>
            <section class="agreement">
                <input type="checkbox" id="agree" name="agree" v-model="has_terms" class="ck">
                <label for="agree" class="agree-container">
                    我已同意《方寸网服务协议》
                </label>
            </section>
            <footer class="foot">
                <div class="pri">应付：￥@{{ totalPrice }}</div>
                <div class="sub">
                    <a href="javascript:;" class="sub" @click="pay()">我要付款</a>
                </div>
            </footer>
        </form>
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
        config = {
            "carts": {!! $products !!},
            "address": {!! $address !!},
            "coupon": {!! $coupon !!},
            "points": {{ $points }},   /* 积分,100积分等于1元 */
            "accountAmount": {{ $availableAmount }},    /* 余额,单位元 */
            "validateCoupon": '{!! $submitCouponProducts !!}',   /* 验证优惠券 */
            "has_terms": true,
            "coupon_url": '{{ url('coupons') }}',
            "pay_url": "{{ url('orders') }}"
        }
    </script>
    <script src="/js/buy.js"></script>
@endsection