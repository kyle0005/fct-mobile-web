@extends("layout")
@section("title", $title)
@section('content')
    <div class="withdrawals-container" id="withdrawals">
        <section class="list">
            <div class="item">
                <div class="inner">
                    <span class="left">提现金额</span>
                    <span class="right">可提现金额￥212323.00</span>
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">提现账户</span>
                    <select class="select">
                        <option>支付宝</option>
                    </select>
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">开户人姓名</span>
                    <span class="right">xxxxx</span>
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">开户人账号</span>
                    <span class="right">xxxxx@126.com</span>
                </div>
            </div>
        </section>
        <div class="sub-btn">
            <a href="javascript:;">提交申请</a>
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

@endsection