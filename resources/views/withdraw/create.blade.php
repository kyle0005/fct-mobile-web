@extends("layout")
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
            <a href="javascript:;">
                <subpost :txt="'提交申请'" ref="subpost" :status="true" @callback="sub" @before="postBefore"
                         @success="postSuc" @error="postError" @alert="postTip"></subpost>
            </a>
        </div>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.withdrawalsUrl = "{{ url('my/account/withdraw', [], env('APP_SECURE')) }}";
        config.withdrawals = {!! json_encode($entry, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/withdrawals.js') }}"></script>
@endsection