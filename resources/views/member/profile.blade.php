@extends("layout")
@section("title", $title)
@section('content')
    <div class="userinfo-container" id="userinfo" v-cloak>
        <section class="photo-container">
            <div class="link">
              <span class="photo">
                <img :src="userinfo.emptyPhoto" v-if="userinfo.headPortrait == ''">
                <img :src="userinfo.headPortrait" v-else>
              </span>
                点击修改头像
            </div>
            <input type="file" class="upload" @change="fileChange">
        </section>
        <form id="userForm">
            <input type="hidden" name="flie" :value="uploadImg.url">
            <section class="list-container">
                <div class="line">
                    <div class="left">用户ID</div>
                    <div class="right">
                        <input type="text" class="right-inp" :value="userinfo.memberId" readonly>
                    </div>
                </div>
                <div class="line">
                    <div class="left">手机号码</div>
                    <div class="right">
                        <input type="text" class="right-inp" :value="userinfo.cellPhone" readonly>
                    </div>
                </div>
                <div class="line">
                    <div class="left">昵称</div>
                    <div class="right">
                        <input name="username" type="text" class="right-inp" :value="userinfo.userName">
                    </div>
                </div>
                <div class="line">
                    <div class="left">性别</div>
                    <div class="right">
                        <label for="male" class="radio-container">
                            <input type="radio" name="sex" v-model="sex" value="1" id="male" class="choose-radio">
                            <span class="">男</span>
                        </label>
                        <label for="female" class="radio-container">
                            <input type="radio" name="sex" v-model="sex" value="0" id="female" class="choose-radio">
                            <span class="">女</span>
                        </label>
                    </div>
                </div>
                <div class="line">
                    <div class="left">出生日期</div>
                    <div class="right clearfix">
                        <input name="birthday" type="date" v-model="date" class="birth">
                        <span class="wei-arrow-right"></span>
                    </div>
                </div>
                <div class="line">
                    <div class="left">微信</div>
                    <div class="right">
                        <input name="weixin" type="text" class="right-inp" :value="userinfo.weixin">
                    </div>
                </div>
            </section>
        </form>
        <div class="sub-btn">
            <a href="javascript:;" @click="sub()">确认保存</a>
        </div>
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
        config.userinfo = {!! json_encode($member, JSON_UNESCAPED_UNICODE) !!};
        config.uploadFileUrl = "{{ url('upload/image') }}";
        config.userinfoUrl = "{{ url('settings/profile') }}";
    </script>
    <script src="/js/userinfo.js"></script>
@endsection