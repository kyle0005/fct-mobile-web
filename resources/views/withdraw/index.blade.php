@extends("layout")
@section('content')
    <div class="walletaccount-container" id="withdrawalsrecord" v-cloak>
        <ul class="list" v-load-more="nextPage" v-if="withdrawalRecordList && withdrawalRecordList.length > 0">
            <li v-for="(item, index) in withdrawalRecordList">
                <div class="inner">
                    <div class="up clearfix">
                        <span>@{{ item.bankName }}（@{{ item.bankAccount }}）</span><span class="pri"><small class="pri-mark">￥</small>@{{ item.amount }}</span>
                    </div>
                    <div class="down clearfix">
                        <span>状态：@{{ item.statusName }}</span><span class="pri">@{{ item.createTime }}</span>
                    </div>
                </div>
            </li>
        </ul>

        <no-data v-if="nodata"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.withdrawalRecordUrl = "{{ url('my/account/withdraw') }}";
        config.withdrawalRecordList = {!! json_encode($withdraws, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/withdrawalsrecord.js') }}"></script>
@endsection