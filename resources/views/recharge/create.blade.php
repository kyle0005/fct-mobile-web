@extends("layout")

@section('content')
    <div class="recharge-container" id="recharge" v-cloak>
        <section class="top">
            <div class="inner" v-if="isOther">
                <strong class="other">其他金额</strong>
                <input type="number" class="inp" v-focus="" v-model.number.lazy="charge_num" placeholder="手动输入充值金额">
                <div v-if="hasNum">送@{{ gift }}元，可得@{{ balance }}余额。</div>
                <div class="txt" v-else>200元起充，500元起返</div>
            </div>
            <div class="inner" v-else>
                <div class="f">充<span class="pri">@{{ charge_num }}</span>元</div>
                <div class="s">送@{{ gift }}元，可得@{{ balance }}余额。</div>
                <div class="t"><img src="{{ fct_cdn('/images/category1.png') }}" alt=""></div>
            </div>
        </section>
        <section class="choose">
            <div class="item" :class="{chose: index===tab_num}" v-for="(item, index) in charge_nums" @click="choose(item.giftPercent, item.price, index)">
                <a href="javascript:;" class="link" v-if="showText(item)">其他金额</a>
                <a href="javascript:;" class="link" v-else><span class="pri-mark">￥</span> @{{ item.price }}</a>
            </div>
        </section>
        <div class="tips">点我要充值，即表示您已同意方寸堂<strong>《充返活动协议》</strong></div>
        <footer class="foot">
            <div class="pri">应付:<small class="pri-mark">￥</small>@{{ charge_num }}</div>
            <div class="sub">
                <a href="javascript:;" class="sub">
                    <subpost :txt="subText" ref="subpost" @callback="sub" @succhandle="succhandle"></subpost>
                </a>
            </div>
        </footer>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.rechargeUrl="@{{ url('my/account/recharge') }}";
        config.charge = {!! json_encode($recharge) !!};
    </script>
    <script src="{{ fct_cdn('/js/recharge.js') }}"></script>
@endsection