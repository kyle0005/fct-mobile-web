@extends("layout")
@section('content')
    <div class="logistics-container" id="logistics" v-cloak>
        <div class="info-container clearfix">
            <div class="img-container"><img src="{{ $entity->image }}"></div>
            <div class="text-container">
                <div class="inner">
                    <div class="status">物流状态<span class="t">{{ $entity->expressStatus }}</span></div>
                    <div>承运来源:&ensp;{{ $entity->expressPlatform }}</div>
                    <div>运单编号:&ensp;{{ $entity->expressNO }}</div>
                </div>
            </div>
        </div>
        <div class="logistics-info">
            <a href="{{ $entity->expressUrl }}" class="title">
                <img src="{{ fct_cdn('/images/resource/' . $entity->expressEnglishName . '.png') }}">本数据由<span class="name">{{ $entity->expressPlatform }}</span>提供<span class="wei-arrow-right"></span>
            </a>
            <div class="detail">
                @if ($entity->expressInfoList)
                <ul>
                    @foreach($entity->expressInfoList as $key=>$express)
                    <li class="item {{ $key ? "" : "active" }}">
                        <div class="inner clearfix">
                            <div class="line"></div>
                            <div class="content">
                                <div class="up">{{ $express->status }}</div>
                                <div class="down">{{ $express->time }}</div>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @else
                    <div class="noData">
                        <div class="inner">
                            <img src="{{ fct_cdn('/images/no_data.png') }}">
                            <span class="no">当前没有相关数据哟~</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="footer">
            <div class="inner">
                <a href="https://static.meiqia.com/dist/standalone.html?_=t&eid=62925&clientid={{ $member->memberId }}&metadata={%22comment%22:{%22orderId%22:%22{{ $entity->orderId }}%22}}">
                    <img src="{{ fct_cdn('/images/order_chat.png') }}">在线客服</a>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ fct_cdn('/js/orderlogistics.js') }}"></script>
@endsection