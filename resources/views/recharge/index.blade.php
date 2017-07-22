@extends("layout")
@section("title", $title)
@section('content')
    <div class="record-recharge-container" id="recordrecharge">
        <ul class="list">
            <li class="clearfix">
                <div class="info">
                    <div class="up">
                        <span class="long">订单号：1231312</span>
                        <span>￥100:00</span>
                        <span>￥100:00</span>
                        <span class="pri">￥100:00</span>
                    </div>
                    <div class="down">
                        <span class="long">2017-01-01 11:11</span>
                        <span>充值金额</span>
                        <span>赠送金额</span>
                        <span class="pri">获得金额</span>
                    </div>
                </div>
                <div class="btn-container">
                    <a href="javascript:;" class="btn">我要付款</a>
                </div>
            </li>
            <li class="clearfix">
                <div class="info">
                    <div class="up">
                        <span class="long">订单号：1231312</span>
                        <span>￥100:00</span>
                        <span>￥100:00</span>
                        <span class="pri">￥100:00</span>
                    </div>
                    <div class="down">
                        <span class="long">2017-01-01 11:11</span>
                        <span>充值金额</span>
                        <span>赠送金额</span>
                        <span class="pri">获得金额</span>
                    </div>
                </div>
                <div class="btn-container">
                    <a href="javascript:;" class="btn">我要付款</a>
                </div>
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
@endsection
@section('javascript')

@endsection