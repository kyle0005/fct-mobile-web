@extends("layout")
@section("title", $title)
@section('content')
    <div class="buy-container" id="buy_address" v-cloak>
        <div class="opt-container">
            <div class="line">
                <div class="left">收货人</div>
                <div class="right">
                    <input name="name" type="text" class="right-inp" :value="address.name">
                </div>
            </div>
            <div class="line">
                <div class="left">联系电话</div>
                <div class="right">
                    <input name="cellphone" type="tel" class="right-inp"  :value="address.cellPhone">
                </div>
            </div>
            <div class="line">
                <div class="left">省份</div>
                <div class="right clearfix">
                    <select name="province" v-model="province">
                        <option v-for="(item,key) in provincesName" :value="key">@{{item}}</option>
                    </select>
                    <span class="wei-arrow-right"></span>
                </div>
            </div>
            <div class="line">
                <div class="left">城市</div>
                <div class="right clearfix">
                    <select name="city_id" v-model="city">
                        <option v-for="(item,key) in citysName" :value="key">@{{item}}</option>
                    </select>
                    <span class="wei-arrow-right"></span>
                </div>
            </div>
            <div class="line">
                <div class="left">区域</div>
                <div class="right clearfix">
                    <select name="town_id" v-model="county">
                        <option v-for="(item,key) in countysName" :value="key">@{{item}}</option>
                    </select>
                    <span class="wei-arrow-right"></span>
                </div>
            </div>
            <div class="line">
                <textarea class="textarea" placeholder="请填写详细地址，不少于5个字"></textarea>
            </div>
        </div>
        <div class="opt-container">
            <div class="default-line">
                <div class="left">设置默认</div>
                <div class="right clearfix">
                    <div class="switch-container">
                        <input class="switch" name="" id="" type="checkbox" unchecked>
                    </div>
                </div>

            </div>
        </div>
        <div class="address-btn">
            <a href="javascript:;">保存</a>
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
        config.address = {!! json_encode($address, JSON_UNESCAPED_UNICODE) !!}
    </script>
    <script src="/js/common/cities.js"></script>
    <script src="/js/buy_address_opt.js"></script>
@endsection