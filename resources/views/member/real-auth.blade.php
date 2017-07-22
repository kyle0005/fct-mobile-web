@extends("layout")
@section("title", $title)
@section('content')
    <div class="authentication-container" id="authentication">
        <section class="list">
            <div class="item">
                <div class="inner">
                    <span class="left">真实姓名</span>
                    <input type="text" class="inp">
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">开户行</span>
                    <select class="select">
                        <option>请选择</option>
                    </select>
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">开户行账号</span>
                    <input type="text" class="inp">
                </div>
            </div>
            <div class="item">
                <div class="inner">
                    <span class="left">身份张号码</span>
                    <input type="text" class="inp">
                </div>
            </div>
        </section>
        <div class="sub-btn">
            <a href="javascript:;">提交申请</a>
        </div>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
            </section>
        </div>
    </template>
@endsection
@section('javascript')

@endsection