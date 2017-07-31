@extends("layout")
@section("title", $title)
@section('content')
    <div class="buy-container" id="buy_address" v-cloak>
        <ul class="address-choose-list">
            <li v-for="(item, index) in address" @click="choose(item)">
                <div class="item-container">
                    <div class="info">
                        <span>@{{ item.name }}</span>
                        <span class="phone">@{{ item.cellPhone }}</span>
                    </div>
                    <div class="addr"><span class="default-addr" v-if="item.isDefault == 1">[默认地址]</span>@{{ addressStr(item) }}</div>
                </div>
            </li>
        </ul>
        <div class="address-btn">
            <a href="{{ url('my/address') }}">管理</a>
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
    <script>
        config.address = {!! json_encode($addressList, JSON_UNESCAPED_UNICODE) !!};
        config.chooseAddrUrl = "{{ url('my/address/default') }}";
    </script>
    <script src="/js/buy_address_choose.js"></script>
@endsection