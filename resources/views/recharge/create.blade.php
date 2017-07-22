@extends("layout")
@section("title", $title)
@section('content')
    <div class="recharge-container" id="recharge">
        <section class="top">
            <div class="f">充<span class="pri">3000</span>元</div>
            <div class="s">送1000元，可得4000余额。</div>
            <div class="t"><img src="/images/category1.png" alt=""></div>
        </section>
        <section class="choose">
            <div class="item chose">
                <a href="javascript:;" class="link">￥500</a>
            </div>
            <div class="item">
                <a href="javascript:;" class="link">￥1000</a>
            </div>
            <div class="item">
                <a href="javascript:;" class="link">￥2000</a>
            </div>
            <div class="item">
                <a href="javascript:;" class="link">￥3000</a>
            </div>
            <div class="item">
                <a href="javascript:;" class="link">￥5000</a>
            </div>
            <div class="item">
                <a href="javascript:;" class="link">￥6000</a>
            </div>
            <div class="item">
                <a href="javascript:;" class="link">￥8000</a>
            </div>
            <div class="item">
                <a href="javascript:;" class="link">￥10000</a>
            </div>
            <div class="item">
                <a href="javascript:;" class="link">其他金额</a>
            </div>
        </section>
        <div class="tips">点我要充值，即表示您已同意方寸堂<strong>《充返活动协议》</strong></div>
        <footer class="foot">
            <div class="pri">应付:￥3000</div>
            <div class="sub">
                <a href="javascript:;" class="sub" >我要充值</a>
            </div>
        </footer>
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