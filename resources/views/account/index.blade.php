@extends("layout")
@section("title", $title)
@section('content')
    <div class="walletaccount-container" id="walletaccount">
        <ul class="list">
            <li>
                <div class="inner">
                    <div class="up clearfix">
                        <span>购买xxx商品</span><span class="pri">-1000.00</span>
                    </div>
                    <div class="down clearfix">
                        <span>2017-01-01 12:00</span><span class="pri">13.00</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="inner">
                    <div class="up clearfix">
                        <span>提现金额</span><span class="pri">-1.00</span>
                    </div>
                    <div class="down clearfix">
                        <span>2017-01-01 12:00</span><span class="pri">12.00</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="inner">
                    <div class="up clearfix">
                        <span>充值</span><span class="pri">+2000.00</span>
                    </div>
                    <div class="down clearfix">
                        <span>2017-01-01 12:00</span><span class="pri">2012.00</span>
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