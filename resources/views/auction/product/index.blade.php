@extends("layout")
@section('content')
    <div class="auction-container" id="auction" v-cloak>
        <head-top @changelist="getprolist" :isindex="isindex"></head-top>
        <div class="prolist-container">
            <ul class="prolist" v-if="pro_list.length" v-load-more="nextPage" type="1">
                <li class="item" v-for="(item, index) in pro_list">
                    <a :href="'{{ url('auction', [], env('APP_SECURE')) }}/' + item.id">
                        <span class="pro-main">
                          <span class="info">
                            <span class="photo">
                              <img v-view="item.artistImg" src="{{fct_cdn('/img/mobile/img_loader.gif')}}">
                            </span>
                            <span class='context'>@{{ item.artistName }}<span class='vtitle'>@{{ item.artistTitle }}</span></span>
                            <span class='mark'>@{{ item.statusName }}</span>
                          </span>
                          <img v-view="item.defaultImg" src="{{fct_cdn('/img/mobile/img_loader.gif')}}">
                          <span class="sale clearfix">
                            <span class="left">
                              <span class="title">@{{item.bidName}}</span>
                              <small class="pri-mark">￥</small>@{{ item.bidPrice }}
                            </span>
                            <span class="right" v-if="item.status === 1 || item.status === 0">
                                @{{item.status === 0 ? "开始" : "结束"}}时间：
                                <span class="time" v-if="item.status === 0">@{{ item.startTime }}</span>
                                <span class="time" v-else-if="item.status !== 4">@{{ item.endTime }}</span><span class="time" v-else></span>
                            </span>
                            <span class="right" v-else-if="item.userName != ''">
                                成交者：@{{item.userName}}
                            </span>
                          </span>
                        </span>
                        <span class="title">@{{ item.name }}</span>
                        <span class="description">@{{ item.intro }}</span>
                    </a>
                    <div class="ops clearfix">
                        <img src="{{fct_cdn('/img/mobile/clickAmount.png')}}"><span>@{{ item.viewCount }}</span>
                        <img src="{{fct_cdn('/img/mobile/auction/pm-icon.png')}}"><span>@{{ item.bidCount }}</span>
                        <a href="javascript:;" class="right" @click="tip(item, index)" v-if="item.remindId > -1">
                            <img src="{{fct_cdn('/img/mobile/auction/remind-red.png')}}">
                            <span class="text">
                                <subpost v-if="item.remindId" :txt="'取消提醒'" :status="false" ref="tipsref" @callback="tip(item, index)" @before="postBefore"
                                         @success="postSuc" @error="postError" @alert="postTip"></subpost>
                                <subpost v-else :txt="'提醒我'" :status="false" ref="tipsref" @callback="tip(item, index)" @before="postBefore"
                                         @success="postSuc" @error="postError" @alert="postTip"></subpost>
                            </span>
                        </a>
                    </div>
                </li>
            </ul>
            <no-data v-if="nodata" imgurl="{{ fct_cdn('/img/mobile/no_data.png') }}" :text="'当前没有相关数据哟~'"></no-data>
            <img src="{{fct_cdn('/img/mobile/img_loader_s.gif')}}" class="list-loader" v-if="listloading">
            <img src="{{fct_cdn('/img/mobile/img_loader_s.gif')}}" class="pager-loader" v-if="pagerloading">
        </div>
        <div class="copyright-container">
            <div class="info">
                Copyright&nbsp&copy;&nbsp;2018&nbsp;宜兴方寸堂版权所有
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        config.productsType =  [
            {code: -1, name: "全部"},
            { code: 1, name: "进行中" },
            { code: 2, name: "待开始" },
            { code: 3, name: "往期回顾" },
        ];
        config.products = {!! json_encode($products, JSON_UNESCAPED_UNICODE) !!};
        config.isindex = true;
        config.auction_url = "{{url('auction', [], env('APP_SECURE'))}}";
        config.auction_remind_url = "{{url('remind', [], env('APP_SECURE'))}}";

    </script>
    <script src="{{ fct_cdn('/js/mobile/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/auction.js') }}"></script>
    {!! wechat_share($share) !!}
@endsection