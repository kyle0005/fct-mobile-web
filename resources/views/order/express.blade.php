@extends("layout")
@section('content')
    <div class="logistics-container" id="logistics" v-cloak>
        <div class="info-container clearfix">
            <div class="img-container"><img :src="logistics.image"></div>
            <div class="text-container">
                <div class="inner">
                    <div class="status">物流状态<span class="t">@{{ logistics.expressStatus }}</span></div>
                    <div>承运来源:&ensp;@{{ logistics.expressPlatform }}</div>
                    <div>运单编号:&ensp;@{{ logistics.expressNO }}</div>
                </div>
            </div>
        </div>
        <div class="logistics-info" v-if="logistics && logistics.expressInfoList && logistics.expressInfoList.length > 0">
            <a :href="logistics.expressUrl" class="title">
                <img :src="'{{ fct_cdn('/img/mobile/') }}' + logistics.expressEnglishName + '.png'">本数据由<span class="name">@{{ logistics.expressPlatform }}</span>提供<span class="wei-arrow-right"></span>
            </a>
            <div class="detail">
                <ul>
                    <li class="item" v-for="(item, index) in logistics.expressInfoList">
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

        <no-data v-if="nodata"></no-data>
        <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        <div class="footer">
            <div class="inner">
                <a href="https://static.meiqia.com/dist/standalone.html?_=t&eid=62925&clientid={{ $member->memberId }}&metadata={%22comment%22:{%22orderId%22:%22{{ $entity->orderId }}%22}}">
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