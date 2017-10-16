@extends("layout")
@section('content')
    <div class="art-container" id="artist" v-cloak>
        <head-top></head-top>
        <section class="live" id="live_container">
            <div class="container">
                <div class="inner" v-if="haslive">
                    <img :src="artist.banner">
                    <div class="info join-num">@{{ artist.followCount }}人关注</div>
                </div>
                <div class="inner" v-else>
                    <img :src="artist.banner">
                    <div class="info join-num">@{{ artist.followCount }}人关注</div>
                </div>
            </div>
        </section>
        <section class="nav-bar">
            <ul class="art-tab">
                <li class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="linkTo(index)">
                    <a href="javascript:;">@{{ item }}</a>
                </li>
            </ul>
        </section>
        <keep-alive>
            <component :is="currentView">
            </component>
        </keep-alive>
    </div>
@endsection

@section('javascript')
    {{--艺术家动态--}}
    <script type="text/x-template" id="live">
        <div class="tabs">
            <section class="ptop">
                <div class="text">@{{ top.content }}</div>
                <div class="media" :class="{vi: top.videoUrl!==''}">
                    <mVideo v-if="top.videoUrl !== ''" :item="top"></mVideo>
                    <ul class="img-list" v-if="topImg">
                        <li v-for="imgs in top.images">
                            <img v-img="{ group: 'top', exsrc: top.largeImages[index]}" v-view="imgs" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                        </li>
                    </ul>
                </div>
            </section>

            <ul class="news" v-load-more="nextPage" type="1" v-if="liveList && liveList.length > 0">
                <li class="item" v-for="(item, index) in liveList">
                    <div class="text">@{{ item.content }}</div>
                    <div class="media" :class="{vi: item.videoUrl!==''}">
                        <mVideo v-if="item.videoUrl !== ''" :poster="item.videoImage" :url="item.videoUrl" id="'video' + item.id"></mVideo>
                        <ul class="img-list clearfix" v-if="item.images.length > 0">
                            <li v-for="(img, i) in item.images">
                                <img v-img="{ group: item.id, exsrc: item.largeImages[i]}" v-view="img" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            <no-data v-if="nodata"></no-data>
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="pager-loader" v-if="pagerloading">
        </div>
    </script>
    {{--艺术家作品--}}
    <script type="text/x-template" id="works">
        <div class="tabs">
            <ul class="pro-list" v-if="workslist && workslist.length > 0">
                <li v-for="(item, index) in workslist">
                    <div class="inner">
                        <div class="left">
                            <img v-view="item.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                        </div>
                        <div class="right">
                            <div class="title overText">@{{ item.name }}</div>
                            <div class="text overTextH2" v-html="item.intro"></div>
                            <div class="price overText" v-if="item.price > 0">￥@{{ item.price }}</div>
                            <div class="price overText" v-else>暂无售价</div>
                            <div class="btn-container">
                                <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="btn">我要购买</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <no-data v-if="nodata"></no-data>
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        </div>
    </script>
    {{--艺术家评论--}}
    <script type="text/x-template" id="chat">
        <div class="tabs">
            <ul class="chat-list" v-load-more="nextPage" type="1" v-if="chatlist && chatlist.length > 0">
                <li v-for="(item, index) in chatlist">
                    <div class="inner">
                        <div class="info">
                            <div class="img-container">
                                <img v-view="item.headPortrait" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                            </div>
                            <div class="user">@{{ item.userName }}</div>
                            <div class="time">@{{ item.createTime }}</div>
                        </div>
                        <div class="context">@{{ item.content }}</div>
                        <div class="reply-container" v-if="item.replyContent && item.replyContent.length > 0">
                            <div class="icon"><img src="{{ fct_cdn('/img/mobile/reply.png') }}"></div>
                            <div class="reply" v-for="(reply, index) in item.replyContent">@{{ reply.content }}</div>
                        </div>
                    </div>
                </li>
            </ul>

            <no-data v-if="nodata"></no-data>
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="pager-loader" v-if="pagerloading">
            <section class="sub-chat">
                <div class="inner">
                    <a href="javascript:;" class="sub" @click="popchat()">
                        <span class="img"><img src="{{ fct_cdn('/img/mobile/reply_chat.png') }}"></span>
                        <span class="txt">请输入要表达的信息</span>
                    </a>
                    <div class="aside" :class="{open:open,docked:docked}" @click.prevent="popchat()">
                        <div class="container" @click.stop="">
                            <form id="chat_form">
                                <div class="inner">
                                    <div class="top">
                                        <a href="javascript:;" class="cancel" @click.prevent="popchat()">取消</a>
                                        <span class="title">我来聊两句</span>
                                        <a href="javascript:;" class="send">
                                            <subpost :txt="subText" ref="subpost" @callback="send" @succhandle="succhandle"></subpost>
                                        </a>
                                    </div>
                                    <textarea class="textarea" v-model="message"></textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        </div>
    </script>
    <template id="m_video">
        <div class="m-video-container">
            <div class="video-inner">
                <div v-if="!isVideoLoad" class="play-container" @click="loadVideo()">
                    <img v-view="poster" class="poster-img" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                    <img src="{{ fct_cdn('/img/mobile/video_play.png') }}" class="poster-play" />
                </div>
                <video class="m-video" :src="url" :id="id" preload="metadata" controls v-else></video>
            </div>
        </div>
    </template>
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.artist = {!! json_encode($artist, JSON_UNESCAPED_UNICODE) !!};
        config.artistPage_url = "{{ url('artists/' . $artist->id, [], env('APP_SECURE')) }}";
        config.artistWorks_url = "{{ url('artists/' . $artist->id . '/products', [], env('APP_SECURE')) }}";
        config.artistChat_url = "{{ url('artists/' . $artist->id . '/comments', [], env('APP_SECURE')) }}";
        config.chat_url = "{{ url('artists/' . $artist->id . '/comments', [], env('APP_SECURE')) }}";
    </script>
    <script src="{{ fct_cdn('/js/mobile/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/hammer.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/artist.js') }}"></script>
    {!! wechat_share($share) !!}
    <script>
        var _mtac = {};
        (function() {
            var mta = document.createElement("script");
            mta.src = "https://pingjs.qq.com/h5/stats.js?v2.0.2";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500500357");
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        })();
    </script>
@endsection