@extends("layout")
@section('content')
    <div class="walletaccount-container" id="walletaccount" v-cloak>
        <ul class="list" v-load-more="nextPage" v-if="walletaccountList && walletaccountList.length > 0">
            <li v-for="(item, index) in walletaccountList">
                <div class="inner">
                    <div class="up">
                        <span class="remark overText">@{{ item.remark }}</span>
                        <span class="point">@{{ item.points > 0 ? (item.behaviorType == 1 ? '+' : '-') : '' }}@{{ item.points }}</span>
                        <span class="pri">@{{ item.amount > 0 ? (item.behaviorType == 1 ? '+' : '-') : '' }}@{{ item.amount }}</span>
                    </div>
                    <div class="down">
                        <span class="remark">@{{ item.createTime }}</span>
                        <span class="point">积分:@{{ item.balancePoints }}</span>
                        <span class="pri">余额:<small class="pri-mark">￥</small>@{{ item.balanceAmount }}</span>
                    </div>
                </div>
            </li>
        </ul>

        <no-data v-if="nodata" imgurl="{{ fct_cdn('/img/mobile/no_data.png') }}" :text="'当前没有相关数据哟~'"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <div class="pager-loading-txt" v-if="pagerloading">加载中...</div>
        <div class="pager-loaded" v-if="isLastPage">
            <div class="title">
                <div class="lines">
                    <div class="text">我是有底线的</div>
                </div>
            </div>
        </div>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.walletaccountUrl = "{{ url('my/account/logs', [], env('APP_SECURE')) }}";
        config.walletaccountList = {!! json_encode($logs, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/walletaccount.js') }}"></script>
@endsection