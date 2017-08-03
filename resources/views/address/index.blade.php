@extends("layout")

@section('content')
    <div class="buy-container" id="buy_address" v-cloak>
        <ul class="address-list" v-if="address && address.length > 0">
            <li v-for="(item, index) in address">
                <div class="item-container">
                    <div class="info">
                        <span>@{{ item.name }}</span>
                        <span class="phone">@{{ item.cellPhone }}</span>
                    </div>
                    <div class="addr">@{{ addressStr(item) }}</div>
                    <div class="opt">
                        <label :for="'address_' + index" class="radio-container">
                            <input type="radio" name="address" :value="addressStr(item)" @change="changeDefault(item)" v-model="picked" :id="'address_' + index" class="choose-radio">
                            <span class="">默认地址</span>
                        </label>
                        <div class="options-container">
                            <a href="javascript:;" @click="edit(item)"><img src="/images/edit.png">编辑</a>
                            <a href="javascript:;" @click="del(item, index)"><img src="/images/del.png">删除</a>
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <ul class="prolist" v-else>
            <li class="noData">
                <img src="/images/no_data.png">
                <span class="no">当前没有相关数据哟~</span>
            </li>
        </ul>

        <div class="address-btn">
            <a href="{{ url('my/address/create') }}">添加新地址</a>
        </div>
    <!--radio选中的是:@{{ picked }}-->
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
        config.address = {!! json_encode($addressList, JSON_UNESCAPED_UNICODE) !!};
        config.defaultAddrUrl = "{{ url('my/address/default') }}";
        config.delAddrUrl = "{{ url('my/address/delete') }}";
        config.editUrl = "{{ url('my/address/edit') }}";
    </script>
    <script src="/js/buy_address.js"></script>
@endsection