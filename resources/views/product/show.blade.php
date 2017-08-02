@extends("layout")

@section("title", $title)
@section('content')
    <div class="detail-container" id="detail" v-cloak>
        <head-top></head-top>
        <section class="nav-bar">
            <ul>
                <li class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="linkTo(index)">
                    <a href="javascript:;">
                        @{{ item }}
                    </a>
                </li>
            </ul>
        </section>
        <div class="tabs">
            <keep-alive>
                <component :is="currentView">
                    <!-- 组件在 vm.currentview 变化时改变！ -->
                </component>
            </keep-alive>
        </div>
        <a href="javascript:;" class="top" @click="top()">
            <img src="/images/top.png">
        </a>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <footer class="foot-container">
            <div class="aside" :class="{open:open,docked:docked}" @click.prevent="choose()">
                <div class="container">
                    <form id="addcart">
                        <div class="choose" @click.stop="">
                            <div class="clearfix">
                                <div class="pro-img">
                                    <img src="/images/resource/pro01.png">
                                </div>
                                <div class="info">
                                    <span class="title">@{{ product.name }}</span>
                                    <span class="price">￥@{{ showprice }}</span>
                                    <span class="stock">库存:@{{ calstock }}</span>
                                </div>
                            </div>
                            <input id="pro_id" name="product_id" type="hidden" :value="product.id">
                            <div v-if="product.specification.length > 0">
                                <input id="spec_id" name="spec_id" type="hidden" :value="specs_single.id">
                            </div>
                            <ul class="spec" v-if="product.specification.length > 0">
                                <li class="item" v-for="(item, index) in product.specification" :class="{active: index===specs_num}" @click="footLinkTo(index)">
                                    @{{ item.name }}
                                </li>
                            </ul>
                            <div class="num">
                                <div class="item"><span class="name">数量</span></div>
                                <div class="item">
                                    <div class="num-container">
                                        <a href="javascript:;" :class="{dis:min}" @click="minus()">
                                            <i class="fa fa-minus"></i>
                                        </a>
                                        <input type="text" name="buy_number" class="numbers" v-model="input_val">
                                        <a href="javascript:;" @click="add()" :class="{dis:max}">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>

                                </div>
                            </div>
                            <a href="javascript:;" class="fork" @click="choose()">&nbsp;</a>
                        </div>
                        {{--<a href="javascript:;" class="sub" @click="buy()">确定</a>--}}
                        <ul class="nav">
                            <li class="message" @click="">
                                <a href="javascript:;" class="foot-link">
                                    <img src="/images/msg.png">
                                </a>
                            </li>
                            <li class="cart">
                                <a href="cart.html" class="foot-link">
                                    <img src="/images/cart.png">
                                    <span class="nums" v-if="numsshow">@{{ cart_num }}</span>
                                </a>
                            </li>
                            <li class="collection" :class="{red:collected}"  @click="collection()">
                                <i class="fa fa-heart"></i>
                            </li>
                            <li class="add">
                                <a href="javascript:;" @click="buy()">加入购物车</a>
                            </li>
                            <li class="buy">
                                <a href="javascript:;" @click="buy()">立即购买</a>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
            <ul class="nav">
                <li class="message" @click="">
                    <a href="{!! $chat_url !!}" class="foot-link">
                        <img src="/images/msg.png">
                    </a>
                </li>
                <li class="cart">
                    <a href="{{ url('carts') }}" class="foot-link">
                        <img src="/images/cart.png">
                        <span class="nums" v-if="numsshow">@{{ cart_num }}</span>
                    </a>
                </li>
                <li class="collection" :class="{red:collected}"  @click="collection()">
                    <i class="fa fa-heart"></i>
                </li>
                <li class="add" :class="{ disabled: product.stockCount < 1 || (product.hasDiscount && (product.discount.hasBegin || !product.discount.canBuy)) }">
                    <a href="javascript:;" @click="choose(0)" v-if="!(product.stockCount < 1 || (product.hasDiscount && (product.discount.hasBegin || !product.discount.canBuy)))">加入购物车</a>
                    <a href="javascript:;" v-else>加入购物车</a>
                </li>
                <li class="buy" :class="{ disabled: product.stockCount < 1 || (product.hasDiscount && (product.discount.hasBegin || !product.discount.canBuy)) }">
                    <a href="javascript:;" @click="choose(1)" v-if="!(product.stockCount < 1 || (product.hasDiscount && (product.discount.hasBegin || !product.discount.canBuy)))">立即购买</a>
                    <a href="javascript:;" v-else>立即购买</a>
                </li>
            </ul>
        </footer>
    </div>
@endsection
@section('javascript')
    {!! \App\FctCommon::weChatShare($title, $shareUrl, '', '/images/logo.png') !!}
    <script src="/js/video.js"></script>
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.product = {!! json_encode($product, JSON_UNESCAPED_UNICODE) !!};
        config.fav_url = "{!! url('my/favorites?from_type=0&from_id=' . $product->id) !!}";
        config.discuss_url = "{{ url('products/'.$product->id .'/comments') }}";
        config.artist_url = "{{ url('products/'.$product->id .'/artists') }}";
        config.pug_url = "{{ url('products/'.$product->id .'/materials?material_ids=' . urlencode($product->materialId)) }}";
        config.addcart_url = "{{ url('carts') }}";
        config.buy_url = "{{ url('orders/create') }}";
        config.tab_artist = [];
        config.tab_pug = [];
        config.tab_service = "<div class='title'>退换货政策</div><p>自您签收商品之日起10日内，淘壶人将为您办理退换货服务，且寄回商品实际运费由客户承担；如需办理退换货业务，请您致电客服热线400-0510-570咨询办理。</p><p>" +
            "<br>政策说明：<br><br>1、一张订单淘壶人只为您提供一次退换货服务，为了确保您的权益，请考虑周全后与我们联系。<br>2、请您确保退换货时，商品各种包装完整。<br>" +
            "3、因您个人原因造成的商品损坏（如壶身破损等），不予退换。<br>4、由于物品质量问题造成的退换货，由淘壶人承担双程运费。由于个人喜好原因造成退货，由客户支付双程邮费。感谢您的理解！<br>" +
            "5、退换货发生时，请您选择顺丰快递将商品寄回给我们。<br>6、礼包或超值组合装中的商品不可以选择部分退换货，因退货后，原礼包或套装中商品将无法享受购买时优惠。<br>" +
            "7、图片及信息仅供参照，因拍摄灯光及不同显示器色差等问题可能造成商品图片与实物有一定色差，一切以实物为准。色差问题不在退换货服务行列。" +
            "</p><div class='title'>拒收政策</div><p>在您签收商品前，请先核查商品外包装是否完好，并确认您对产品是否满意。</p><p>1、无专用封箱胶<br>" +
            "在收取快递包时，若发现外包装中无“淘壶人”专用封箱胶，或“淘壶人”专用封箱胶被严重损坏(特别是有被重新封装的痕迹)，您可以拒收。<br>" +
            "2、物品与所购不符<br>签收后，若包装完好但是包裹中的商品数量与您实际购买的商品不吻合时，或所接收的物品与您所购的物品不相符时，请先与快递人员确认，现场拍照；并及时联系我们的客服，我们在与快递公司确认后，将及时为您补发/换发所缺商品。<br>" +
            "3、对产品（或部分）不满意<br>若您对某件或某几件商品的质量不满意，您在拒收这些商品的同时，可正常接收其它商品，对于其它不满意的商品可根据您的意愿联系“淘壶人”的客服为您换货或退款。<br></p>";
    </script>

    <script type="text/x-template" id="overview">
        <div>
            <section class="video-container">
                <video id="my-player" class="video-js vjs-big-play-centered" controls></video>
            </section>
            <section class="product-context" v-if="!(product.hasDiscount && (product.discount.hasBegin || !product.discount.canBuy))">
                <div class="title">@{{ product.name }}</div>
                <div class="vice-title">@{{ product.subTitle }}</div>
                <div class="price">￥@{{ product.salePrice }}</div>
            </section>
            <section class="product-context dis" v-else>
                <div class="title">
                    @{{ product.name }}
                    <div class="discount-container"><span v-if="canBuy">秒杀</span><span v-else>促销</span></div>
                </div>
                <div class="vice-title">@{{ product.subTitle }}</div>
                <div class="price">
                    ￥@{{ product.salePrice }}
                    <del class="del-price">@{{ product.price }}</del>
                </div>
            </section>
            <section class="info">
                <div class="item" v-if="product.hasDiscount">
                    <span class="left">优惠</span>
                    <span class="right">@{{ product.discount.name }}、
                        享受<span class="discount-color">@{{ product.discount.discountRate * 10 }}折</span>
                        (还剩<span class="discount-color">@{{ product.discount.discountTime }}天</span>@{{ product.discount.hasBegin ? '结束' : '开始' }})</span>
                </div>
                <div class="item">
                    <span class="left">服务</span>
                    <span class="right">&bull;&nbsp;顺丰包邮&emsp;&bull;&nbsp;30天无忧退货&emsp;&bull;&nbsp;48小时快速退货</span>
                </div>
                <div class="item">
                    <span class="left">库存</span>
                    <span class="right">@{{ calstock }}</span>
                </div>
                <div class="coupon" v-if="product.hasCoupon">
                    <a :href="product.coupon_url" class="get-coupon">领取优惠券</a>
                </div>
            </section>
            <section class="edit-context" v-html="product.content"></section>
        </div>
    </script>
    <script type="text/x-template" id="artist">
        <div class="artist-contianer">
            <ul class="artist-list clearfix" v-if="titleshow">
                <li v-for="(item, index) in artist">
                    <a href="javascript:;" :class="{red:index===art_num}" @click="loadsingle(index)">
                        <span class="img-container">
                          <img :src="item.headPortrait">
                        </span>
                        <span class="name-container">@{{ item.name }}</span>
                    </a>
                </li>
            </ul>
            <div class='text-container' v-html="artistsingle.description">
            </div>
            <section class="comment">
                <ul class="others">
                    <li v-for="p in artistsingle.products">
                        <a :href="'{{ url('products') }}' + p.id" class="item">
                            <img :src="p.defaultImage">
                            <span class="p-title">@{{ p.name }}</span>
                        </a>
                    </li>
                </ul>
                <a href="{{ url('/') }}" class="for-more">点击了解更多》</a>
            </section>
        </div>
    </script>
    <script type="text/x-template" id="pug">
        <div>
            <ul class="pugs-list clearfix" v-if="titleshow">
                <li v-for="(item, index) in pugs">
                    <a href="javascript:;" :class="{red:index===pug_num}" @click="loadsingle(index)">
                        <span class="img-container">
                          <img :src="item.image">
                        </span>
                        <span class="name-container">@{{ item.name }}</span>
                    </a>
                </li>
            </ul>
            <section class="pug-container" v-html="pugsingle.description">
            </section>
            <section class="spec">
                <ul class="others">
                    <li v-for="p in pugsingle.products">
                        <a :href="'{{ url('products') }}' + p.id" class="item">
                            <img :src="p.defaultImage">
                            <span class="p-title">@{{ p.name }}</span>
                        </a>
                    </li>
                </ul>
            </section>
        </div>
    </script>
    <script type="text/x-template" id="service">
        <section class="service" v-html="tab_service"></section>
    </script>
    <script type="text/x-template" id="discuss">
        <section class="discuss">
            <ul class="list" v-if="commentlist && commentlist.length > 0">
                <li class="item" v-for="(item, index) in commentlist">
                    <div class="user-info clearfix">
                        <div class="left clearfix">
                            <div class="user-photo">
                                <img :src="item.photo">
                            </div>
                            <div class="user-opt">
                                <div>@{{ item.username }}</div>
                                <div class="stars">
                                    <i class="fa fa-star" v-for="m in item.stars"></i><i class="fa fa-star-o" v-for="n in c_star(item.stars)"></i>
                                </div>
                            </div>
                        </div>
                        <div class="right">@{{ item.date }}</div>
                    </div>
                    <div class="comments">
                        <span class="text">@{{ item.text }}</span>
                        <span class="imgs">
                        <img :src="img_item" v-for="(img_item, index) in item.imgs">
                      </span>
                    </div>
                </li>
            </ul>

            <ul class="prolist" v-else>
                <li class="noData">
                    <img src="/images/no_data.png">
                    <span class="no">当前没有相关数据哟~</span>
                </li>
            </ul>
        </section>
    </script>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
            </section>
        </div>
    </template>
    <script src="/js/head.js"></script>
    <script src="/js/common/tools.js"></script>
    <script src="/js/detail.js"></script>
@endsection