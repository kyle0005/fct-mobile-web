@extends("layout")
@section("title", $title)
@section('content')
    <div class="walletaccount-container" id="withdrawalsrecord" v-cloak>
        <ul class="list" v-load-more="nextPage">
            <li v-for="(item, index) in withdrawalRecordList">
                <div class="inner">
                    <div class="up clearfix">
                        <span>@{{ item.bankName }}（@{{ item.bankAccount }}）</span><span class="pri">￥@{{ item.amount }}</span>
                    </div>
                    <div class="down clearfix">
                        <span>状态：@{{ item.statusName }}</span><span class="pri">@{{ item.createTime }}</span>
                    </div>
                </div>
            </li>
        </ul>
        <footer class="loader_more" v-show="preventRepeatReuqest">正在加载更多...</footer>
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
        config.withdrawalRecordUrl = "{{ url('my/account/withdraw') }}";
        config.withdrawalRecordList = {!! json_encode($withdraws, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="/js/common/tools.js"></script>
    <script src="/js/withdrawalsrecord.js"></script>
@endsection