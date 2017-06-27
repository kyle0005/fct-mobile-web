@extends("layout")

@section("title", $title)
@section('content')
    <div id="main">
        <div class="main-container">
            <head-top @changelist="getprolist" :msg="msg"></head-top>
            <section class="cat-container">
                <ul class="category clearfix">
                    <li class="item" v-for="(ranks, index) in ranks_list" @click="change(index)">
                        <img :src= "img_url + '/category1.png'">
                        <span>@{{ ranks }}</span>
                    </li>
                </ul>
            </section>
            <div class="prolist-container">
                <ul class="prolist" v-if="pro_list.length">
                    <li class="item" v-for="item in pro_list">
                        <a href="javascript:;">
            <span class="pro-main">
              <img :src="item.default_pic">
            </span>
                            <span class="title">@{{ item.title }}</span>
                            <span class="description">@{{ item.description }}</span>
                            <span class="pro-lists">
            <span class="imgs">
              <img :src="item.pics[0]">
            </span>
            <span class="imgs">
              <img :src="item.pics[1]">
            </span>
            <span class="imgs">
              <img :src="item.pics[2]">
            </span>
            <span class="imgs">
              <img :src="item.pics[3]">
            </span>
            </span>
                            <span class="ops">
              <img :src="img_url + '/clickAmount.png'"><span>@{{ item.clickAmount }}</span>
              <img :src="img_url + '/saleAmount.png'"><span>@{{ item.saleAmount }}</span>
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
                        <li class="item" v-for="(types, index) in typeList" @click="change(index)">
                            <span>@{{ types }}</span>
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
            "productsType": [
                "全部",//{name:aaa,code:xxx}
                "圆器",
                "方器",
                "花器",
                "筋纹器"
            ],
            "productsRank": [
                "登堂入室",
                "略有小成",
                "炉火纯青",
                "出神入化",
                "登峰造极"
            ],
            "products": [
                {
                    "id": 0,
                    "type_id": 1,
                    "type_name": "圆器",
                    "rank_id": 0,
                    "rank_name": "登堂入室",
                    "name": "束云茶叶罐001",
                    "artist": "李某某001",
                    "title": "【精雕细刻】束云茶叶罐001",
                    "description": "描述文字。。。。。001。",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 99999999,
                    "saleAmount": 11111111
                },
                {
                    "id": "1",
                    "type_id": 1,
                    "type_name": "圆器",
                    "rank_id": 1,
                    "rank_name": "略有小成",
                    "name": "束云茶叶罐002",
                    "artist": "李某某002",
                    "title": "【精雕细刻】束云茶叶罐002",
                    "description": "描述文字。。。。。。002",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "2",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 0,
                    "rank_name": "登堂入室",
                    "name": "束云茶叶罐003",
                    "artist": "李某某003",
                    "title": "【精雕细刻】束云茶叶罐003",
                    "description": "描述文字。。。。。。003",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 88888888,
                    "saleAmount": 22222222
                },
                {
                    "id": "3",
                    "type_id": 3,
                    "type_name": "花器",
                    "rank_id": 3,
                    "rank_name": "出神入化",
                    "name": "束云茶叶罐004",
                    "artist": "李某某004",
                    "title": "【精雕细刻】束云茶叶罐004",
                    "description": "描述文字。。。。。。004",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 77777777,
                    "saleAmount": 22222222
                },
                {
                    "id": "4",
                    "type_id": 1,
                    "type_name": "圆器",
                    "rank_id": 2,
                    "rank_name": "炉火纯青",
                    "name": "束云茶叶罐005",
                    "artist": "李某某005",
                    "title": "【精雕细刻】束云茶叶罐005",
                    "description": "描述文字。。。。。。005",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "5",
                    "type_id": 1,
                    "type_name": "圆器",
                    "rank_id": 0,
                    "rank_name": "登堂入室",
                    "name": "束云茶叶罐006",
                    "artist": "李某某006",
                    "title": "【精雕细刻】束云茶叶罐006",
                    "description": "描述文字。。。。。。006",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "6",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 0,
                    "rank_name": "登堂入室",
                    "name": "束云茶叶罐007",
                    "artist": "李某某007",
                    "title": "【精雕细刻】束云茶叶罐007",
                    "description": "描述文字。。。。。。007",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "7",
                    "type_id": 1,
                    "type_name": "圆器",
                    "rank_id": 3,
                    "rank_name": "出神入化",
                    "name": "束云茶叶罐008",
                    "artist": "李某某008",
                    "title": "【精雕细刻】束云茶叶罐008",
                    "description": "描述文字。。。。。。008",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "8",
                    "type_id": 3,
                    "type_name": "花器",
                    "rank_id": 0,
                    "rank_name": "登堂入室",
                    "name": "束云茶叶罐009",
                    "artist": "李某某009",
                    "title": "【精雕细刻】束云茶叶罐009",
                    "description": "描述文字。。。。。。009",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "9",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 4,
                    "rank_name": "登峰造极",
                    "name": "束云茶叶罐010",
                    "artist": "李某某010",
                    "title": "【精雕细刻】束云茶叶罐010",
                    "description": "描述文字。。。。。。010",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "10",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 4,
                    "rank_name": "登峰造极",
                    "name": "束云茶叶罐011",
                    "artist": "李某某011",
                    "title": "【精雕细刻】束云茶叶罐011",
                    "description": "描述文字。。。。。。011",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "11",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 1,
                    "rank_name": "略有小成",
                    "name": "束云茶叶罐012",
                    "artist": "李某某012",
                    "title": "【精雕细刻】束云茶叶罐012",
                    "description": "描述文字。。。。。。012",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "12",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 4,
                    "rank_name": "登峰造极",
                    "name": "束云茶叶罐013",
                    "artist": "李某某013",
                    "title": "【精雕细刻】束云茶叶罐013",
                    "description": "描述文字。。。。。013。",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "13",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 4,
                    "rank_name": "登峰造极",
                    "name": "束云茶叶罐014",
                    "artist": "李某某014",
                    "title": "【精雕细刻】束云茶叶罐014",
                    "description": "描述文字。。。。。014。",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "14",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 4,
                    "rank_name": "登峰造极",
                    "name": "束云茶叶罐014",
                    "artist": "李某某014",
                    "title": "【精雕细刻】束云茶叶罐014",
                    "description": "描述文字。。。。。014。",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "15",
                    "type_id": 4,
                    "type_name": "筋纹器",
                    "rank_id": 4,
                    "rank_name": "登峰造极",
                    "name": "束云茶叶罐014",
                    "artist": "李某某014",
                    "title": "【精雕细刻】束云茶叶罐014",
                    "description": "描述文字。。。。。014。",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                },
                {
                    "id": "16",
                    "type_id": 2,
                    "type_name": "方器",
                    "rank_id": 2,
                    "rank_name": "炉火纯青",
                    "name": "束云茶叶罐015",
                    "artist": "李某某015",
                    "title": "【精雕细刻】束云茶叶罐015",
                    "description": "描述文字。。。。。。015",
                    "default_pic": "/images/resource/imgs.png",
                    "pics": [
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png",
                        "/images/resource/imgs.png"
                    ],
                    "clickAmount": 234123,
                    "saleAmount": 1000
                }
            ],
        }
    </script>
    <script src="js/head.js"></script>
    <script src="js/main.js"></script>
@endsection