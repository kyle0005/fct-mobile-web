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
                            <a name="" @click.prevent="getVerifyCode" class="get-code" :class="{right_phone_number:rightPhoneNumber}" v-show="!computedTime">
                                <subpost :txt="'获取验证码'" :status="false" ref="coderef" @callback="getVerifyCode" @before="postBefore"
                                         @success="postSuc" @error="postError" @alert="postTip"></subpost>
                            </a>
                            <a class="get-code" v-show="computedTime">已发送(@{{computedTime}}s)</a>
                        </div>
                    </div>
                </li>
                <li class="items clearfix">
                    <div class="left"><img src="{{ fct_cdn('/img/mobile/valicode.png') }}"></div>
                    <div class="right">
                        <input name="captcha" type="text" class="val-code" placeholder="请输入验证码"
                               maxlength="6" v-model="mobileCode">
                    </div>
                </li>
            </ul>
            <div class="log-btn">
                <div class="sub">
                    <subpost :txt="'绑定'" :status="true" ref="subpost" @callback="mobileMsgLogin" @before="postBefore"
                             @success="postSuc" @error="postError" @alert="postTip"></subpost>
                </div>
            </div>
        </form>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.openid = "{{ $openid }}";
        var apis = {
            "bindUrl": "{{ url('oauth/bind', [], env('APP_SECURE')) }}",
            "smsUrl": "{{ url('send-captcha', [], env('APP_SECURE')) }}"
        };
    </script>
    <script src="{{ fct_cdn('/js/mobile/bind.js') }}"></script>
@endsection