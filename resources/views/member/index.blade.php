@extends("layout")
@section('content')
    <div class="user-container" id="user" v-cloak>
        <section class="banner">
            <img src="{{ fct_cdn('/img/mobile/resource/banner.png') }}" class="banner-img">
            <a href="{{ "my/profile" }}" class="banner-link">
          <span class="photo-container">
            <img :src="user.headPortrait">
          </span>
            <span class="info-container">
            <span class="name">@{{ user.userName }}</span>
            <span class="rank">普通用户</span>
          </span>
            </a>
            <a href="{{ url('my/share', [], env('APP_SECURE')) }}" class="u-shop" v-if="user.shopId > 0">
                <img src="{{ fct_cdn('/img/mobile/u_shop.png') }}">
            </a>
        </section>
        <section class="user-sec">
            <a href="{{ url("my/orders", [], env('APP_SECURE')) }}?status=-1" class="order">
                <span>我的订单</span>
                <span class="wei-arrow-right"></span>
            </a>
            <ul class="list">
                <li>
                    <a href="{{ url("my/orders", [], env('APP_SECURE')) }}?status=0" class="link">
                        <img src="{{ fct_cdn('/img/mobile/user_payment_pending.png') }}"><br>
                        <span>待付款</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("my/orders", [], env('APP_SECURE')) }}?status=1" class="link">
                        <img src="{{ fct_cdn('/img/mobile/user_shipment_pending.png') }}"><br>
                        <span>待发货</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("my/orders", [], env('APP_SECURE')) }}?status=2" class="link">
                        <img src="{{ fct_cdn('/img/mobile/user_shipped.png') }}"><br>
                        <span>已发货</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("my/orders", [], env('APP_SECURE')) }}?status=3&comment_status=0" class="link">
                        <img src="{{ fct_cdn('/img/mobile/user_evaluation_pending.png') }}"><br>
                        <span>待评价</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("my/refunds", [], env('APP_SECURE')) }}" class="link">
                        <img src="{{ fct_cdn('/img/mobile/user_aftersale.png') }}"><br>
                        <span>售后服务</span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="user-sec">
            <ul class="list auction">
                <li>
                    <a href="{{ url("my/auction/signup", [], env('APP_SECURE')) }}" class="link">
                        <img class='bracket' src="{{ fct_cdn('/img/mobile/auction/my/bracket.png') }}">
                        <img src="{{ fct_cdn('/img/mobile/auction/my/hammer.png') }}"><br>
                        <span class="my">我的拍卖</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("my/auction/signup", [], env('APP_SECURE')) }}?status=1" class="link">
                        <img src="{{ fct_cdn('/img/mobile/auction/my/pm-success.png') }}"><br>
                        <span>拍卖中</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("my/auction/signup", [], env('APP_SECURE')) }}?status=3" class="link">
                        <img src="{{ fct_cdn('/img/mobile/auction/my/bm-waitpay.png') }}"><br>
                        <span>竞拍成功</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url("my/auction/order", [], env('APP_SECURE')) }}" class="link">
                        <img src="{{ fct_cdn('/img/mobile/auction/my/order.png') }}"><br>
                        <span>拍卖订单</span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="user-sec">
            <ul class="funcs-list">
                <li>
                    <a href="{{ url('my/account', [], env('APP_SECURE')) }}" class="link">
                      <span class="img-container item">
                        <img src="{{ fct_cdn('/img/mobile/u_money.png') }}">
                      </span>
                    <span class="item t">我的钱包</span>
                    <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('my/coupons', [], env('APP_SECURE')) }}" class="link">
                      <span class="img-container item">
                        <img src="{{ fct_cdn('/img/mobile/u_coupon.png') }}">
                      </span>
                        <span class="item t">优惠券</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('my/favorites', [], env('APP_SECURE')) }}?from_type=0" class="link">
                      <span class="img-container item">
                      <img src="{{ fct_cdn('/img/mobile/u_fav.png') }}">
                      </span>
                        <span class="item t">我的收藏</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('my/address', [], env('APP_SECURE')) }}" class="link">
              <span class="img-container item">
              <img src="{{ fct_cdn('/img/mobile/u_address.png') }}">
              </span>
                        <span class="item t">地址管理</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li v-if="user.allianceId > 0">
                    <a href="{{ url('my/alliance', [], env('APP_SECURE')) }}" class="link">
                      <span class="img-container item">
                      <img src="{{ fct_cdn('/img/mobile/alliance.png') }}">
                      </span>
                        <span class="item t">我的联盟</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="user-sec last">
            <ul class="funcs-list">
                <li>
                    <a href="{!! api_chat_url(url('my', [], env('APP_SECURE')), '用户中心') !!}" class="link">
                      <span class="img-container item">
                      <img src="{{ fct_cdn('/img/mobile/u_chat.png') }}">
                      </span>
                        <span class="item t">在线客服</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('help', [], env('APP_SECURE')) }}" class="link">
                          <span class="img-container item">
                          <img src="{{ fct_cdn('/img/mobile/u_help.png') }}">
                          </span>
                        <span class="item t">帮助中心</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li v-if="user.shopId > 0">
                    <a href="{{ url('my/share', [], env('APP_SECURE')) }}" class="link">
                      <span class="img-container item">
                      <img src="{{ fct_cdn('/img/mobile/u_share.png') }}">
                      </span>
                        <span class="item t">分享给朋友，一起赚钱！</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="log-sec">
            <a href="{{ url('logout', [], env('APP_SECURE')) }}" class="logout">退出登录</a>
        </section>

        <footer class="footer">
            <div class="inner">
                <a href="{{ url('/', [], env('APP_SECURE')) }}" class="link">
                    <img src="{{ fct_cdn('/img/mobile/i_home_g.png') }}"><br>首页
                </a>
                <a href="{!! api_chat_url(url('/', [], env('APP_SECURE')), '首页') !!}" class="link">
                    <img src="{{ fct_cdn('/img/mobile/i_service_g.png') }}"><br>客服
                </a>
                <a href="{{ url('my', [], env('APP_SECURE')) }}" class="link">
                    <img src="{{ fct_cdn('/img/mobile/i_account_d.png') }}"><br>我的
                </a>
            </div>
        </footer>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.user = {!! json_encode($user, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/usercenter.js') }}"></script>
@endsection