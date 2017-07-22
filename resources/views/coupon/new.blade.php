@extends("layout")
@section("title", $title)
@section('content')
    <div class="coupon-container" id="coupon">
        <section class="content">
            <div class="list-item">
                <div class="coupon-item">
                    <div class="inner">
                        <div class="left">
                            <span class="price">￥<span class="p">30</span></span>
                            <span class="condition">满100元可用</span>
                        </div>
                        <div class="right">
                            <div class="item">限购登堂入室级别紫砂壶</div>
                            <div class="item">全场通用</div>
                            <div class="line">
                                <span class="date">2017.03.03-2022.01.01</span>
                                <span class="btn">
              <a href="javascript:;" class="use-btn">点击领取</a>
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
                        <li>
                            <a href="javascript:" class="link">
                                <img src="/images/resource/pro01.png">
                            </a>
                        </li>
                        <li>
                            <a href="javascript:" class="link">
                                <img src="/images/resource/pro01.png">
                            </a>
                        </li>
                        <li>
                            <a href="javascript:" class="link">
                                <img src="/images/resource/pro01.png">
                            </a>
                        </li>
                        <li>
                            <a href="javascript:" class="link">
                                <img src="/images/resource/pro01.png">
                            </a>
                        </li>
                        <li>
                            <a href="javascript:" class="link">
                                <img src="/images/resource/pro01.png">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
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

@endsection