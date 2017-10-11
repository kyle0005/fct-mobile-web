@extends("layout")
@section('content')
    <div class="coupon-container" id="coupon" v-cloak>
        <head-top></head-top>
        <section class="content" v-if="couponlist && couponlist.length > 0">
            <div class="list-item" v-for="(item, index) in couponlist">
                <coupons :couponitem="item" @pop="pop" @succhandle="succhandle"></coupons>
            </div>
        </section>

        <no-data v-if="nodata"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>

    <script type="text/x-template" id="coupon_item">
        <div>
            <div class="coupon-item">
                <div class="inner">
                    <div class="left">
                        <span class="price"><small class="pri-mark">￥</small><span class="p">@{{ couponitem.amount }}</span></span>
                        <span class="condition" v-if="couponitem.fullAmount > 0">满@{{ couponitem.fullAmount }}元可用</span>
                        <span class="condition" v-else>无条件使用</span>
                    </div>
                    <div class="right">
                        <div class="item">@{{ couponitem.name }}</div>
                        <div class="item">@{{ couponitem.typeId == 0 ? "全场通用" : "部分宝贝" }}</div>
                        <div class="line">
                            <span class="date">@{{ couponitem.startTime }}-@{{ couponitem.endTime }}</span>
                            <span class="btn">
                                <a href="javascript:;" class="use-btn">
                                    <subpost :txt="getText" :ref="'subpost' + couponitem.id" @callback="receive(couponitem.id)" @succhandle="succhandle"></subpost>
                                </a>
                            </span>
                        </div>
                        <div class="info clearfix">
                            <span class="text">详细信息</span>
                            <a href="javascript:;" class="pin" :class="{open:show_detail}" @click="showdetail()">
                                <img src="{{ fct_cdn('/img/mobile/pin.png') }}">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide" :class="{open:show_detail}">
                <ul class="pros clearfix">
                    <li v-for="(o, i) in couponitem.goods">
                        <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + o.id" class="link">
                            <img v-view="o.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </script>
@endsection
@section('javascript')
    <script>
        config.getCouponUrl = "{{ url('my/coupons', [], env('APP_SECURE')) }}";
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.couponlist = {!! json_encode($coupons, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/coupon.js') }}"></script>
@endsection