@extends("layout")
@section("title", $title)
@section('content')
    <div class="coupon-container" id="coupon" v-cloak>
        <section class="content" v-if="couponlist.length > 0">
            <div class="list-item" v-for="(item, index) in couponlist">
                <coupons :couponitem="item" @pop="pop"></coupons>
            </div>
        </section>

        <ul class="prolist" v-else>
            <li class="noData">
                <img src="/images/no_data.png">
                <span class="no">当前没有相关数据哟~</span>
            </li>
        </ul>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@@{{ msg }}</div>
            </section>
        </div>
    </template>

    <script type="text/x-template" id="coupon_item">
        <div>
            <div class="coupon-item">
                <div class="inner">
                    <div class="left">
                        <span class="price">￥<span class="p">@{{ couponitem.amount }}</span></span>
                        <span class="condition" v-if="couponitem.fullAmount > 0">满@{{ couponitem.fullAmount }}元可用</span>
                        <span class="condition" v-else>无条件使用</span>
                    </div>
                    <div class="right">
                        <div class="item">@{{ couponitem.name }}</div>
                        <div class="item">@{{ couponitem.typeId == 0 ? "全场通用" : "部分商品" }}</div>
                        <div class="line">
                            <span class="date">@{{ couponitem.startTime }}-@{{ couponitem.endTime }}</span>
                            <span class="btn">
              <a href="javascript:;" class="use-btn" @click="receive(couponitem.id)">点击领取</a>
            </span>
                        </div>
                        <div class="info clearfix">
                            <span class="text">详细信息</span>
                            <a href="javascript:;" class="pin" :class="{open:show_detail}" @click="showdetail()">
                                <img src="/images/pin.png">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slide" :class="{open:show_detail}">
                <ul class="pros clearfix">
                    <li v-for="(o, i) in couponitem.goods">
                        <a href="javascript:" class="link">
                            <img :src="o.defaultImage">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </script>
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
        config.getCouponUrl = "{{ url('my/coupons') }}";
        config.couponlist = {!! json_encode($coupons, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="/js/coupon.js"></script>
@endsection