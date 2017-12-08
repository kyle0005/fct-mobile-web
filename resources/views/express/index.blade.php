@extends("layout")
@section('content')
    <div class="logistics-container" id="logistics" v-cloak>
        <div class="info-container clearfix">
            <div class="img-container">
                <img src="{{fct_cdn('/img/mobile/signed.png')}}"  v-if="logistics.status == '已签收'">
                <img src="{{fct_cdn('/img/mobile/intransit.png')}}"  v-else>
            </div>
            <div class="text-container">
                <div class="inner">
                    <div class="status">物流状态<span class="t">@{{logistics.status}}</span></div>
                    <div>承运来源:&ensp;@{{ logistics.name }}</div>
                    <div>运单编号:&ensp;@{{ logistics.number }}</div>
                </div>
            </div>
        </div>
        <div class="logistics-info" v-if="logistics && logistics.content && logistics.content.length > 0">
            <a :href="logistics.url" class="title">
                <img src="{{ fct_cdn('/img/mobile/' . $entity->englishName . '.png') }}">本数据由<span class="name">@{{ logistics.expressPlatform }}</span>提供<span class="wei-arrow-right"></span>
            </a>
            <div class="detail">
                <ul>
                    <li class="item" v-for="(item, index) in logistics.content">
                        <div class="inner">
                            <div class="line"></div>
                            <div class="content">
                                <div class="up">@{{ item.status }}</div>
                                <div class="down">@{{ item.time }}</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <div class="inner">
                <a href="https://static.meiqia.com/dist/standalone.html?_=t&eid=62925&clientid={{ $member->memberId }}">
                    <img src="{{ fct_cdn('/img/mobile/order_chat.png') }}">在线客服</a>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        config.logistics = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/orderlogistics.js') }}"></script>
@endsection