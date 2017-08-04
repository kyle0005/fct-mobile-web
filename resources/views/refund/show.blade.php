@extends("layout")

@section('content')
    <div class="aftersaledetail-container" id="aftersaledetail" v-cloak>
        <section class="product">
            <div class="pro-item img-container">
                <img :src="product.orderGoods.img">
            </div>
            <div class="pro-item title-container">
                <div class="title">@{{ product.orderGoods.name }}</div>
                <div class="spec">规格: &nbsp;@{{ product.orderGoods.specName }}</div>
            </div>
            <div class="pro-item price-container">
                <div class="price"><small class="pri-mark">￥</small>@{{ product.orderGoods.price }}</div>
                <div class="num">*@{{ product.orderGoods.buyCount }}</div>
                <div class="total"><span class="inner">合计:<span class="pri"><small class="pri-mark">￥</small>@{{ product.orderGoods.payAmount }}</span></span></div>
            </div>
        </section>
        <section class="options">
            <ul class="list">
                <li>
                    <div class="inner">
                        <span class="left">退款状态</span>
                        <span class="right status">@{{ product.statusName }}</span>
                    </div>
                </li>
                <li>
                    <div class="inner">
                        <span class="left">服务类型</span>
                        <span class="right">@{{ product.serviceType }}</span>
                    </div>
                </li>
                <li>
                    <div class="inner">
                        <span class="left">退款原因</span>
                        <span class="right">@{{ product.refundReason }}</span>
                    </div>
                </li>
            </ul>
        </section>
        <section class="des-list">
            <div class="item" v-for="(item, index) in product.orderRefundMessage">
                <div class="line">
                    <div class="inner">
                        <span class="left">@{{ item.description }}</span>
                        <span class="right">@{{ item.createTime }}</span>
                    </div>
                </div>
                <div class="line">
                    <div class="img" v-for="(img, i) in item.images"><img :src="img"></div>
                </div>
            </div>
        </section>
        <div class="sub-btn">
            <a href="javascript:;">关闭申请</a>
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
        config.product = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/aftersale_detail.js') }}"></script>
@endsection