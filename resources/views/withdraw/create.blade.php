@extends("layout")
@section("title", $title)
@section('content')
    <div class="withdrawals-container" id="withdrawals" v-cloak>
        <section class="list">
            <div class="item">
                <div class="inner">
                    <span class="left">提现金额</span>
                    <span class="right"><input type="tel" name="money" class="inp" v-model.lazy="amount" :placeholder="'可提现金额<small class="pri-mark">￥</small>' + withdrawals.withdrawAmount"></span>
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">提现账户</span>
                    <span class="right">@{{ withdrawals.bankName }}</span>
{{--                    <select class="select" disabled>
                        <option>@{{ withdrawals.bankName }}</option>
                    </select>--}}
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">开户人姓名</span>
                    <span class="right">@{{ withdrawals.name }}</span>
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">开户人账号</span>
                    <span class="right">@{{ withdrawals.bankAccount }}</span>
                </div>
            </div>
        </section>
        <div class="sub-btn">
            <a href="javascript:;" @click="sub">提交申请</a>
        </div>
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
    <script>
        config.withdrawalsUrl = "{{ url('my/account/withdraw') }}";
        config.withdrawals = {!! json_encode($entry, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="/js/withdrawals.js"></script>
@endsection