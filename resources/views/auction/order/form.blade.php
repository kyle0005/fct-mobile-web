@extends("layout")
@section('content')
    <div class="auctionbuy-container" id="buy" v-cloak>
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
                <a href="javascript:;" class="link">
                  <span class="item intro">
                    <img :src="product.goodsImg">
                  </span>
                <span class="item info">
                    <span class="container overText">
                      <span class="name">@{{ product.goodsName }}</span>
                      <span class="price">保证金：<small class="pri-mark">￥</small>@{{ product.deposit }}</span>
                    </span>
                  </span>
                    <span class="num">
                    <span class="container overText">
                      <small class="pri-mark">￥</small>@{{ product.bidPrice }}
                    </span>
                  </span>
                </a>
            </section>
            <section class="options">
                <div class="line">
                    <div class="left" v-if="points > 0">
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
                <textarea name="remark" maxlength="150" v-model="remark" placeholder="可以写上您的要求...(限150字以内)" class="msg"></textarea>
            </section>
            <section class="agreement">
                <input type="checkbox" id="agree" name="agree" v-model="has_terms" class="ck">
                <label for="agree" class="agree-container">我已认真阅读并同意方寸堂《服务协议》</label>
            </section>
            <footer class="foot">
                <div class="inner">
                    <div class="pri">应付：<small class="pri-mark">￥</small><span class="pri">@{{ toFloat(totalPrice) }}</span></div>
                    <div class="sub">
                        <a href="javascript:;" class="sub">
                            <subpost :txt="payText" ref="paypost" @callback="pay" @succhandle="payhandle"></subpost>
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
        config.address = {!! json_encode($address, JSON_UNESCAPED_UNICODE) !!};
        config.product = {!! json_encode($product, JSON_UNESCAPED_UNICODE) !!};
        config.amount = {{$amount}};
        config.points = {{$points}};
        config.signup_id = {{$signupId}};
        config.pay_url = "{{url('auction/order', [], env('APP_SECURE'))}}"
    </script>
    <script src="{{fct_cdn('/js/mobile/auction_buy.js')}}"></script>
@endsection