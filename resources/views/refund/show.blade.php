@extends("layout")
@section('content')
    <div class="aftersaledetail-container" id="aftersaledetail" v-cloak>
        <section class="product">
            <div class="pro-item img-container">
                <img v-view="product.orderGoods.img" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
            </div>
            <div class="pro-item title-container">
                <div class="title">@{{ product.orderGoods.name }}</div>
                <div class="spec" v-if="product.specName && product.specName != null">规格: &nbsp;@{{ product.orderGoods.specName }}</div>
            </div>
            <div class="pro-item price-container">
                <div class="price"><small class="pri-mark">￥</small>@{{ product.orderGoods.price }}</div>
                <div class="num">&times; @{{ product.orderGoods.buyCount }}</div>
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
                    <div class="img" v-for="(img, i) in item.images">
                        <img v-view="img" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                    </div>
                </div>
            </div>
        </section>

        <footer class="foot-container">
            <div class="inner">
                <div class="sub-btn">
                    <a href="javascript:;" @click="confirm(closeApp)" v-if="product.status == 0">关闭申请</a>
                    <a href="javascript:;" @click="sendback()" v-if="product.status == 1">寄回宝贝</a>
                </div>

                <div class="aside" :class="{open:open,docked:docked}" @click.prevent="sendback()">
                    <div class="container">
                        <form id="deliver">
                            <div class="choose" @click.stop="">
                                <section class="list-container">
                                    <div class="line">
                                        <div class="left">物流公司</div>
                                        <div class="right">
                                            <input type="text" class="right-inp" name="title" v-model="name">
                                        </div>
                                    </div>
                                    <div class="line">
                                        <div class="left">物流单号</div>
                                        <div class="right">
                                            <input type="text" class="right-inp" name="number" v-model="number">
                                        </div>
                                    </div>
                                </section>
                                <div class="fork-container" @click="sendback()">
                                    <a href="javascript:;" class="fork" >&nbsp;</a>
                                </div>
                            </div>
                            <a href="javascript:;" class="sub">
                                <subpost :txt="subText" ref="subpost" @callback="deliver" @succhandle="succhandle"></subpost>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </footer>

        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <confirm v-if="showConfirm" :showHide="showConfirm" @ok="ok" @no="no" :callback="callback" :msg="msg"></confirm>
    </div>
@endsection
@section('javascript')
    <script>
        config.product = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
        config.cancel_url = "{{ url('my/refunds/' . $entity->id . '/cancel') }}";
        config.sendbackUrl = "{{ url('my/refunds/' . $entity->id . '/express') }}"
    </script>
    <script src="{{ fct_cdn('/js/mobile/aftersale_detail.js') }}"></script>
@endsection