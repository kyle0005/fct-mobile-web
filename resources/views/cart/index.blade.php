@extends("layout")


@section('content')
    <div class="cart-container" id="cart" v-cloak>
        <form id="cart-form">
            <ul class="cart-list" v-if="pro_list && pro_list.length > 0">
                <li class="cart-item" v-for="(item, index) in pro_list">
                    <label class="chk col">
                        <input type="checkbox" name="chk-items" class="chk-items" :value="item" v-model="ischeck" @change="caltotalpri()">
                    </label>
                    <a href="javascript:;" class="product col">
                      <span class="pro-item pro-img">
                        <img v-view="item.img" src="{{ fct_cdn('/images/img_loader.gif') }}">
                      </span>
                      <span class="pro-item pro-t">
                        <span class="t">
                          <span class="title overText">@{{ item.name }}</span>
                          <span class="spec" v-if="item.specName && item.specName != null">规格: @{{ item.specName }}</span>
                          <span class="price"><small class="pri-mark">￥</small>@{{ item.promotionPrice }}<del v-if="item.promotionPrice != item.price"><small class="pri-mark">￥</small>@{{ item.price }}</del></span>
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

            <div class="noData" v-else>
                <div class="inner">
                    <img src="{{ fct_cdn('/images/no_data.png') }}">
                    <span class="no">当前没有相关数据哟~</span>
                </div>
            </div>

            <section class="guess-container">
                <div class="title">猜你喜欢</div>
                <ul class="guess clearfix">
                    <li v-for="(item, index) in like_list">
                        <a :href="'{{ url('products') }}/' + item.id" class="guess-link">
                            <img v-view="item.defaultImage" src="{{ fct_cdn('/images/img_loader.gif') }}">
                        </a>
                        <div class="v-title">@{{ item.name }}</div>
                        <div class="v-price"><small class="pri-mark">￥</small>@{{ item.price }}</div>
                    </li>
                </ul>
            </section>
            <footer class="foot-container">
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
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <confirm v-if="showConfirm" :showHide="showConfirm" @ok="ok" @no="no" :callback="callback" :obj="cartItem" :msg="msg"></confirm>
    </div>
@endsection
@section('javascript')
    <script>
        config.carts = {!! $carts !!};
        config.like_list = {!! $likes !!};
        config.buy_url = "{{ url('orders/create') }}";
        config.delete_url = "{{ url('carts') }}";
    </script>
    <script src="{{ fct_cdn('/js/cart.js') }}"></script>
@endsection