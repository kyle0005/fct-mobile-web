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
        <a href="javascript:;" class="top">
            <img src="public/images/top.png">
        </a>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <footer class="foot-container">
            <div class="aside" :class="{open:open,docked:docked}" @click.prevent="choose()">
                <div class="container">
                    <div class="choose" @click.stop="">
                        <div class="clearfix">
                            <div class="pro-img">
                                <img src="public/images/resource/pro01.png">
                            </div>
                            <div class="info">
                                <span class="title">稀有黄金段（石瓢）</span>
                                <span class="price">￥33300000</span>
                                <span class="stock">库存:有货</span>
                            </div>
                        </div>
                        <ul class="spec">
                            <li class="item" v-for="(item, index) in specs" :class="{active: index===specs_num}" @click="footLinkTo(index)">
                                @{{ item }}
                            </li>
                        </ul>
                        <div class="num">
                            <div class="item"><span class="name">数量</span></div>
                            <div class="item">
                                <a href="javascript:;" :class="{dis:min}" @click="minus()">
                                    <i class="fa fa-minus"></i>
                                </a>
                                <input type="text" class="numbers" v-model="input_val">
                                <a href="javascript:;" @click="add()">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        <a href="javascript:;" class="fork" @click="choose()">&nbsp;</a>
                    </div>
                    <a href="javascript:;" class="sub" @click="buy()">确定</a>
                </div>
            </div>
            <ul class="nav">
                <li class="collection" :class="{red:collected}"  @click="collection()">
                    <i class="fa fa-heart"></i>
                </li>
                <li class="message" @click="">
                    <i class="fa fa-commenting"></i>
                </li>
                <li class="cart" @click="choose()">
                    <i class="fa fa-shopping-cart"></i>
                </li>
                <li class="buy">
                    <a href="javascript:;" @click="choose()">立即购买</a>
                </li>
            </ul>
        </footer>
    </div>
    <script src="public/scripts/vue.js"></script>
    <script src="public/scripts/api/index.js"></script>
    <script type="text/x-template" id="head_top">
        <header class="head-container">
            <ul class="nav">
                <li class="toggle" @click="toggle()">
                    <i class="fa fa-bars"></i>
                </li>
                <li class="logo" @click="toIndex()">
                    <img :src="img_url + '/logo.png'">
                </li>
                <li class="user" @click="toLogin()">
                    <i class="fa fa-user-circle-o"></i>
                </li>
            </ul>
            <div class="aside" :class="{open:open,docked:docked}" @click="toggle()">
                <div class="container">
                    <ul class="types">
                        <li class="item" v-for="(types, index) in typeList" @click="change(index)">
                            <span>@{{ types }}</span>
                            <i class="fa fa-angle-right"></i>
                        </li>
                    </ul>
                    <ul class="lines clearfix">
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu1.png'">
                                <span>合作艺师</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu2.png'">
                                <span>百科</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu3.png'">
                                <span>个性定制</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu4.png'">
                                <span>APP下载</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu5.png'">
                                <span>品牌理念</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    </script>
    <script type="text/x-template" id="overview">
        <div>
            <section class="video-container">
                <video id="my-player" class="video-js" controls preload="auto"
                       poster="//vjs.zencdn.net/v/oceans.png">
                    <source src="//vjs.zencdn.net/v/oceans.mp4" type="video/mp4"></source>
                    <source src="//vjs.zencdn.net/v/oceans.webm" type="video/webm"></source>
                    <source src="//vjs.zencdn.net/v/oceans.ogv" type="video/ogg"></source>
                </video>
            </section>
            <section class="product-context">
                <div class="title">稀有xx段【x瓢】</div>
                <div class="vice-title">登堂入室，泰斗顾景舟</div>
                <div class="price">￥9900000.00</div>
            </section>
            <section class="info">
                <div class="item">
                    <span class="left">优惠</span>
                    <span class="right">首单优惠活动</span>
                </div>
                <div class="item">
                    <span class="left">服务</span>
                    <span class="right">&bull;&nbsp;顺丰包邮&nbsp;&bull;&nbsp;30天无忧退货&nbsp;&bull;&nbsp;48小时快速退货</span>
                </div>
                <div class="item">
                    <span class="left">库存</span>
                    <span class="right">有货</span>
                </div>
                <div class="coupon">
                    <a href="javascript:;" class="get-coupon">领取优惠券</a>
                </div>
            </section>
            <section class="edit-context">
                <p>xxxxxxxxxxxxxxxxxxxxxxxxxxx<br>xxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                <img src="public/images/resource/pro.png">
                <p>xxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                <img src="public/images/resource/pro.png">
                <p>xxxxxxxxxxxxxxxxxxxxxxxxxxx</p>
                <img src="public/images/resource/pro.png">
            </section>
        </div>
    </script>
    <script type="text/x-template" id="artist">
        <div>
            <section class="artist">
                <div class="intro">
          <span class="photo">
            <img src="public/images/resource/artist.png">
          </span>
                    <span class="artist-info">
            <span class="artist-name">顾景舟&nbsp;GU&nbsp;JING&nbsp;ZHOU</span><br>
            <span>宜兴紫砂壶名艺xxx<br>中国美术协会会员<br>中国工艺美术大师</span>
          </span>
                </div>
                <div class="">
                    顾景舟，（1915-1966），原名景洲。18岁拜名师学艺xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                </div>
            </section>
            <section class="record">
                <div class="title">成交记录</div>
                <div class="list">
                    <span>xxxx壶拍卖 成交价1234万</span>
                    <span>xxxx壶拍卖 成交价1234万</span>
                    <span>xxxx壶拍卖 成交价1234万</span>
                </div>
            </section>
            <section class="comment">
                <div class="title">社会评价</div>
                <p class="context">
                    xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                </p>
                <ul class="others">
                    <li>
                        <a href="javascript:;" class="item">
                            <img src="public/images/resource/pro01.png">
                            <span class="p-title">xx瓢</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="item">
                            <img src="public/images/resource/pro02.png">
                            <span class="p-title">xx壶</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="item">
                            <img src="public/images/resource/pro03.png">
                            <span class="p-title">xx壶</span>
                        </a>
                    </li>
                </ul>
                <a href="javascript:;" class="for-more">点击了解更多》</a>
            </section>
        </div>
    </script>
    <script type="text/x-template" id="pug">
        <div>
            <section class="pug-container">
                <div class="intro">
          <span class="photo">
            <img src="public/images/resource/pug.png">
          </span>
                    <span class="pug">
            <span class="pug-name">原矿xxx朱泥</span><br>
            <span class="pug-detail">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</span>
          </span>
                </div>
            </section>
            <section class="spec">
                <div class="title">规格特性</div>
                <div class="details">
                    <div>窑温：约1080度</div>
                    <div>收缩：30%左右</div>
                    <div>矿产地：江苏宜兴</div>
                    <div>泥性：</div>
                    <div>难度：</div>
                    <div>xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</div>
                </div>
                <ul class="others">
                    <li>
                        <a href="javascript:;" class="item">
                            <img src="public/images/resource/pro01.png">
                            <span class="p-title">xx瓢</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="item">
                            <img src="public/images/resource/pro02.png">
                            <span class="p-title">xx壶</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="item">
                            <img src="public/images/resource/pro03.png">
                            <span class="p-title">xx壶</span>
                        </a>
                    </li>
                </ul>
            </section>
        </div>
    </script>
    <script type="text/x-template" id="service">
        <section class="service">
            <div class="title">退换货政策</div>
            <p>自您签收商品之日起10日内，淘壶人将为您办理退换货服务，且寄回商品实际运费由客户承担；如需办理退换货业务，请您致电客服热线400-0510-570咨询办理。</p>
            <p>
                <br>政策说明：<br><br>
                1、一张订单淘壶人只为您提供一次退换货服务，为了确保您的权益，请考虑周全后与我们联系。<br>
                2、请您确保退换货时，商品各种包装完整。<br>
                3、因您个人原因造成的商品损坏（如壶身破损等），不予退换。<br>
                4、由于物品质量问题造成的退换货，由淘壶人承担双程运费。由于个人喜好原因造成退货，由客户支付双程邮费。感谢您的理解！<br>
                5、退换货发生时，请您选择顺丰快递将商品寄回给我们。<br>
                6、礼包或超值组合装中的商品不可以选择部分退换货，因退货后，原礼包或套装中商品将无法享受购买时优惠。<br>
                7、图片及信息仅供参照，因拍摄灯光及不同显示器色差等问题可能造成商品图片与实物有一定色差，一切以实物为准。色差问题不在退换货服务行列。
            </p>
            <div class="title">拒收政策</div>
            <p>在您签收商品前，请先核查商品外包装是否完好，并确认您对产品是否满意。</p>
            <p>
                1、无专用封箱胶<br>
                在收取快递包时，若发现外包装中无“淘壶人”专用封箱胶，或“淘壶人”专用封箱胶被严重损坏(特别是有被重新封装的痕迹)，您可以拒收。<br>
                2、物品与所购不符<br>
                签收后，若包装完好但是包裹中的商品数量与您实际购买的商品不吻合时，或所接收的物品与您所购的物品不相符时，请先与快递人员确认，现场拍照；并及时联系我们的客服，我们在与快递公司确认后，将及时为您补发/换发所缺商品。<br>
                3、对产品（或部分）不满意<br>
                若您对某件或某几件商品的质量不满意，您在拒收这些商品的同时，可正常接收其它商品，对于其它不满意的商品可根据您的意愿联系“淘壶人”的客服为您换货或退款。<br>

            </p>
        </section>
    </script>
    <script type="text/x-template" id="discuss">
        <section class="discuss">
            <ul class="list">
                <li class="item">
                    <div class="user-info clearfix">
                        <div class="left clearfix">
                            <div class="user-photo">
                                <img src="public/images/resource/artist.png">
                            </div>
                            <div class="user-opt">
                                <div>用户名</div>
                                <div class="stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="right">2017-06-06</div>
                    </div>
                    <div class="comments">
                        <span class="text">评论评论评论评论评论评论ffffffffffffffffff评论评论评论评论.....................</span>
                        <span class="imgs">
                <img src="public/images/resource/pro01.png">
                <img src="public/images/resource/pro01.png">
                <img src="public/images/resource/pro01.png">
              </span>
                    </div>
                </li>
                <li class="item">
                    <div class="user-info clearfix">
                        <div class="left clearfix">
                            <div class="user-photo">
                                <img src="public/images/resource/artist.png">
                            </div>
                            <div class="user-opt">
                                <div>用户名</div>
                                <div class="stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="right">2017-06-06</div>
                    </div>
                    <div class="comments">
                        <span class="text">评论评论评论评论评论评论ffffffffffffffffff评论评论评论评论.....................</span>
                        <span class="imgs">
                <img src="public/images/resource/pro01.png">
                <img src="public/images/resource/pro01.png">
                <img src="public/images/resource/pro01.png">
              </span>
                    </div>
                </li>
                <li class="item">
                    <div class="user-info clearfix">
                        <div class="left clearfix">
                            <div class="user-photo">
                                <img src="public/images/resource/artist.png">
                            </div>
                            <div class="user-opt">
                                <div>用户名</div>
                                <div class="stars">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star-o"></i>
                                </div>
                            </div>
                        </div>
                        <div class="right">2017-06-06</div>
                    </div>
                    <div class="comments">
                        <span class="text">评论评论评论评论评论评论ffffffffffffffffff评论评论评论评论.....................</span>
                        <span class="imgs">
                <img src="public/images/resource/pro01.png">
                <img src="public/images/resource/pro01.png">
                <img src="public/images/resource/pro01.png">
              </span>
                    </div>
                </li>
            </ul>
        </section>
    </script>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <p class="tip_text">@{{ msg }}</p>
                <div class="confrim" @click="close">确认</div>
            </section>
        </div>
    </template>
@endsection
@section('javascript')
@endsection