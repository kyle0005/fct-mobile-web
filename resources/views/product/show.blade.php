@extends("layout")
@section('content')
    <div class="detail-container" id="detail" v-cloak>
        <head-top></head-top>
        <section class="nav-bar">
            <ul>
                <li class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="linkTo(index)">
                    <a href="javascript:;">@{{ item }}</a>
                </li>
            </ul>
        </section>
        <div class="tabs">
            <keep-alive>
                <component :is="currentView"></component>
            </keep-alive>
        </div>
        <a href="javascript:;" class="top" @click="top()">
            <img src="{{ fct_cdn('/images/top.png') }}">
        </a>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <footer class="foot-container">
            <div class="inner">
                <div class="aside" :class="{open:open,docked:docked}" @click.prevent="choose()">
                    <div class="container">
                        <form id="addcart">
                            <div class="choose" @click.stop="">
                                <div class="clearfix">
                                    <div class="pro-img">
                                        <img src="{{ fct_cdn('/images/resource/pro01.png') }}">
                                    </div>
                                    <div class="info">
                                        <span class="title">@{{ product.name }}</span>
                                        <span class="price"><small class="pri-mark">￥</small>@{{ showprice }}</span>
                                        <span class="stock">库存：@{{ calstock }}</span>
                                    </div>
                                </div>
                                <input id="pro_id" name="pro_id" type="hidden" :value="product.id">
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
                                            <input type="text" name="number" class="numbers" v-model="input_val">
                                            <a href="javascript:;" @click="add()" :class="{dis:max}">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                <div class="fork-container" @click="choose()">
                                    <a href="javascript:;" class="fork" >&nbsp;</a>
                                </div>

                            </div>

                            <ul class="nav">
                                <li class="message" @click="">
                                    <a href="javascript:;" class="foot-link">
                                        <img src="{{ fct_cdn('/images/msg.png') }}">
                                    </a>
                                </li>
                                <li class="cart">
                                    <a href="{{ url('carts') }}" class="foot-link">
                                        <img src="{{ fct_cdn('/images/cart.png') }}">
                                        <span class="nums" v-if="numsshow">@{{ cart_num }}</span>
                                    </a>
                                </li>
                                <li class="collection" :class="{red:collected}"  @click="collection()">
                                    <i class="fa fa-heart"></i>
                                </li>
                                <li class="add">
                                    <a href="javascript:;">
                                        <subpost :txt="subText" ref="subpost" @callback="buy(0)" @succhandle="succhandle"></subpost>
                                    </a>
                                </li>
                                <li class="buy">
                                    <a href="javascript:;" @click="buy(1)">立即购买</a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
                <ul class="nav">
                    <li class="message" @click="">
                        <a href="javascript:;" class="foot-link">
                            <img src="{{ fct_cdn('/images/msg.png') }}">
                        </a>
                    </li>
                    <li class="cart">
                        <a href="{{ url('carts') }}" class="foot-link">
                            <img src="{{ fct_cdn('/images/cart.png') }}">
                            <span class="nums" v-if="numsshow">@{{ cart_num }}</span>
                        </a>
                    </li>
                    <li class="collection" :class="{red:collected}"  @click="collection()">
                        <i class="fa fa-heart"></i>
                    </li>
                    <li class="add" :class="{ disabled: !product.hasCart }">
                        <a href="javascript:;" @click="choose(0)" v-if="product.hasCart">加入购物车</a>
                        <a href="javascript:;" v-else>加入购物车</a>
                    </li>
                    <li class="buy" :class="{ disabled: !product.hasBuy }">
                        <a href="javascript:;" @click="choose(1)" v-if="product.hasBuy">立即购买</a>
                        <a href="javascript:;" v-else>立即购买</a>
                    </li>
                </ul>
            </div>

        </footer>
    </div>

    <template id="m_video">
        <div class="m-video-container">
            <div class="video-inner">
                <div v-if="!isVideoLoad" class="play-container" @click="loadVideo()">
                    <img :src="poster" class="poster-img" />
                    <img src="{{ fct_cdn('/images/video_play.png') }}" class="poster-play" />
                </div>
                <video class="m-video" :src="url" :id="id" preload="metadata" controls v-else></video>
            </div>
        </div>
    </template>

    <script type="text/x-template" id="overview">
        <div class="overview-container">
            <section class="video-container">
                <mVideo :poster="product.video.poster" :url="product.video.url" id="videotop"></mVideo>
                <div class="sale clearfix" v-if="product.hasDiscount">
                    <div class="left">
                        <span class="title" v-if="product.discount && product.discount.canBuy">限时购</span>
                        <span class="title" v-else>秒杀</span>
                        &ensp;享<span class="discount-color">@{{ product.discount.discountRate * 10 }}折，限购@{{ product.discount.singleCount }}件</span>
                    </div>
                    <div class="right">
                        距<span v-if="product.discount.hasBegin"></span>结束<span v-else>开始</span>仅剩<m-time :endTime="product.discount.discountTime" :callback="end"></m-time>
                    </div>
                </div>
            </section>
            <section class="product-context">
                <strong class="title">@{{ product.name }}</strong>
                <div class="vice-title">@{{ product.subTitle }}</div>
                <div class="price">
                    <small class="pri-mark">￥</small>@{{ product.promotionPrice }}&ensp;<del class="del-price" v-if="product.hasDiscount">@{{ product.salePrice }}</del>
                </div>
                <div class="sale-info">
                    <img src="{{ fct_cdn('/images/items.png') }}">包邮&emsp;
                    <img src="{{ fct_cdn('/images/items.png') }}">保真保值&emsp;
                    <img src="{{ fct_cdn('/images/items.png') }}">30天无忧退换货
                </div>
                <div class="view">
                    <div class="inner">
                        <div class="num">@{{ product.viewCount }}</div>
                        <div>人围观</div>
                    </div>
                </div>
            </section>
            <section class="coupon" v-if="product.hasCoupon">
                <img src="{{ fct_cdn('/images/d_coup.png') }}">领取优惠券
                <div class="get-coupon">
                    <a :href="product.coupon_url" class="coup-link">领取</a>
                </div>
            </section>
            <section class="info clearfix">
                <div class="item">
                    <span class="left">艺人</span>
                    <span class="right">@{{ product.artistNames }}</span>
                </div>
                <div class="item">
                    <span class="left">泥料</span>
                    <span class="right">@{{ product.materialNames }}</span>
                </div>
                <div class="item">
                    <span class="left">壶型</span>
                    <span class="right">@{{ product.categoryNames }}</span>
                </div>
                <div class="item">
                    <span class="left">容量</span>
                    <span class="right">
          <span v-if="product.volumes instanceof Array">@{{ product.volumes[0] }}CC&nbsp;~&nbsp;@{{ product.volumes[1] }}CC</span>
          <span v-else>@{{ product.volumes }}CC</span>
        </span>
                </div>
                <div class="item">
                    <span class="left">库存</span>
                    <span class="right">@{{ calstock }}</span>
                </div>
                <div class="item">
                    <span class="left">编号</span>
                    <span class="right">@{{ product.code }}</span>
                </div>
            </section>
            <section class="edit-context" v-html="product.content">
                @{{ product.content }}
            </section>
        </div>
    </script>
    <script type="text/x-template" id="artist">
        <div class="artist-contianer">
            <img src="{{ fct_cdn('/images/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
            <no-data v-if="nodata"></no-data>
            <div class="top-container" v-if="titleshow">
                <div class="inner o">
                    <ul class="top-list">
                        <li v-for="(item, index) in artist" :class="{red:index===art_num}">
                            <a href="javascript:;" @click="loadsingle(index)">
                                <span class="img-container">
                                  <img :src="item.headPortrait">
                                </span>
                                <span class="name-container overText">@{{ item.name }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <section class="content" :class="{'top-max':!titleshow,'top-min':titleshow}">
                <div class="intro">
                      <span class="photo">
                          <img :src="artistsingle.image">
                      </span>
                    <span class="intro-info">
                      <span class="intro-name">@{{ artistsingle.name }}&nbsp;-&nbsp;<span class="v-title">@{{ artistsingle.title }}</span></span>
                      <span class="intro-content">@{{ artistsingle.intro }}</span>
                    </span>
                </div>
            </section>
            <section class="text-container" v-html="artistsingle.description"></section>
            <section class="comment" v-if="artistsingle.img && artistsingle.img.length > 0">
                <div class="lines">
                    <div class="text">相关宝贝</div>
                </div>
                <ul class="others">
                    <li v-for="p in artistsingle.products">
                        <a :href="'{{ url('products') }}/' + p.id" class="item">
                            <img v-view="p.defaultImage" src="{{ fct_cdn('/images/img_loader.gif') }}">
                            <span class="p-title">@{{ p.name }}</span>
                        </a>
                    </li>
                </ul>
                <a href="{{ url('/') }}" class="for-more">点击了解更多》</a>
            </section>

        </div>
    </script>
    <script type="text/x-template" id="pug">
        <div class="artist-contianer">
            <img src="{{ fct_cdn('/images/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
            <no-data v-if="nodata"></no-data>
            <div class="top-container" v-if="titleshow">
                <div class="inner o">
                    <ul class="top-list">
                        <li v-for="(item, index) in pugs" :class="{red:index===pug_num}">
                            <a href="javascript:;" @click="loadsingle(index)">
                                <span class="img-container">
                                  <img :src="item.headPortrait">
                                </span>
                                <span class="name-container overText">@{{ item.name }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <section class="content" :class="{'top-max':!titleshow,'top-min':titleshow}">
                <div class="intro">
                      <span class="photo">
                        <img :src="pugsingle.image">
                      </span>
                    <span class="intro-info">
          <span class="intro-name">@{{ pugsingle.name }}</span>
          <span class="intro-content">@{{ pugsingle.intro }}</span>
        </span>
                </div>
            </section>
            <section class="text-container" v-html="pugsingle.description"></section>
            <section class="comment" v-if="pugsingle.products && pugsingle.products.length > 0">
                <div class="lines">
                    <div class="text">相关宝贝</div>
                </div>
                <ul class="others">
                    <li v-for="p in pugsingle.products">
                        <a :href="'{{ url('products') }}/' + p.id" class="item">
                            <img v-view="p.defaultImage" src="{{ fct_cdn('/images/img_loader.gif') }}">
                            <span class="p-title">@{{ p.name }}</span>
                        </a>
                    </li>
                </ul>
            </section>
        </div>
    </script>
    <script type="text/x-template" id="service">
        <div>
            <no-data v-if="nodata"></no-data>
            <img src="public/images/img_loader_s.gif" class="list-loader" v-if="listloading">
            <section class="service" v-html="tab_service"></section>
        </div>
    </script>
    <script type="text/x-template" id="discuss">
        <section class="discuss">
            <ul class="list" v-load-more="nextPage" type="1" v-if="commentlist && commentlist.length > 0">
                <li class="item" v-for="(item, index) in commentlist">
                    <div class="user-info clearfix">
                        <div class="left clearfix">
                            <div class="user-photo">
                                <img v-view="item.headPortrait" src="{{ fct_cdn('/images/img_loader.gif') }}">
                            </div>
                            <div class="user-opt">
                                <div>@{{ item.userName }}</div>
                                <div class="stars">
                                    <i class="fa fa-star" v-for="m in item.descScore"></i><i class="fa fa-star-o" v-for="n in c_star(item.descScore)"></i>
                                </div>
                            </div>
                        </div>
                        <div class="right">@{{ item.createTime }}</div>
                    </div>
                    <div class="comments">
                        <span class="text" v-html="item.content"></span>
                        <span class="imgs">
                        <img v-img="{ group: item.id, exsrc: item.largePictures[index]}"
                             v-view="img_item" src="{{ fct_cdn('/images/img_loader.gif') }}"
                             v-for="(img_item, index) in item.pictures">
                      </span>
                    </div>
                </li>
            </ul>

            <no-data v-if="nodata"></no-data>
            <img src="{{ fct_cdn('/images/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        </section>
    </script>
@endsection
@section('javascript')
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
        config.tab_service = "<div class='title'>退换货政策</div><p>自您签收宝贝之日起10日内，方寸堂将为您办理退换货服务，且寄回宝贝实际运费由客户承担；如需办理退换货业务，请您致电客服热线400-0510-570咨询办理。</p><p>" +
            "<br>政策说明：<br><br>1、一张订单方寸堂只为您提供一次退换货服务，为了确保您的权益，请考虑周全后与我们联系。<br>2、请您确保退换货时，宝贝各种包装完整。<br>" +
            "3、因您个人原因造成的宝贝损坏（如壶身破损等），不予退换。<br>4、由于物品质量问题造成的退换货，由方寸堂承担双程运费。由于个人喜好原因造成退货，由客户支付双程邮费。感谢您的理解！<br>" +
            "5、退换货发生时，请您选择顺丰快递将宝贝寄回给我们。<br>6、礼包或超值组合装中的宝贝不可以选择部分退换货，因退货后，原礼包或套装中宝贝将无法享受购买时优惠。<br>" +
            "7、图片及信息仅供参照，因拍摄灯光及不同显示器色差等问题可能造成宝贝图片与实物有一定色差，一切以实物为准。色差问题不在退换货服务行列。" +
            "</p><div class='title'>拒收政策</div><p>在您签收宝贝前，请先核查宝贝外包装是否完好，并确认您对宝贝是否满意。</p><p>1、无专用封箱胶<br>" +
            "在收取快递包时，若发现外包装中无“方寸堂”专用封箱胶，或“方寸堂”专用封箱胶被严重损坏(特别是有被重新封装的痕迹)，您可以拒收。<br>" +
            "2、物品与所购不符<br>签收后，若包装完好但是包裹中的宝贝数量与您实际购买的宝贝不吻合时，或所接收的物品与您所购的物品不相符时，请先与快递人员确认，现场拍照；并及时联系我们的客服，我们在与快递公司确认后，将及时为您补发/换发所缺宝贝。<br>" +
            "3、对宝贝（或部分）不满意<br>若您对某件或某几件宝贝的质量不满意，您在拒收这些宝贝的同时，可正常接收其它宝贝，对于其它不满意的宝贝可根据您的意愿联系“方寸堂”的客服为您换货或退款。<br></p>";
    </script>

    <script src="{{ fct_cdn('/js/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/hammer.js') }}"></script>
    <script src="{{ fct_cdn('/js/detail.js') }}"></script>
    {!! wechat_share($share) !!}
    <script>
        var _mtac = {};
        (function() {
            var mta = document.createElement("script");
            mta.src = "http://pingjs.qq.com/h5/stats.js?v2.0.2";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500500357");
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        })();
    </script>
@endsection