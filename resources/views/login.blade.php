@extends("layout")

@section("title", $title)
@section('content')
    <div class="login-container" id="login">
        <div class="logo"></div>
        <form id="userLogin" action="{{ url('login') }}" method="post">
            <ul class="form-data">
                <li class="items clearfix">
                    <div class="left">账号</div>
                    <div class="right">
                        <input type="tel" name="cellphone" class=""
                               placeholder="请输入手机号码" v-model.number="phoneNumber"/>
                    </div>
                </li>
                <li class="items clearfix">
                    <div class="left">密码</div>
                    <div class="right">
                        <input type="password" name="password" class="val-code"
                               placeholder="请输入登录密码" v-model="passWord"/>
                    </div>
                </li>
            </ul>
            <div class="log-btn">
                <div class="sub" @click="mobileLogin">登录</div>
            </div>
            <div class="options">
                <a href="javascript:;">忘记密码？</a>
                <a href="quicklogin.html">手机号快捷登录</a>
            </div>
        </form>
        <div class="others">
            <a href="javascript:;">
                <img src="images/qq.png">
            </a>
            <a href="javascript:;">
                <img src="images/weibo.png">
            </a>
        </div>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>

    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <!-- <div class="tip_icon">
                   <span></span>
                   <span></span>
                 </div>-->
                <p class="tip_text">@{{ msg }}</p>
                <div class="confrim" @click="close">确认</div>
            </section>
        </div>
    </template>
@endsection