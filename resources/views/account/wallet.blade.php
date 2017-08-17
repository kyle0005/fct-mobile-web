@extends("layout")
@section('content')
    <div class="wallet-container">
        <section class="top">
            <div class="inner">
                <div>{{ $account->points }}<br>我的积分</div>
                <div><small class="pri-mark">￥</small> {{ $account->availableAmount }}<br>我的余额</div>
                <div><small class="pri-mark">￥</small> {{ $account->withdrawAmount }}<br>可提现额</div>
            </div>
        </section>
        <section class="nav clearfix">
            <div class="text">实名认证</div>
            <div class="btn-container">
            @if ($member->authStatus == 2)
                <a href="javascript:;" class="btn">已认证</a>
            @elseif ($member->authStatus == 1)
                    <a href="javascript:;" class="btn">审核中</a>
            @else
                <a href="{{ url('my/account/real-auth') }}" class="btn">申请认证</a>
            @endif
            </div>
        </section>
        <section class="items">
            <ul class="list">
                <li>
                    <a href="{{ url('my/account/recharge/create') }}" class="link">
                        <img src="{{ fct_cdn('/images/wallet_recharge.png') }}"><br>充值
                    </a>
                </li>
                <li>
                    <a href="{{ url('my/account/withdraw/create') }}" class="link">
                        <img src="{{ fct_cdn('/images/wallet_withdrawals.png') }}"><br>申请提现
                    </a>
                </li>
                <li>
                    <a href="{{ url('my/account/settlement') }}" class="link">
                        <img src="{{ fct_cdn('/images/wallet_commission.png') }}"><br>佣金结算
                    </a>
                </li>
                <li>
                    <a href="{{ url('my/account/recharge') }}" class="link">
                        <img src="{{ fct_cdn('/images/wallet_record_c.png') }}"><br>充值记录
                    </a>
                </li>
                <li>
                    <a href="{{ url('my/account/withdraw') }}" class="link">
                        <img src="{{ fct_cdn('/images/wallet_record_w.png') }}"><br>提现记录
                    </a>
                </li>
                <li>
                    <a href="{{ url('my/account/logs') }}" class="link">
                        <img src="{{ fct_cdn('/images/wallet_account.png') }}"><br>账户明细
                    </a>
                </li>
            </ul>
        </section>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection