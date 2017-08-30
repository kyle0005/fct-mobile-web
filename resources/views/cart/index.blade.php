@extends("layout")
@section('content')
    <div class="cart-container" id="cart" v-cloak>
        <head-top></head-top>
        <form id="cart-form" v-if="pro_list && pro_list.length > 0">
            <div class="contianer">
                <ul class="cart-list" v-if="pro_list && pro_list.length > 0">
                    <li class="cart-item" v-for="(item, index) in pro_list">
                        <label class="chk col">
                            <input type="checkbox" name="chk-items" class="chk-items" :value="item" v-model="ischeck" @change="caltotalpri()">
                        </label>
                        <a :href="'{{ url('products') }}/' + item.goodsId" class="product col">
                          <span class="pro-item pro-img">
                            <img v-view="item.img" src="{{ fct_cdn('/images/img_loader_s.gif') }}">
                          </span>
                          <span class="pro-item pro-t">
                            <span class="t">
                              <span class="title overText">@{{ item.name }}</span>
                              <span class="spec">规格: @{{ item.specName }}</span>
                              <span class="price"><small class="pri-mark">￥</small>@{{ item.promotionPrice }}<del><small class="pri-mark">￥</small>@{{ item.price }}</del></span>
                            </span>
                          </span>
                        </a>
                        <div class="num-container col">
                            <div class="num clearfix">
                                <a href="javascript:;" :class="{dis:min}" @click="minus(item, index)">
                                    <i class="fa fa-minus"></i>
                                </a>
                                <input type="text" class="numbers" :value="item.buyCount">
                                <a href="javascript:;" :class="{dis:max}" @click="add(item)">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
                <img src="{{ fct_cdn('/images/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
            </div>
            <section class="guess-container">
                <div class="title">
                    <div class="lines">
                        <div class="text">猜你喜欢</div>
                    </div>
                </div>
                <ul class="guess clearfix">
                    <li v-for="(item, index) in like_list">
                        <a :href="'{{ url('products') }}/' + item.id" class="guess-link">
                            <img :src="item.defaultImage">
                        </a>
                        <div class="v-title">@{{ item.name }}</div>
                        <div class="v-price"><small class="pri-mark">￥</small>@{{ item.price }}</div>
                    </li>
                </ul>
            </section>
            <footer class="foot-container" >
                <div class="inner">
                    <ul class="nav">
                        <li class="choose">
                            <div class="chk-container">
                                <label for="chooseall" class="text-container">
                                    <input type="checkbox" id="chooseall" name="chooseall" class="chooseall"
                                           v-model="all"><span class="chosen">已选(&nbsp;@{{ choose_num }}&nbsp;)</span>
                                </label>
                            </div>
                        </li>
                        <li class="price"><small class="pri-mark">￥</small>@{{ toFloat(total_pri) }}</li>
                        <li class="buy" :class="{disabled: ischeck.length <= 0}">
                            <a href="javascript:;" @click="buy()" v-if="ischeck.length > 0">立即购买</a>
                            <a href="javascript:;" v-else>立即购买</a>
                        </li>
                    </ul>
                </div>
            </footer>
        </form>

        <div class="noData" v-if="(pro_list && pro_list.length <= 0) || nodata">
            <div class="inner">
                <a href="javascript:;">
                    <img src="{{ fct_cdn('/images/nocart.png') }}" class="no-cart">
                    <span class="no">去添加点什么吧？</span>
                </a>
            </div>
        </div>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <confirm v-if="showConfirm" :showHide="showConfirm" @ok="ok" @no="no" :callback="callback" :obj="cartItem" :msg="msg"></confirm>
    </div>
@endsection
@section('javascript')
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.carts = {!! $carts !!};
        config.like_list = {!! $likes !!};
        config.buy_url = "{{ url('orders/create') }}";
        config.delete_url = "{{ url('carts') }}";
    </script>
    <script src="{{ fct_cdn('/js/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/cart.js') }}"></script>
@endsection