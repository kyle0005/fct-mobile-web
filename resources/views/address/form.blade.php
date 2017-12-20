@extends("layout")
@section('content')
    <div class="buy-container" id="buy_address" v-cloak>
        <form id="addr">
            <input type="hidden" v-model="id" name="addrId">
            <div class="opt-container">
                <div class="line">
                    <div class="left">收货人</div>
                    <div class="right">
                        <input type="text" class="right-inp" name="name" v-model="name">
                    </div>
                </div>
                <div class="line">
                    <div class="left">联系电话</div>
                    <div class="right">
                        <input type="tel" class="right-inp" name="cellPhone" v-model="cellPhone">
                    </div>
                </div>
                <div class="line">
                    <div class="left">省份</div>
                    <div class="right clearfix">
                        <select v-model="province" name="province">
                            <option v-for="(item,key) in provincesName" :value="key">@{{item}}</option>
                        </select>
                        <span class="wei-arrow-right"></span>
                    </div>
                </div>
                <div class="line">
                    <div class="left">城市</div>
                    <div class="right clearfix">
                        <select v-model="city" name="city">
                            <option v-for="(item,key) in citysName" :value="key">@{{item}}</option>
                        </select>
                        <span class="wei-arrow-right"></span>
                    </div>
                </div>
                <div class="line">
                    <div class="left">区域</div>
                    <div class="right clearfix">
                        <select v-model="county" name="county">
                            <option v-for="(item,key) in countysName" :value="key">@{{item}}</option>
                        </select>
                        <span class="wei-arrow-right"></span>
                    </div>
                </div>
                <div class="line">
                    <textarea class="textarea" placeholder="请填写详细地址，不少于5个字" name="address" v-model="address"></textarea>
                </div>
            </div>
            <div class="opt-container">
                <div class="default-line">
                    <div class="left">设置默认</div>
                    <div class="right clearfix">
                        <div class="switch-container">
                            <input class="switch" name="" id="" type="checkbox" unchecked v-model="isDefault">
                        </div>
                    </div>
                </div>
            </div>
            <div class="address-btn">
                <a href="javascript:;">
                    <subpost :txt="'确认保存'" :status="true" ref="subpost" @callback="sub" @before="postBefore"
                             @success="postSuc" @error="postError" @alert="postTip"></subpost>
                </a>
            </div>
        </form>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.address = {!! json_encode($address, JSON_UNESCAPED_UNICODE) !!};
        config.saveAddressddUrl = "{{ url('my/address', [], env('APP_SECURE')) }}";
    </script>
    <script src="{{ fct_cdn('/js/mobile/common/city.min.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/buy_address_opt.js') }}"></script>
@endsection