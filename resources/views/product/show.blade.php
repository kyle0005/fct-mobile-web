@extends("layout")

@section("title", $title)
@section('content')
    <div class="detail-container" id="detail">
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
                        <a href="javascript:;" class="sub" @click="buy()">确定</a>
                    </form>
                </div>
            </div>
            <ul class="nav">
                <li class="message" @click="">
                    <a href="{!! $chat_url !!}" class="foot-link">
                        <img src="/images/msg.png">
                    </a>
                </li>
                <li class="cart" @click="choose()">
                    <a href="{{ url('carts') }}" class="foot-link">
                        <img src="/images/cart.png">
                        <span class="nums" v-if="numsshow">@{{ product.cartProductCount }}</span>
                    </a>
                </li>
                <li class="collection" :class="{red:collected}"  @click="collection()">
                    <i class="fa fa-heart"></i>
                </li>
                <li class="add">
                    <a href="javascript:;" @click="choose(0)">加入购物车</a>
                </li>
                <li class="buy">
                    <a href="javascript:;" @click="choose(1)">立即购买</a>
                </li>
            </ul>
        </footer>
    </div>
@endsection
@section('javascript')
    <script src="/js/video.js"></script>
    <script>
        var config = {
            "productsType": {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!},
            "product": {!! json_encode($product, JSON_UNESCAPED_UNICODE) !!},
            "fav_url" : "{{ url('favorites') }}",
            "discuss_url" : "{{ url('products/'.$product->id .'/comments') }}",
            "artist_url" : "{{ url('products/'.$product->id .'/artists') }}",
            "pug_url" : "{{ url('products/'.$product->id .'/materials') }}",
            "addcart_url": "{{ url('carts') }}",
            "buy_url": "{{ url('orders/create') }}",
            "tab_artist": {
                //请求 文本编辑器html内容 和 底部产品内容
                "text": "<div class='text-container'>" +
                "<section class='artist'>" +
                "<div class='intro'>" +
                "<span class='photo'>" +
                "<img src='/images/resource/artist.png'>" +
                "</span>" +
                "<span class='artist-info'>" +
                "<span class='artist-name'>顾景舟&nbsp;GU&nbsp;JING&nbsp;ZHOU</span><br>" +
                "<span>宜兴紫砂壶名艺xxx<br>中国美术协会会员<br>中国工艺美术大师</span>" +
                "</span>" +
                "</div>" +
                "<div class=''>" +
                "顾景舟，（1915-1966），原名景洲。18岁拜名师学艺xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" +
                "</div>" +
                "</section>" +
                "<section class='record'>" +
                "<div class='title'>成交记录</div>" +
                "<div class='list'>" +
                "<span>xxxx壶拍卖 成交价1234万</span>" +
                "<span>xxxx壶拍卖 成交价1234万</span>" +
                "<span>xxxx壶拍卖 成交价1234万</span>" +
                "</div>" +
                "</section>" +
                "<section class='comment'>" +
                "<div class='title'>社会评价</div>" +
                "<p class='context'>" +
                "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx" +
                "</p>" +
                "</section>" +
                "</div>",
                "": ""
            },
            "tab_pug": {
                //请求 数据对象 和 底部产品内容
            },
            "tab_service": "<div class='title'>退换货政策</div><p>自您签收商品之日起10日内，淘壶人将为您办理退换货服务，且寄回商品实际运费由客户承担；如需办理退换货业务，请您致电客服热线400-0510-570咨询办理。</p><p>" +
            "<br>政策说明：<br><br>1、一张订单淘壶人只为您提供一次退换货服务，为了确保您的权益，请考虑周全后与我们联系。<br>2、请您确保退换货时，商品各种包装完整。<br>" +
            "3、因您个人原因造成的商品损坏（如壶身破损等），不予退换。<br>4、由于物品质量问题造成的退换货，由淘壶人承担双程运费。由于个人喜好原因造成退货，由客户支付双程邮费。感谢您的理解！<br>" +
            "5、退换货发生时，请您选择顺丰快递将商品寄回给我们。<br>6、礼包或超值组合装中的商品不可以选择部分退换货，因退货后，原礼包或套装中商品将无法享受购买时优惠。<br>" +
            "7、图片及信息仅供参照，因拍摄灯光及不同显示器色差等问题可能造成商品图片与实物有一定色差，一切以实物为准。色差问题不在退换货服务行列。" +
            "</p><div class='title'>拒收政策</div><p>在您签收商品前，请先核查商品外包装是否完好，并确认您对产品是否满意。</p><p>1、无专用封箱胶<br>" +
            "在收取快递包时，若发现外包装中无“淘壶人”专用封箱胶，或“淘壶人”专用封箱胶被严重损坏(特别是有被重新封装的痕迹)，您可以拒收。<br>" +
            "2、物品与所购不符<br>签收后，若包装完好但是包裹中的商品数量与您实际购买的商品不吻合时，或所接收的物品与您所购的物品不相符时，请先与快递人员确认，现场拍照；并及时联系我们的客服，我们在与快递公司确认后，将及时为您补发/换发所缺商品。<br>" +
            "3、对产品（或部分）不满意<br>若您对某件或某几件商品的质量不满意，您在拒收这些商品的同时，可正常接收其它商品，对于其它不满意的商品可根据您的意愿联系“淘壶人”的客服为您换货或退款。<br></p>"
        }
    </script>


    <script type="text/x-template" id="overview">
        <div>
            <section class="video-container">
                <video id="my-player" class="video-js vjs-big-play-centered" controls></video>
            </section>
            <section class="product-context">
                <div class="title">@{{ product.name }}</div>
                <div class="vice-title">@{{ product.subTitle }}</div>
                <div class="price">￥@{{ product.salePrice }}</div>
            </section>
            <section class="info">
                <div class="item" v-if="product.hasCoupon">
                    <span class="left">优惠</span>
                    <span class="right"><a href="{{ url('discounts', 'product_id='. $product->id) }}">首单优惠活动</a></span>
                </div>
                <div class="item">
                    <span class="left">服务</span>
                    <span class="right">&bull;&nbsp;顺丰包邮&nbsp;&bull;&nbsp;30天无忧退货&nbsp;&bull;&nbsp;48小时快速退货</span>
                </div>
                <div class="item">
                    <span class="left">库存</span>
                    <span class="right">@{{ calstock }}</span>
                </div>
                <div class="coupon" v-if="product.hasCoupon">
                    <a href="{{ url('coupons', 'product_id=' . $product->id) }}" class="get-coupon">领取优惠券</a>
                </div>
            </section>
            <section class="edit-context" v-html="product.content">
                @{{ product.content }}
            </section>
        </div>
    </script>
    <script type="text/x-template" id="artist">
        <div class="artist-contianer">
            <ul class="artist-list clearfix" v-if="titleshow">
                <li v-for="(item, index) in artist">
                    <a href="javascript:;" :class="{red:index===art_num}" @click="loadsingle(index)">
        <span class="img-container">
          <img :src="item.artist_photo">
        </span>
                        <span class="name-container">@{{ item.artist_name }}</span>
                    </a>
                </li>
            </ul>
            <div class='text-container'>
                @{{ artistsingle.text }}
            </div>
            <section class="comment">
                <ul class="others">
                    <li v-for="img_item in artistsingle.img">
                        <a href="javascript:;" class="item">
                            <img :src="img_item.url">
                            <span class="p-title">@{{ img_item.name }}</span>
                        </a>
                    </li>
                </ul>
                <a :href="artistsingle.link" class="for-more">点击了解更多》</a>
            </section>
        </div>
    </script>
    <script type="text/x-template" id="pug">
        <div>
            <ul class="pugs-list clearfix" v-if="titleshow">
                <li v-for="(item, index) in pugs">
                    <a href="javascript:;" :class="{red:index===pug_num}" @click="loadsingle(index)">
        <span class="img-container">
          <img :src="item.pug_photo">
        </span>
                        <span class="name-container">@{{ item.pug_name }}</span>
                    </a>
                </li>
            </ul>
            <section class="pug-container">
                <div class="intro">
          <span class="photo">
            <img :src="pugsingle.pug_photo">
          </span>
                    <span class="pug">
            <span class="pug-name">@{{ pugsingle.pug_name }}</span><br>
            <span class="pug-detail">@{{ pugsingle.pug_detail }}</span>
          </span>
                </div>
            </section>
            <section class="spec">
                <div class="title">@{{ pugsingle.spec }}</div>
                <div class="details">
                    @{{ pugsingle.spec_content }}
                </div>
                <ul class="others">
                    <li v-for="img_item in pugsingle.img">
                        <a href="javascript:;" class="item">
                            <img :src="img_item.url">
                            <span class="p-title">@{{ img_item.name }}</span>
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
            <ul class="list">
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