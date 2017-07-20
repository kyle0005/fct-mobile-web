@extends("layout")
@section("title", $title)
@section('content')
    <div class="user-container" id="user" v-cloak>
        <head-top></head-top>
        <section class="banner">
            <img src="/images/resource/banner.png" class="banner-img">
            <a href="userinfo.html" class="banner-link">
          <span class="photo-container">
            <img :src="user.headPortrait">
          </span>
                <span class="info-container">
            <span class="name">@{{ user.userName }}</span>
            <span class="rank">普通用户</span>
          </span>
            </a>
        </section>
        <section class="user-sec">
            <a href="javascript:;" class="order">
                <span>我的订单</span>
                <span class="wei-arrow-right"></span>
            </a>
            <ul class="list">
                <li>
                    <a href="javascript:;" class="link">
                        <img src="/images/user_payment_pending.png"><br>
                        <span>待付款</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
                        <img src="/images/user_shipment_pending.png"><br>
                        <span>待发货</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
                        <img src="/images/user_shipped.png"><br>
                        <span>已发货</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
                        <img src="/images/user_evaluation_pending.png"><br>
                        <span>待评价</span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
                        <img src="/images/user_aftersale.png"><br>
                        <span>售后服务</span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="user-sec">
            <ul class="funcs-list">
                <li>
                    <a href="javascript:;" class="link">
              <span class="img-container item">
                <img src="/images/u_money.png">
              </span>
                        <span class="item t">我的钱包</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
              <span class="img-container item">
                <img src="/images/u_coupon.png">
              </span>
                        <span class="item t">优惠券</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
              <span class="img-container item">
              <img src="/images/u_fav.png">
              </span>
                        <span class="item t">我的收藏</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
              <span class="img-container item">
              <img src="/images/u_address.png">
              </span>
                        <span class="item t">地址管理</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="user-sec">
            <ul class="funcs-list">
                <li>
                    <a href="javascript:;" class="link">
              <span class="img-container item">
              <img src="/images/u_chat.png">
              </span>
                        <span class="item t">在线客服</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
              <span class="img-container item">
              <img src="/images/u_help.png">
              </span>
                        <span class="item t">帮助中心</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
                <li>
                    <a href="javascript:;" class="link">
              <span class="img-container item">
              <img src="/images/u_share.png">
              </span>
                        <span class="item t">分享给朋友，一起赚钱！</span>
                        <span class="wei-arrow-right"></span>
                    </a>
                </li>
            </ul>
        </section>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
                <!--<div class="confrim" @click="close">确认</div>-->
            </section>
        </div>
    </template>
@endsection
@section('javascript')
    <script src="/js/api/index.js"></script>
    <script src="/js/head.js"></script>
    <script>
        var config = {
            "index": "{{ url('/') }}",
            "login": "{{ url('my') }}",
            "productsType": {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!},
            "user":{!! json_encode($member, JSON_UNESCAPED_UNICODE) !!}
        }
    </script>
    <script src="/js/usercenter.js"></script>
@endsection