@extends("layout")

@section("title", $title)
@section('content')
    <div class="cart-container" id="cart">
        <form id="cart-form">
            <ul class="cart-list">
                <li class="cart-item" v-for="(item, index) in pro_list">
                    <label class="chk col">
                        <input type="checkbox" name="chk-items" class="chk-items" :value="item" v-model="ischeck" @change="selectedProduct(item)">
                    </label>
                    <a href="javascript:;" class="product col">
          <span class="pro-item pro-img">
            <img :src="item.img">
          </span>
                        <span class="pro-item pro-t">
            <span class="t">
              <span class="title overText">@{{ item.name }}</span>
              <span class="spec">规格: @{{ item.specName }}</span>
              <span class="price">￥@{{ item.promotionPrice }}<del>￥@{{ item.price }}</del></span>
            </span>
          </span>
                    </a>
                    <div class="num-container col">
                        <div class="num">
                            <a href="javascript:;" :class="{dis:min}" @click="minus(item)">
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
            <section class="guess-container">
                <div class="title">猜你喜欢</div>
                <ul class="guess clearfix">
                    <li v-for="(item, index) in like_list">
                        <a href="javascript:;" class="guess-link">
                            <img :src="item.defaultImage">
                        </a>
                        <div class="v-title">@{{ item.name }}</div>
                        <div class="v-price">￥@{{ item.price }}</div>
                    </li>
                </ul>
            </section>
            <footer class="foot-container">
                <ul class="nav">
                    <li class="choose">
                        <div class="chk-container">
                            <label for="chooseall" class="text-container">
                                <input type="checkbox" id="chooseall" name="chooseall"
                                       class="chooseall" v-model="checkAll" @click="chooseall()"><span class="chosen">已选(@{{ choose_num }})</span>
                            </label>
                        </div>
                    </li>
                    <li class="price">￥@{{ total_pri }}</li>
                    <li class="buy">
                        <a href="javascript:;" @click="buy()">立即购买</a>
                    </li>
                </ul>
            </footer>
        </form>
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
        var config = {
            "carts": {!! $carts !!},
            "like_list": {!! $likes !!},
            "buy_url": "{{ url('orders/create') }}"
        };
    </script>
    <script src="/js/cart.js"></script>
@endsection