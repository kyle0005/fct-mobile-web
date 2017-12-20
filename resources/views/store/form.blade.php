@extends("layout")
@section('content')
    <div class="loginMem-container" id="login" v-cloak>
        <div class="logo"></div>
        <form id="userLogin">
            <ul class="form-data">
                <li class="items clearfix">
                    <div class="left">邀&ensp;请&ensp;码</div>
                    <div class="right">
                        <input type="text" name="code" class="" placeholder="请输入邀请码" v-model.number="inviteCode"/>
                    </div>
                </li>
                <li class="items clearfix">
                    <div class="left">店&ensp;铺&ensp;名</div>
                    <div class="right">
                        <input type="text" name="name" class="val-code" placeholder="请输入店铺名" v-model="shopName"/>
                    </div>
                </li>
                <li class="items clearfix">
                    <div class="left">申请说明</div>
                    <div class="right">
                        <textarea name="remark" class="val-code" placeholder="请输入申请说明" v-model="description"></textarea>
                    </div>
                </li>
            </ul>
            <div class="log-btn">
                <div class="sub">
                    <subpost :txt="'我要申请'" :status="true" ref="subpost" @callback="mobileLogin" @before="postBefore"
                             @success="postSuc" @error="postError" @alert="postTip"></subpost>
                </div>
            </div>
        </form>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.storeUrl = "{{ url('store', [], env('APP_SECURE')) }}";
    </script>
    <script src="{{ fct_cdn('/js/mobile/login_mem.js') }}"></script>
@endsection