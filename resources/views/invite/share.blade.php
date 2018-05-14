@extends("layout")
@section('content')
    <div class="invite-container" id="invite" v-cloak>
        <div class="result-container" id="con_result">
            <div class="btn" id="btn" >
                <div class="inner">
                    <a href="javascript:;" @click="pop" class="save">保存图片</a>
                </div>
            </div>
        </div>
        <pop v-if="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.user = {!! json_encode($user, JSON_UNESCAPED_UNICODE) !!}
        config.qrcodeUrl = {!! json_encode($qrcodeUrl, JSON_UNESCAPED_UNICODE) !!};
        config.backgroundUrl = {!! json_encode($backgroundUrl, JSON_UNESCAPED_UNICODE) !!};
        config.logoUrl = {!! json_encode($logoUrl, JSON_UNESCAPED_UNICODE) !!};
        config.textObj = {
                "textInfo": "，领取了方寸堂200元，特来邀请您一起拿紫砂壶",
                "textQrcode": "长按识别二维码获取红包",
                "textTip": "活动提示",
                "textLine1": "仅限于使用手机号注册并通过微信授权的用户有效",
                "textLine2": "严禁恶意刷金，一经发现将取消相关奖励",
                "textM": "·"
        };
        config.msg = "保存分享图片";
    </script>
    <script src="{{ fct_cdn('/js/mobile/canvas2image.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/invite.js') }}"></script>
@endsection