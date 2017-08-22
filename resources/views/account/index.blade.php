@extends("layout")
@section('content')
    <div class="walletaccount-container" id="walletaccount" v-cloak>
        <ul class="list" v-load-more="nextPage" v-if="walletaccountList && walletaccountList.length > 0">
            <li v-for="(item, index) in walletaccountList">
                <div class="inner">
                    <div class="up clearfix">
                        <span>@{{ item.remark }}</span><span class="pri"><small class="pri-mark">￥</small>@{{ item.amount }}</span>
                    </div>
                    <div class="down clearfix">
                        <span>@{{ item.createTime }}</span><span class="pri"><small class="pri-mark">￥</small>@{{ item.balanceAmount }}</span>
                    </div>
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
        config.walletaccountUrl = "{{ url('my/account/logs') }}";
        config.walletaccountList = {!! json_encode($logs, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/walletaccount.js') }}"></script>
@endsection