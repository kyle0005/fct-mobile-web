@extends("layout")


@section('content')
    <div class="login-container" id="login" v-cloak>
        <div class="logo"></div>
        <form id="quickLogin">
            <input type="hidden" name="openid" :value="openid">
            <ul class="form-data">
                <li class="items clearfix">
                    <div class="left"><i class="fa fa-mobile"></i></div>
                    <div class="right">
                        <input name="cellphone" type="text" class="q" placeholder="请输入绑定手机号码" v-model.number="phoneNumber"/>
                        <div class="code-container">
                            <a @click.prevent="getVerifyCode"
                               class="get-code" :class="{right_phone_number:rightPhoneNumber}"
                               v-show="!computedTime">获取验证码</a>
                            <a class="get-code" @click.prevent v-show="computedTime">已发送(@{{computedTime}}s)</a>
                        </div>
                    </div>
                </li>
                <li class="items clearfix">
                    <div class="left"><img src="/images/valicode.png"></div>
                    <div class="right">
                        <input name="captcha" type="text" class="val-code" placeholder="请输入验证码"
                               maxlength="6" v-model="mobileCode">
                    </div>
                </li>
            </ul>
            <div class="log-btn">
                <div class="sub" @click="mobileMsgLogin()">绑定</div>
            </div>
        </form>
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
    <script>
        config.openid = "{{ $openid }}";
        var apis = {
            "bindUrl": "{{ url('oauth/bind') }}",
            "smsUrl": "{{ url('send-captcha') }}"
        };
    </script>
    <script src="/js/bind.js"></script>
@endsection