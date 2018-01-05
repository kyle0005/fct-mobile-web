@extends("layout")
@section('content')
    <div class="auctionlive-container" id="auctionlive" v-cloak>
        <div class="m-video-container">
            <div class="video-inner">
                <div class="live-container">
                    <div id="id_video_container"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        config.app_id = '{{ $appId }}';
        config.live_url = '{{ $liveId }}';
    </script>
    <script src="{{ fct_cdn('/js/mobile/hammer.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/common/tools.js') }}"></script>
    <script src="//qzonestyle.gtimg.cn/open/qcloud/video/live/h5/live_connect.js"></script>
    <script src="{{ fct_cdn('/js/mobile/auction_live.js') }}"></script>
@endsection