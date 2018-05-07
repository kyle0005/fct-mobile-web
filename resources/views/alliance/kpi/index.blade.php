@extends("layout")
@section('content')
    <div class="kpirecord-container" id="kpirecord" v-cloak>
        <ul class="list" v-load-more="nextPage" type="1" v-if="kpilist && kpilist.length > 0">
            <li class="items" v-for="(item, index) in kpilist">
                <div class="t-date">@{{ item.createTime }}</div>
                <div class="info-list">
                    <div class="info-i">
                        <div>考核指标</div>
                        <div class="c"><small>￥</small>@{{ item.kpiAmount }}</div>
                    </div>
                    <div class="info-i">
                        <div>分店数</div>
                        <div class="c">@{{ item.storeCount }}</div>
                    </div>
                    <div class="info-i">
                        <div>销售额</div>
                        <div class="c"><small>￥</small>@{{ item.saleAmount }}</div>
                    </div>
                    <div class="info-i">
                        <div>返点比例</div>
                        <div class="c">@{{ item.rebateRatio }}%</div>
                    </div>
                </div>
                <div class="total">完成业绩<span class="s">@{{ item.finishSaleRatio }}%</span>，返点<span class="s">@{{ item.lastRebateRatio }}%</span>，返佣<span class="s"><small>￥</small>@{{ item.rebateAmount }}</span>。</div>
            </li>
        </ul>
        <no-data v-if="nodata" :imgurl="'{{ fct_cdn('/img/mobile/no_data.png') }}'" :text="'当前没有相关数据哟~'"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
    </div>
@endsection
@section('javascript')
    <script>
        config.kpiurl = "{{ url('my/alliance/kpi', [], env('APP_SECURE')) }}";
        config.kpi = {!! json_encode($kpis, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/u_kpirecord.js') }}"></script>
@endsection