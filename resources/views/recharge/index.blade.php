@extends("layout")
@section('content')
    <div class="record-recharge-container" id="recordrecharge" v-cloak>
        <ul class="list" v-load-more="nextPage" v-if="chargeRecordList && chargeRecordList.length > 0">
            <li class="clearfix" v-for="(item, index) in chargeRecordList">
                <div class="info">
                    <div class="up">
                        <span class="long">订单号：@{{ item.id }}</span>
                        <span><small class="pri-mark">￥</small>@{{ item.payAmount }}</span>
                        <span><small class="pri-mark">￥</small>@{{ item.giftAmount }}</span>
                        <span class="pri"><small class="pri-mark">￥</small>@{{ item.amount }}</span>
                    </div>
                    <div class="down">
                        <span class="long">@{{ item.createTime }}</span>
                        <span>充值金额</span>
                        <span>赠送金额</span>
                        <span class="pri">获得金额</span>
                    </div>
                </div>
                <div class="btn-container" v-if="item.status == 0">
                    <a :href="'{{  sprintf('%s?tradetype=recharge&tradeid=', env('PAY_URL')) }}' + item.id" class="btn">我要付款</a>
                </div>
            </li>
        </ul>

        <no-data v-if="nodata"></no-data>
        <img src="{{ fct_cdn('/images/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.chargeRecordUrl = "{{ url('my/account/recharge') }}";
        config.chargeRecordList = {!! json_encode($recharges, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/recordrecharge.js') }}"></script>
@endsection