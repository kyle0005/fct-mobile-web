@extends("layout")
@section("title", $title)
@section('content')
    <div class="commission-container" id="commission">
        <div class="tabs">
            <div class="item chosen">
                <a href="javascript:;" class="link">等待结算</a>
            </div>
            <div class="item ">
                <a href="javascript:;" class="link">结算成功</a>
            </div>
        </div>
        <div class="orders-list">
            <div class="items">
                <div class="info">
                    <div class="left">订单号：2141241242414</div>
                    <div class="right">2017-01-01 12:00</div>
                </div>
                <ul class="list">
                    <li class="product">
                        <div class="pro-item img-container">
                            <img src="/images/resource/pro01.png">
                        </div>
                        <div class="pro-item title-container">
                            <div class="title">xxxxxx壶</div>
                            <div class="spec">规格: &nbsp;333MM</div>
                        </div>
                        <div class="pro-item price-container">
                            <div class="price">￥1231222312.00</div>
                            <div class="num">*2</div>
                        </div>
                    </li>
                    <li class="product">
                        <div class="pro-item img-container">
                            <img src="/images/resource/pro01.png">
                        </div>
                        <div class="pro-item title-container">
                            <div class="title">xxxxxx壶</div>
                            <div class="spec">规格: &nbsp;333MM</div>
                        </div>
                        <div class="pro-item price-container">
                            <div class="price">￥1231222312.00</div>
                            <div class="num">*2</div>
                        </div>
                    </li>
                </ul>
                <div class="total">
                    <div class="inner">共<span class="pri">2</span>件商品&nbsp;合计佣金：<span class="pri">￥1231132131.00</span></div>
                </div>
            </div>
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