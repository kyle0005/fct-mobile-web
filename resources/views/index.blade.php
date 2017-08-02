@extends("layout")

@section("title", $title)
@section('content')
    <div id="main">
        <div class="main-container">
            <head-top @changelist="getprolist" :isindex="isindex"></head-top>
            <section class="cat-container">
                <ul class="category clearfix">
                    <li class="item" v-for="(ranks, index) in ranks_list" @click="getprolist('', ranks.id)">
                        <img :src= "ranks.img">
                        <span>@{{ ranks.name }}</span>
                    </li>
                </ul>
            </section>
            <div class="prolist-container">
                <ul class="prolist" v-if="pro_list.length">
                    <li class="item" v-for="item in pro_list">
                        <a :href="'/products/' + item.id">
                            <span class="pro-main"><img :src="item.videoImg"></span>
                            <span class="title">@{{ item.name }}</span>
                            <span class="description">@{{ item.intro }}</span>
                            <span class="pro-lists">
                                <span class="imgs" v-for="image in item.multiImages">
                                  <img :src="image">
                                </span>
                            </span>
                            <span class="ops">
                              <img src="/images/clickAmount.png"><span>@{{ item.viewCount }}</span>
                              <img src="/images/saleAmount.png"><span>@{{ item.commentCount }}</span>
                            </span>
                        </a>
                    </li>
                </ul>

                <ul class="prolist" v-else>
                    <li class="noData">
                        <img src="/images/no_data.png">
                        <span class="no">当前没有相关数据哟~</span>
                    </li>
                </ul>
            </div>
            <div class="copyright-container">
                <div class="info">
                    Copyright&nbsp;&copy;&nbsp;2017&nbsp;,fangcuntang&nbsp;Co.,Ltd.All&nbsp;Rights&nbsp;Reserved.<br>
                    宜兴方寸堂文化传媒有限公司&ensp;|&ensp;<a href="" class="law">法律声明</a><br>
                    <span class="bottom">苏公安备32028202000436号 苏ICP备14043090号-4</span>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    {!! \App\FctCommon::weChatShare($title, $shareUrl, '', '/images/logo.png') !!}
    <script>
        config.isindex = true;
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.productsRank = {!! json_encode($levels, JSON_UNESCAPED_UNICODE) !!};
        config.products = {!! json_encode($products, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="/js/common/tools.js"></script>
    <script src="/js/head.js"></script>
    <script src="/js/main.js"></script>
@endsection