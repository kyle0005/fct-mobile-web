@extends("layout")
@section('content')
    <div class="logistics-container" id="logistics" v-cloak>
        <div class="info-container clearfix">
            <div class="img-container"><img src="{{ $entity->image }}"></div>
            <div class="text-container">
                <div class="inner">
                    <div class="status">物流状态<span class="t">运输中</span></div>
                    <div>承运来源:&ensp;{{ $entity->expressPlatform }}</div>
                    <div>运单编号:&ensp;{{ $entity->expressNO }}</div>
                </div>
            </div>
        </div>
        <div class="logistics-info">
            <a href="javascript:;" class="title">
                <img src="{{ fct_cdn('/images/resource/sf.png') }}">本数据由<span class="name">顺丰官网</span>提供<span class="wei-arrow-right"></span>
            </a>
            <div class="detail">
                <ul>
                    <li class="item active">
                        <div class="inner clearfix">
                            <div class="line"></div>
                            <div class="content">
                                <div class="up">快件已从xxxx发出</div>
                                <div class="down">2017-08-08 02:03:04</div>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="inner clearfix">
                            <div class="line"></div>
                            <div class="content">
                                <div class="up">快件已从xxxx发出</div>
                                <div class="down">2017-08-08 02:03:04</div>
                            </div>
                        </div>
                    </li>
                    <li class="item">
                        <div class="inner clearfix">
                            <div class="line"></div>
                            <div class="content">
                                <div class="up">快件已从xxxx发出</div>
                                <div class="down">2017-08-08 02:03:04</div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer">
            <a href="https://static.meiqia.com/dist/standalone.html?_=t&eid=62925&clientid={{ $member->memberId }}&metadata={\"comment\":{\"orderId\":\"{{ $entity->orderId }}\"}}">
            <img src="{{ fct_cdn('/images/order_chat.png') }}">在线客服</a>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="{{ fct_cdn('/js/orderlogistics.js') }}"></script>
@endsection