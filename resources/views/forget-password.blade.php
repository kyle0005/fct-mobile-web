@extends("layout")
@section('content')
    <div class="login-container" id="findpwd" v-cloak>
        <div class="logo"></div>
        <form id="find">
            <ul class="form-data">
                <li class="items clearfix">
                    <div class="left"><i class="fa fa-mobile"></i></div>
                    <div class="right">
                        <input type="text" name="cellphone" class="q" placeholder="请输入手机号码" v-model.number="phoneNumber"/>
                        <div class="code-container">
                            <a name="captcha" @click.prevent="getVerifyCode"
                               class="get-code" :class="{right_phone_number:rightPhoneNumber}" v-show="!computedTime">获取验证码</a>
                            <a class="get-code" @click.prevent v-show="computedTime">已发送(@{{computedTime}}s)</a>
                        </div>
                    </div>
                </li>
                <li class="items clearfix">
                    <div class="left"><img src="{{ fct_cdn('/images/valicode.png') }}"></div>
                    <div class="right">
                        <input type="text" class="val-code" placeholder="请输入验证码" name="mobileCode"
                               maxlength="6" v-model="mobileCode">
                    </div>
                </li>
                <li class="items clearfix">
                    <div class="left">
                        <i class="fa fa-lock"></i>
                    </div>
                    <div class="right">
                        <input type="password" name="password" class="val-code"
                               placeholder="请输入新密码" v-model="passWord"/>
                    </div>
                </li>
            </ul>
            <div class="log-btn">
                <div class="sub">
                    <subpost :txt="subText" ref="subpost" @callback="update" @succhandle="succhandle"></subpost>
                </div>
            </div>
        </form>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
    var apis = {
        userResource:"{{ url('forget-password')  }}",
        mobileCodeResource:"{{ url('send-captcha') }}"
    };
    </script>
    <script src="{{ fct_cdn('js/findpwd.js') }}"></script>
@endsection