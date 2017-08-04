@extends("layout")

@section('content')
    <div class="art-container" id="artist">
        <head-top></head-top>
        <section class="live" id="live_container">
            <div class="inner">
                <img :src="artist.banner">
                <div class="info join-num">@{{ artist.followCount }}人关注</div>
            </div>
        </section>
        <section class="nav-bar">
            <ul class="art-tab">
                <li class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="linkTo(index)">
                    <a href="javascript:;">
                        @{{ item }}
                    </a>
                </li>
            </ul>
        </section>
        <keep-alive>
            <component :is="currentView">
            </component>
        </keep-alive>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
                <!--<div class="confrim" @click="close">确认</div>-->
            </section>
        </div>
    </template>
@endsection

@section('javascript')
    {{--艺术家动态--}}
    <script type="text/x-template" id="live">
        <div class="tabs">
            <section class="ptop">
                <div class="text">@{{ top.content }}</div>
                <div class="media" >
                    <video id="video_top" class="video-js vjs-big-play-centered" controls v-if="top.videoUrl != ''"></video>
                    <ul class="img-list" v-if="topImg">
                        <li v-for="imgs in top.images">
                            <img :src="imgs">
                        </li>
                    </ul>
                </div>
            </section>
            <ul class="news" v-load-more="nextPage" type="1" v-if="liveList && liveList.length > 0">
                <li class="item" v-for="(item, index) in liveList">
                    <div class="text">@{{ item.content }}</div>
                    <div class="media">
                        <video :id="'video_' + index" class="video-js vjs-big-play-centered" controls v-if="item.videoUrl != ''"></video>
                        <ul class="img-list" v-if="item.images.length > 0">
                            <li v-for="(img, i) in item.images">
                                <img :src="img">
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>

            <ul class="prolist" v-else>
                <li class="noData">
                    <img src="/images/no_data.png">
                    <span class="no">当前没有相关数据哟~</span>
                </li>
            </ul>

            <footer class="loader_more" v-show="preventRepeatReuqest">正在加载更多...</footer>
        </div>
    </script>
    {{--艺术家作品--}}
    <script type="text/x-template" id="works">
        <div class="tabs">
            <ul class="pro-list" v-if="workslist && workslist.length > 0">
                <li v-for="(item, index) in workslist">
                    <div class="inner">
                        <div class="left">
                            <img :src="item.defaultImage">
                        </div>
                        <div class="right">
                            <div class="title overText">@{{ item.name }}</div>
                            <div class="text overTextH2">@{{ item.intro }}</div>
                            <div class="price overText"><small class="pri-mark">￥</small>@{{ item.price }}</div>
                            <div class="btn-container">
                                <a :href="'{{ url('products') }}/' + item.id" class="btn">我要购买</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <ul class="prolist" v-else>
                <li class="noData">
                    <img src="/images/no_data.png">
                    <span class="no">当前没有相关数据哟~</span>
                </li>
            </ul>
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
                                <img :src="item.headPortrait">
                            </div>
                            <div class="user">@{{ item.userName }}</div>
                            <div class="time">@{{ item.createTime }}</div>
                        </div>
                        <div class="context">@{{ item.content }}</div>
                        <div class="reply-container" v-if="item.replyContent.length > 0">
                            <div class="icon"><img src="/images/reply.png"></div>
                            <div class="reply" v-for="(reply, index) in item.replyContent">@{{ reply.content }}</div>
                        </div>
                    </div>
                </li>
            </ul>

            <ul class="prolist" v-else>
                <li class="noData">
                    <img src="/images/no_data.png">
                    <span class="no">当前没有相关数据哟~</span>
                </li>
            </ul>

            <footer class="loader_more" v-show="preventRepeatReuqest">正在加载更多...</footer>
            <section class="sub-chat">
                <a href="javascript:;" class="sub" @click="pop()">
                    <span class="img">
                      <img src="/images/reply_chat.png">
                    </span>
                    <span class="txt">请输入要表达的信息</span>
                </a>
                <div class="aside" :class="{open:open,docked:docked}" @click.prevent="pop()">
                    <div class="container" @click.stop="">
                        <form id="chat_form">
                            <div class="inner">
                                <div class="top">
                                    <a href="javascript:;" class="cancel" @click.prevent="pop()">取消</a>
                                    <span class="title">我来聊两句</span>
                                    <a href="javascript:;" class="send" @click.prevent="send()">发送</a>
                                </div>
                                <textarea class="textarea" v-model="message"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
            <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
        </div>
    </script>

    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.artist = {!! json_encode($artist, JSON_UNESCAPED_UNICODE) !!};
        config.artistPage_url = "{{ url('artists/' . $artist->id) }}";
        config.artistWorks_url = "{{ url('artists/' . $artist->id . '/products') }}";
        config.artistChat_url = "{{ url('artists/' . $artist->id . '/comments') }}";
        config.chat_url = "{{ url('artists/' . $artist->id . '/comments') }}";
    </script>
    <script src="{{ fct_cdn('/js/common/tools.js') }}"></script>
    <script src="{{ fct_cdn('/js/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/video.js') }}"></script>
    <script src="{{ fct_cdn('/js/artist.js') }}"></script>

    {!! wechat_share($share) !!}
    <script>
        var _mtac = {};
        (function() {
            var mta = document.createElement("script");
            mta.src = "http://pingjs.qq.com/h5/stats.js?v2.0.2";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500500357");
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        })();
    </script>
@endsection