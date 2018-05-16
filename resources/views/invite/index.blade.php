@extends("layout")
@section('content')
    <div class="invitelist-container" id="invitelist" v-cloak>
        <section class="banner-container">
            <img src="{{ fct_cdn('/img/mobile/invite_list.png') }}" class="banner">
            <div class="tip-container">
                <div class="inner">
                    <m-swipe swipeid="swipe" ref="banner" direction="vertical" :autoplay="5000">
                        <div v-for="(top, index) in tips" class="swiper-slide swiper-no-swiping" slot="swiper-con">
                            <div class="content">
                                <img src="{{ fct_cdn('/img/mobile/tips_i.png') }}"><span>@{{ top.cellPhone }}获得了@{{ top.giftAmount }}元红包&ensp;@{{ top.createTime }}</span>
                            </div>
                        </div>
                    </m-swipe>
                </div>
            </div>
        </section>
        <section class="content-container">
            <div class="list-container" v-if="isLogin">
                <div class="title">
                    <div class="inner">我的邀请列表</div>
                </div>
                <div class="items-title">
                    <div class="c">邀请好友</div>
                    <div class="c">注册时间</div>
                    <div class="c">奖励</div>
                </div>
                <ul class="list">
                    <li class="items" v-for="(item, index) in invitelist">
                        <div class="c">@{{ item.cellPhone }}</div>
                        <div class="c">@{{ item.createTime }}</div>
                        <div class="c " :class="{red: item.status===1, gray: item.status===0}">@{{ item.statusName }}</div>
                    </li>
                </ul>
            </div>
            <div class="list-container">
                <div class="title">
                    <div class="inner">活动规则</div>
                </div>
                <div class="rule">
                    <dl class="rule-list clearfix">
                        <dt class="no">1.</dt>
                        <dd class="con">新客注册：使用手机号码注册即可获取188元新人礼金；</dd>
                        <dt class="no">2.</dt>
                        <dd class="con">邀请好友：每邀请1位新用户成功注册的，即可获赠20元奖励金；</dd>
                        <dt class="no">3.</dt>
                        <dd class="con">奖励金额每天最高可得200元，邀请人数超过10人亦以10人计；</dd>
                        <dt class="no">4.</dt>
                        <dd class="con">奖励金额不可提现，仅可用作平台正品购买之用，奖励金额永久有效；</dd>
                        <dt class="no">5.</dt>
                        <dd class="con">奖励对象：仅限于使用手机号码注册并通过微信授权的用户有效。</dd>
                    </dl>
                    <div class="tips">
                        <div class="t">提示</div>
                        <p class="l">严禁恶意刷金，一经发现将取消相关奖励；</p>
                        <p class="l">本公司对以上活动细则保留最终解释权。</p>
                    </div>

                </div>
            </div>
            <div class="btn-container">
                <a href="{{ url(\App\FctCommon::hasWeChat() ? 'oauth' : 'login', [], env('APP_SECURE')) }}" class="btn">注册领红包</a>
            </div>
        </section>

    </div>
@endsection
@section('javascript')
    <script type="text/x-template" id="m_swipe">
        <div class="swiper-container" :class="swipeid">
            <div class="swiper-wrapper">
                <slot name="swiper-con"></slot>
            </div>
            <!-- 分页器 -->
            <div :class="{'swiper-pagination':pagination}"></div>
        </div>
    </script>
    <script>
        config.tips = {!! json_encode($entity->tops, JSON_UNESCAPED_UNICODE) !!};
        config.invitelist = {!! json_encode($entity->invites, JSON_UNESCAPED_UNICODE) !!};
        config.isLogin = {!! $hasLogin !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/invite_list.js') }}"></script>
@endsection