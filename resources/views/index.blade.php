@extends("layout")

@section("title", $title)
@section('content')
    <div id="main">
        <div class="main-container">
            <head-top @changelist="getprolist" :msg="msg"></head-top>
            <section class="cat-container">
                <ul class="category clearfix">
                    <li class="item" v-for="(ranks, index) in ranks_list" @click="change('', ranks.id)">
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
                              <img :src="img_url + '/clickAmount.png'"><span>@{{ item.viewCount }}</span>
                              <img :src="img_url + '/saleAmount.png'"><span>@{{ item.commentCount }}</span>
                            </span>
                        </a>
                    </li>
                </ul>
                <ul class="prolist" v-else>
                    <li class="noData">
                        没有数据......
                    </li>
                </ul>
            </div>
            <div class="copyright-container">
                <div class="info">
                    Copyright&nbsp;&copy;&nbsp;2017&nbsp;,fangcuntang&nbsp;Co.,Ltd.All&nbsp;Rights&nbsp;Reserved.<br>
                    宜兴方寸堂文化传媒有限公司&ensp;|&ensp;<a href="" class="law">法律声明</a><br>
                    <span class="bottom">沪ICP备12022967号-1&nbsp;沪公网安备11010502025474</span>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script src="js/api/index.js"></script>
    <script type="text/x-template" id="head_top">
        <header class="head-container">
            <ul class="nav">
                <li class="toggle" @click="toggle()">
                    <i class="fa fa-bars"></i>
                </li>
                <li class="logo" @click="toIndex()">
                    <img :src="img_url + '/logo.png'">
                </li>
                <li class="user" @click="toLogin()">
                    <i class="fa fa-user-circle-o"></i>
                </li>
            </ul>
            <div class="aside" :class="{open:open,docked:docked}" @click="toggle()">
                <div class="container">
                    <ul class="types">
                        <li class="item" v-for="(types, index) in typeList" @click="change(types.code, '')">
                            <span>@{{ types.name }}</span>
                            <i class="fa fa-angle-right"></i>
                        </li>
                    </ul>

                    <ul class="lines clearfix">
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu1.png'">
                                <span>合作艺师</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu2.png'">
                                <span>百科</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu3.png'">
                                <span>个性定制</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu4.png'">
                                <span>APP下载</span>
                            </a>
                        </li>
                        <li class="item">
                            <a href="javascript:;">
                                <img :src="img_url + '/menu5.png'">
                                <span>品牌理念</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
    </script>
    <script>
        var config = {
            "productsType": {!! $categories !!},
            "productsRank": {!! $levels !!},
            "products": {!! $products !!},
        }
    </script>
    <script src="js/head.js"></script>
    <script src="js/main.js"></script>
@endsection