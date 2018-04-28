@extends("layout")
@section('content')
    <div class="shoplist-container" id="shoplist" v-cloak>
        <ul class="list">
            <li class="items">
                <div class="r">店铺编号</div>
                <div class="r">手机号码</div>
                <div class="r">加入时间</div>
            </li>
            <li class="items" v-for="(item, index) in list">
                <div class="r">@{{ item.storeId }}</div>
                <div class="r">@{{ item.cellPhone }}</div>
                <div class="r">@{{ item.createTime }}</div>
            </li>
        </ul>
    </div>
@endsection
@section('javascript')
    <script>config.list = {!! json_encode($entities, JSON_UNESCAPED_UNICODE) !!};</script>
    <script src="{{ fct_cdn('/js/mobile/u_shoplist.js') }}"></script>
@endsection