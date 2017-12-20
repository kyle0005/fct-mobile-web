@extends("layout")
@section('content')
    <div class="buy-container" id="buy" v-cloak>
        <form id="buyOrder">
            <section class="address no" v-if="!hasAddress">
                <a href="{{ url('my/address/create', [], env('APP_SECURE')) . '?' . env('REDIRECT_KEY') .'=' . ${env('REDIRECT_KEY')} }}"
                   class="link">亲，请新建或选择默认收货地址以确保宝贝顺利到达<span class="wei-arrow-right"></span></a>
            </section>
            <section class="address" v-else>
                <a href="{{ url('address/choose', [], env('APP_SECURE')) . '?' . env('REDIRECT_KEY') .'=' . ${env('REDIRECT_KEY')} }}" class="link">
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
                    <img v-view="item.img" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                  </span>
                    <span class="item info">
                    <span class="container overText">
                      <span class="name">@{{ item.name }}</span>
                      <span class="spec">@{{ item.specName }}</span>
                      <span class="price"><small class="pri-mark">￥</small>@{{ item.promotionPrice }}<del class="gray" v-if="item.promotionPrice != item.price"><small class="pri-mark">￥</small>@{{ item.price }}</del></span>
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
                            <input class="switch" id="used_merit" name="used_merit" v-model="coupPri" @change="showCoup()" type="checkbox" >
                        </div>
                    </div>
                </div>
                <div class="line buy-ani" :class="{show:show_coup}">
                    <div class="left">
                        <input type="text" v-model="couponcode" class="coup-code" placeholder="请输入优惠券码">
                    </div>
                    <div class="right clearfix">
                        <div class="sub-container">
                            <a href="javascript:;" class="sub">
                                <subpost :txt="'使用'" :status="true" ref="usecoup" @callback="getCoupon" @before="postBefore"
                                         @success="succhandle" @error="postError" @alert="postTip"></subpost>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="line" v-if="points > 0">
                    <div class="left">
                        <span v-if="!usePoint">可用<span class="coupon">@{{ points }}</span>积分</span><span v-else>已用<span class="coupon">@{{ usedPoint }}</span>积分</span>
                    </div>
                    <div class="right clearfix">
                        <div class="switch-container">
                            <input class="switch" id="used_points" name="used_points" @change="calculateAmount(1)" type="checkbox" >
                        </div>
                    </div>
                </div>
                <div class="line" v-if="accountAmount > 0">
                    <div class="left">
                        <span v-if="!useAccountAmount">可用<span class="coupon">@{{ accountAmount }}</span>余额</span><span v-else>已用<span class="coupon">@{{ usedAccountAmount }}</span>余额</span>
                    </div>
                    <div class="right clearfix">
                        <div class="switch-container">
                            <input class="switch" id="used_accountAmount" name="used_accountAmount" @change="calculateAmount(2)" type="checkbox" >
                        </div>
                    </div>
                </div>
                <textarea name="remark" maxlength="150" v-model="remark" placeholder="可以写上您的要求…（限150字内）" class="msg"></textarea>
            </section>
            <section class="agreement">
                <input type="checkbox" id="agree" name="agree" v-model="has_terms" class="ck">
                <a for="agree" class="agree-container">我已认真阅读并同意方寸堂<a href="{{ url('help', [], env('APP_SECURE')) }}#/detail?articleId=15">《服务协议》</a></label>
            </section>
            <footer class="foot">
                <div class="inner">
                    <div class="pri">应付：<small class="pri-mark">￥</small><span class="pri">@{{ toFloat(totalPrice) }}</span></div>
                    <div class="sub">
                        <a href="javascript:;" class="sub">
                            <subpost :txt="'我要付款'" :status="true" ref="paypost" @callback="pay" @before="postBefore"
                                     @success="postSuc" @error="postError" @alert="postTip"></subpost>
                        </a>
                    </div>
                </div>
            </footer>
        </form>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
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
            "coupon_url": '{{ url('my/coupons/use', [], env('APP_SECURE')) }}',
            "pay_url": "{{ url('orders', [], env('APP_SECURE')) }}"
        }
    </script>
    <script src="{{ fct_cdn('/js/mobile/buy.js') }}"></script>
@endsection