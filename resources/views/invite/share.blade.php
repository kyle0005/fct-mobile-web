@extends("layout")
@section('content')
    <div class="invite-container" id="invite" v-cloak>
        <div class="result-container" id="con_result"></div>
    </div>
@endsection
@section('javascript')
    <script src="{{ fct_cdn('/js/mobile/canvas2image.js') }}"></script>
    <script>
        config.user = {!! json_encode($user, JSON_UNESCAPED_UNICODE) !!},
        config.qrcodeUrl = {!! $qrcodeUrl !!},
        config.backgroundUrl = {!! $backgroundUrl !!},
        config.logoUrl = {!! $logoUrl !!},
        config.textObj = {
                "textInfo": "，领取了方寸堂200元，特来邀请您一起拿红包",
                "textQrcode": "长按识别二维码获取奖金",
                "textTip": "活动提示",
                "textLine1": "仅限于使用手机号注册并通过微信授权的用户有效",
                "textLine2": "严禁恶意刷金，一经发现将取消相关奖励",
                "textM": "·"
            }

        }
    </script>
    <script src="{{ fct_cdn('/js/mobile/invite.js') }}"></script>
@endsection