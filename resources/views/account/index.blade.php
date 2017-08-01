@extends("layout")
@section("title", $title)
@section('content')
    <div class="walletaccount-container" id="walletaccount" v-cloak>
        <ul class="list" v-load-more="nextPage" v-if="walletaccountList && walletaccountList.length > 0">
            <li v-for="(item, index) in walletaccountList">
                <div class="inner">
                    <div class="up clearfix">
                        <span>@{{ item.remark }}</span><span class="pri">￥@{{ item.amount }}</span>
                    </div>
                    <div class="down clearfix">
                        <span>@{{ item.createTime }}</span><span class="pri">￥@{{ item.balanceAmount }}</span>
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
        config.walletaccountUrl = "{{ url('my/account/logs') }}";
        config.walletaccountList = {!! json_encode($logs, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="/js/common/tools.js"></script>
    <script src="/js/walletaccount.js"></script>
@endsection