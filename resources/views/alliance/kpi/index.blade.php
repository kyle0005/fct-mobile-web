@extends("layout")
@section('content')
    <div class="kpirecord-container" id="kpirecord" v-cloak>
        <ul class="list" v-load-more="nextPage" type="1" v-if="kpilist && kpilist.length > 0">
            <li class="items" v-for="(item, index) in kpilist">
                <div class="t-date">@{{ item.createTime }}</div>
                <div class="info-list">
                    <div class="info-i">
                        <div>线上销售额</div>
                        <div class="c"><small>￥</small>@{{ item.onlineSaleAmount }}</div>
                    </div>
                    <div class="info-i">
                        <div>线下销售额</div>
                        <div class="c"><small>￥</small>@{{ item.offlineSaleAmount }}</div>
                    </div>
                    <div class="info-i">
                        <div>累计佣金</div>
                        <div class="c"><small>￥</small>@{{ item.commission }}</div>
                    </div>
                </div>
                <div class="total">有效线上销售<span class="s"><small>￥</small>@{{ item.effectiveSaleAmount }}%</span>，回扣金额<span class="s"><small>￥</small>@{{ item.rebateAmount }}</span>。</div>
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