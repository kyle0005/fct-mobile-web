@extends("layout")
@section('content')
    <div class="union-container" id="union" v-cloak>
        <section class="info-container">
            <div class="shop">
                <div class="name">@{{ union.name }}<img src="{{ fct_cdn('/img/mobile/shop_v'.$entity->levelId.'.png') }}" class="rank"></div>
                <div class="deposit"><span class="n">@{{ reversedNum }}</span>万保证金</div>
            </div>
            <ul class="detail">
                <li class="items">
                    <div class="inner">
                        <span class="pri"><small>￥</small>@{{ union.saleAmount }}</span>
                        <span class="txt">总销售额</span>
                    </div>
                </li>
                <li class="items">
                    <div class="inner">
                        <span class="pri"><small>￥</small>@{{ union.rebateAmount }}</span>
                        <span class="txt">总返金额</span>
                    </div>
                </li>
                <li class="items">
                    <a href="{{ url('my/alliance/store', [], env('APP_SECURE')) }}" class="inner">
                        <span class="pri">@{{ union.storeCount }}</span>
                        <span class="txt l">分店数</span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="kpi-container">
            <div class="title">@{{ union.month }}月考核情况<a href="{{ url('my/alliance/kpi', [], env('APP_SECURE')) }}" class="more">更多&nbsp;<i class="fa fa-caret-right"></i></a></div>
            <ul class="detail">
                <li class="items">考核指标</li>
                <li class="items">累积销售额</li>
                <li class="items">返点比例</li>
                <li class="items"><small>￥</small>@{{ union.kpiAmount }}</li>
                <li class="items"><small>￥</small>@{{ union.kpiSaleAmount }}</li>
                <li class="items">@{{ reversedRatio }}%</li>
                <li class="items"><span class="shop">“@{{ union.topAllianceName }}”</span>当前业绩最高</li>
            </ul>
        </section>
        <section class="invite-container">
            <div class="title">
                <div class="t">邀请开店</div>
                <div class="vt" v-if="union.inviteCount > 0">有<span class="n">@{{ union.inviteCount }}</span>张邀请码</div>
                <a href="javascript:;" class="btn" @click="invite"><img src="{{ fct_cdn('/img/mobile/touch.png') }}" v-if="union.inviteCount > 0"></a>
            </div>
            <ul class="detail">
                <li class="items">
                    <div class="r">邀请码</div>
                    <div class="r">过期时间</div>
                    <div class="r">操作</div>
                </li>
                <li class="items" v-for="(item, index) in inviteCodes">
                    <div class="r">@{{ item.code }}</div>
                    <div class="r">@{{ item.expireTime }}</div>
                    <div class="r">
                        <a :href="'{{ url('store/create', [], env('APP_SECURE')) }}?code=' + item.code" class="opt">
                            <img src="{{ fct_cdn('/img/mobile/m_add.png') }}">
                        </a>
                    </div>
                </li>
            </ul>
        </section>
    </div>
@endsection
@section('javascript')
    <script>
        config.union = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
        config.add_url = "{{ url('my/alliance/invite-code', [], env('APP_SECURE')) }}";
    </script>
    <script src="{{ fct_cdn('/js/mobile/union.js') }}"></script>
@endsection