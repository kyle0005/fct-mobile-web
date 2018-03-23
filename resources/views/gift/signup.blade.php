@extends("layout")
@section('content')
    <div class="gift-container" id="gift" v-cloak>
        <img src="{{ fct_cdn('/img/mobile/gift_bg.png') }}" class="bg">
        <div class="content">
            <div class="title">活动规则</div>
            <div class="text">
                1、新客注册：点击下方注册领红包，使用手机注册即可获取188元账户余额<br>
                2、推荐好友：点击下方推荐好友，成功使用手机注册即可再获得30元账户余额（可积累）<br>
                3、活动时间：至2018年6月6日结束
            </div>
            <a href="javascript:;" class="btn" v-if="isLogin" @click="share()">推荐领红包</a>
            <a href="{{ url('/', [], env('APP_SECURE')) }}" class="btn" v-else=>注册领红包</a>
        </div>
        <div class="share-pop" v-if="showPop">
            <img src="{{ fct_cdn('/img/mobile/share_gift.png') }}" class="share-icon">
            <div class="text">点击右上角分享到朋友圈</div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        config.isLogin = {!! $hasLogin !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/main_gift.js') }}"></script>
    {!! wechat_share($share) !!}
@endsection