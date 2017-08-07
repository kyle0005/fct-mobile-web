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

        <div class="noData" v-else>
            <div class="inner">
                <img src="{{ fct_cdn('/images/no_data.png') }}">
                <span class="no">当前没有相关数据哟~</span>
            </div>
        </div>

        <p v-if="pager.next == 0" class="empty_data">没有更多了</p>
        <footer class="loader_more" v-show="preventRepeatReuqest">正在加载更多...</footer>
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