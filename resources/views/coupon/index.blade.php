@extends("layout")

@section('content')
    <div class="coupon-container" id="coupon" v-cloak>
        <div class="tabs">
            <div class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="category(index)">
                <a href="javascript:;" class="link">@{{ item }}</a>
            </div>
        </div>
        <section class="content" v-if="couponlist && couponlist.length > 0">
            <div class="tips" v-if="couponcount > 0">
                <a href="{{ url('coupons/new') }}" class="link">
                  <span class="img-container item">
                    <img src="/images/coupon.png">
                  </span>
                    <span class="item t">您有<span class="num">@{{ couponcount }}</span>张待领取的优惠券哦</span>
                    <span class="wei-arrow-right"></span>
                </a>
            </div>
            <div class="list-item" v-for="(item, index) in couponlist">
                <coupons :couponitem="item"></coupons>
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
                <div class="tip_text">@{{ msg }}</div>
            </section>
        </div>
    </template>
    <script type="text/x-template" id="coupon_item">
        <div>
            <div class="coupon-item">
                <div class="inner">
                    <div class="left" :class="{used: couponitem.auditStatus == 2 || couponitem.auditStatus == 3}">
                        <span class="price"><small class="pri-mark">￥</small><span class="p">@{{ couponitem.amount }}</span></span>
                        <span class="condition">满@{{ couponitem.usingType }}元可用</span>
                    </div>
                    <div class="right">
                        <div class="item">@{{ couponitem.name }}</div>
                        <div class="item">@{{ couponitem.typeId == 0 ? "全场通用" : "部分商品" }}</div>
                        <div class="line">
                            <span class="date">@{{ couponitem.startTime }}-@{{ couponitem.endTime }}</span>
                            <span class="btn" v-if="couponitem.auditStatus == 0">
              <a href="javascript:;" class="use-btn" @click="sub(couponitem.id)">立即使用</a>
            </span>
                        </div>
                        <div class="info clearfix">
                            <span class="text">详细信息</span>
                            <a href="javascript:;" class="pin" :class="{open:show_detail}" @click="showdetail()">
                                <img src="/images/pin.png">
                            </a>
                        </div>
                    </div>
                    <div class="used-bg" v-if="couponitem.auditStatus == 2">
                        <img src="/images/used.png">
                    </div>
                    <div class="used-bg" v-if="couponitem.auditStatus == 3">
                        <img src="/images/overdue.png">
                    </div>
                </div>
            </div>
            <div class="slide" :class="{open:show_detail}">
                <ul class="pros clearfix">
                    <li v-for="(o, i) in couponitem.goods">
                        <a :href="'{{ url('products') }}/' + o.id" class="link">
                            <img :src="o.defaultImage">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </script>
@endsection
@section('javascript')
    <script>
        var config = {
            "couponlistUrl": "{{ url('my/coupons') }}",
            "useUrl": "{{ url('my/coupons') }}",
            "couponlist": {!! json_encode($coupons, JSON_UNESCAPED_UNICODE) !!},
            "couponcount": {{ $canReceiveCount }}

        }
    </script>
    <script src="{{ fct_cdn('/js/coupon.js') }}"></script>
@endsection