@extends("layout")
@section('content')
    <div class="auctiondetail-container" id="auctiondetail" v-cloak>
        <section class="overview-container">
            <section class="video-container">
                <mVideo v-if="product.videoUrl" :poster="product.videoImg" :url="product.videoUrl" id="videotop"></mVideo>
                <m-swipe v-else swipeid="swipe" ref="swiper" :autoplay="0" effect="slide">
                    <div v-for="(top, index) in tops" class="swiper-slide" slot="swiper-con">
                        <a :href="top.url" class="link">
                            <img :data-src="top" class="swiper-lazy silde-img">
                        </a>
                    </div>
                </m-swipe>
            </section>
            <section class="product-context">
                <strong class="title">@{{ product.name }}</strong>
                <div class="vice-title">@{{ product.subTitle }}</div>
                <div class="total">
                    <div class="inner">
                        <div class="num">@{{ product.bidCount }}</div>
                        <div class='text'>人出价</div>
                    </div>
                    <div class="inner">
                        <div class="num">@{{ product.viewCount }}</div>
                        <div class='text'>人围观</div>
                    </div>
                </div>
            </section>
            <section class="info clearfix" :class="{open:open,docked:docked}">
                <div class="item clearfix">
                    <span class="left">市场估价</span>
                    <span class="right overText"><small class="pri-mark">￥</small>@{{ product.marketPrice }}</span>
                </div>
                <div class="item clearfix">
                    <span class="left">保证金</span>
                    <span class="right color-pri overText"><small class="pri-mark">￥</small>@{{ product.deposit }}</span>
                </div>
                <div class="item clearfix">
                    <span class="left">竞价时长</span>
                    <span class="right overText">@{{ product.duration }}</span>
                </div>
                <div class="item clearfix">
                    <span class="left">延时周期</span>
                    <span class="right overText">@{{ product.delaySecond }}</span>
                </div>
            </section>
            <section class='artist' :class="{open:open,docked:docked}">
                <a :href="'{{ url('artists', [], env('APP_SECURE')) }}/' + product.artistId" class="link" v-if="product.artistCooperate == 2">
                    <img class='photo' :src="product.artistImg"/>
                    <img class='arrow' src="{{fct_cdn('/img/mobile/arrow_right.png')}}"/>
                    <span class='content'>
                        <span class='title'>@{{ product.artistName }}</span><span class='vtitle'>@{{ product.artistTitle }}</span>
                        <span class='text overTextH3'>@{{ product.artistIntro }}</span>
                    </span>
                </a>
                <a :href="'{{ url('auction/artist', [], env('APP_SECURE')) }}/' + product.artistId" class="link" v-else>
                    <img class='photo' :src="product.artistImg"/>
                    <img class='arrow' src="{{fct_cdn('/img/mobile/arrow_right.png')}}"/>
                    <span class='content'>
                        <span class='title'>@{{ product.artistName }}</span><span class='vtitle'>@{{ product.artistTitle }}</span>
                        <span class='text overTextH3'>@{{ product.artistIntro }}</span>
                    </span>
                </a>
            </section>
            <section class="content" :class="{open:open,docked:docked}">
                {!! $entity->content !!}
            </section>
        </section>
        <section class='det-container'>
            <div class='main'>
                <div class='info'>
                    <img class='photo' :src="product.bidUserHeadPortrait"/>
                    <div class='user'>@{{ product.bidUserName }}</div>
                    <div class='status'>@{{ product.bidStatusName }}</div>
                </div>
                <div class='price'>
                    <div class='up'>{{product.bidName}}：<span class='low'>最低+@{{ product.increasePrice }}</span></div>
                    <div class='down'>@{{ currentPrice }}元</div>
                </div>
            </div>
            <div class='other clearfix'>
                <div class="left">
                    <div v-if="product.status !== 4 && parseInt((product.endTime - (new Date()).valueOf()) / 1000) > 0">
                        <img src="{{fct_cdn('/img/mobile/auction/remind-yw.png')}}"/>
                        <div class='text'>距@{{ product.status === 1 ? '开始': '结束'}}仅剩：<span><span class="time-block">@{{ time_content.hour }}</span>时<span class="time-block">@{{ time_content.min }}</span>分<span class="time-block">@{{ time_content.sec }}</span>秒</span></div>
                    </div>
                </div>
                <a href="{{ url('auction', [], env('APP_SECURE')) }}" class="right">
                    同场其他拍品<img src="{{fct_cdn('/img/mobile/head_r.png')}}"/>
                </a>
            </div>
        </section>
        <div class="aside" :class="{open:open,docked:docked}" @click.prevent="choose()">
            <div class="container" @click.stop="">
                <div class='chat-inner' id="chatContainer">
                    <div class='chat-item' :class="{price:items.roleType===1,host:items.roleType===2}" v-for="(items, index) in chat_list">
                        <img class='photo' :src="items.headPortrait"/>
                        <div class='content'>
                            <div class='title'>@{{ items.userName }}<span class='time'>@{{ items.createTime }}</span></div>
                            <div class='main'>@{{ items.content }}<span class='text on' v-if="items.roleType===1 && items.id===onId">有效</span><span class='text off' v-else-if="items.roleType===1 && items.id !== onId">失效</span></div>
                        </div>
                    </div>

                </div>
                <div class='send clearfix'>
                    <input type='text' class='amount' :disabled="product.status === 4" placeholder='输入想要表达的信息' v-model="wsMsg"/>
                    <a href="javascript:;" class='btn' @click="bindSendTap" v-if="product.status != 4">发送</a>
                    <a href="javascript:;" class='btn grey' v-else>发送</a>
                </div>
                <div class='slide'>
                    <img class='tips-img' src="{{fct_cdn('/img/mobile/auction/slide.png')}}"/>
                    <a href="javascript:;" class='tips'>右滑查看拍品</a>
                </div>
            </div>
        </div>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        <footer class="foot-container">
            <div class="inner">
                <div class="nav">
                    <div class="lis message">
                        <a href="javascript:;" class="foot-link" @click='choose'>
                            <img src="{{fct_cdn('/img/mobile/auction/hu.png')}}" v-if="open"/>
                            <img src="{{fct_cdn('/img/mobile/auction/chat.png')}}" v-else/>
                        </a>
                    </div>
                    <div class="lis inp">
                        <input type='number' class='input' :disabled="product.status !== 3" placeholder='最低加价100' v-model.number="addpri"/>
                        <a href="javascript:;" class="fork" @click="clear" v-if="addpri > 0">
                            <img src="{{fct_cdn('/img/mobile/auction/del-price.png')}}">
                        </a>
                    </div>
                    <a href="javascript:;" class="lis add" v-if="product.status === 3" @click="add">+</a>
                    <a href="javascript:;" class="lis add grey" v-else>+</a>
                    <div class="lis buy">
                        <a href="javascript:;" class="txt grey" v-if="product.status == 1">拍卖未开始</a>
                        <a href="javascript:;" class="txt " v-else-if="product.status < 3">
                            <subpost :txt="'预交保证金'" :status="true" ref="deppost" @callback="bindDepositTap" @before="postBefore"
                                     @success="postSuc" @error="postError" @alert="postTip"></subpost>
                        </a>
                        <a :href="'{{sprintf('%s?tradetype=auction_deposit&tradeid=', env('PAY_URL'))}}' + product.signupId" class="txt" v-else-if="product.status > 10">继续报名</a>
                        <a href="javascript:;" class="txt" v-else-if="product.status === 3" @click="bindSubmitTap">
                            <subpost :txt="'我要出价'" :status="true" ref="subpost" @callback="bindSubmitTap" @before="postBefore"
                                     @success="postSuc" @error="postError" @alert="postTip"></subpost>
                        </a>
                        <a href="javascript:;" class="txt grey" v-else-if="product.status === 4">拍卖结束</a>
                    </div>
                </div>
            </div>

        </footer>

    </div>
@endsection
@section('javascript')
    <script>
        config.product = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
        config.chatList = {!! json_encode($chatList, JSON_UNESCAPED_UNICODE) !!};
        config.reload_url = "{{ url('auction/'.$entity->id, [], env('APP_SECURE')) }}";
        config.ws_auction_url = "{{env('WS_API_URL')}}";
        config.auction_signup_url = "{{ url('signup', [], env('APP_SECURE')) }}";
        config.auction_bid_url = "{{ url('bid', [], env('APP_SECURE')) }}";
        config.loginUrl = "{{ url(\App\FctCommon::hasWeChat() ? 'oauth' : 'login', [], env('APP_SECURE')).'?'.env('REDIRECT_KEY').'='.url('auction/'.$entity->id, [], env('APP_SECURE'))}}";
    </script>
    <template id="m_video">
        <div class="m-video-container">
            <div class="video-inner">
                <div v-if="!isVideoLoad" class="play-container" @click="loadVideo()">
                    <img :src="poster" class="poster-img" />
                    <img src="public/img/mobile/video_play.png')}}" class="poster-play" />
                </div>
                <video class="m-video" :src="url" :id="id" preload="metadata" controls v-else></video>
            </div>
        </div>
    </template>
    <script type="text/x-template" id="m_swipe">
        <div class="swiper-container" :class="swipeid">
            <div class="swiper-wrapper">
                <slot name="swiper-con"></slot>
            </div>
            <!-- 分页器 -->
            <div :class="{'swiper-pagination':pagination}"></div>
        </div>
    </script>
    <script src="{{fct_cdn('/js/mobile/hammer.js')}}"></script>
    <script src="{{fct_cdn('/js/mobile/head.js')}}"></script>
    <script src="{{fct_cdn('/js/mobile/common/tools.js')}}"></script>
    <script src="{{fct_cdn('/js/mobile/swiper.js')}}"></script>
    <script src="{{fct_cdn('/js/mobile/auction_detail.js')}}"></script>
    {!! wechat_share($share) !!}
@endsection