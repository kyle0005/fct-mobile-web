@extends("layout")
@section("title", $title)
@section('content')
    <div class="walletaccount-container" id="withdrawalsrecord" v-cloak>
        <ul class="list">
            <li>
                <div class="inner">
                    <div class="up clearfix">
                        <span>招商银行</span><span class="pri">-1000.00</span>
                    </div>
                    <div class="down clearfix">
                        <span>状态：等待财务处理</span><span class="pri">13.00</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="inner">
                    <div class="up clearfix">
                        <span>支付宝(xxxxx@xx.com)</span><span class="pri">-1.00</span>
                    </div>
                    <div class="down clearfix">
                        <span>状态：提现成功</span><span class="pri">12.00</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="inner">
                    <div class="up clearfix">
                        <span>支付宝(xxxxx@xx.com)</span><span class="pri">+2000.00</span>
                    </div>
                    <div class="down clearfix">
                        <span>状态：提现成功</span><span class="pri">2012.00</span>
                    </div>
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