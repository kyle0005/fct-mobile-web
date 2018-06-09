@extends("layout")
@section('content')
    <div class="entry-container" id="entry" v-cloak>
        <section class="search-container">
            <div class="inner">
                <div class="item search">
                    <a href="javascript:;" class="search-link" @click="subSearch()">
                        <i class="fa fa-search"></i>
                    </a>
                    <input type="search" class="search-input" placeholder="宝贝名称 守艺人名字 壶型" v-model="search">
                    <a href="javascript:;" class="fork-link" @click="clear">
                        <i class="fa fa-times-circle"></i>
                    </a>
                </div>
                <div class="item cart">
                    <a href="{{ url('carts', [], env('APP_SECURE')) }}" class="link">
                        <img src="{{ fct_cdn('/img/mobile/cart_b.png') }}">
                        <span class="nums">@{{ index_data.cartProductCount }}</span>
                    </a>
                </div>
            </div>
        </section>
        <section class="banner" v-if="banners.length > 0">
            <m-swipe swipeid="swipe" ref="banner" :autoplay="0">
                <div v-for="(top, index) in banners" class="swiper-slide" slot="swiper-con">
                    <a :href="top.webUrl" class="link">
                      <span class="img-con">
                        <img :data-src="top.image" class="swiper-lazy silde-img">
                      </span>
                    </a>
                </div>
            </m-swipe>
            <div class="service">
                <div class="items">
                    <img src="{{ fct_cdn('/img/mobile/items.png') }}">100%原人手制
                </div>
                <div class="items">
                    <img src="{{ fct_cdn('/img/mobile/items.png') }}">限量发行
                </div>
                <div class="items">
                    <img src="{{ fct_cdn('/img/mobile/items.png') }}">永久保值换购
                </div>
            </div>
        </section>
        <section class="trance">
            <div class="inner">
                <a href="{{ url('products', [], env('APP_SECURE')) }}" class="items">
                    <img src="{{ fct_cdn('/img/mobile/index_ma.png') }}"><br>紫砂壶
                </a>
                <a href="{{ url('auction', [], env('APP_SECURE')) }}" class="items">
                    <img src="{{ fct_cdn('/img/mobile/index_au.png') }}"><br>拍卖
                </a>
                <a href="{{ url('artists', [], env('APP_SECURE')) }}" class="items">
                    <img src="{{ fct_cdn('/img/mobile/index_ar.png') }}"><br>手艺人
                </a>
                <a href="{{ url('wiki', [], env('APP_SECURE')) }}" class="items">
                    <img src="{{ fct_cdn('/img/mobile/index_en.png') }}"><br>百科
                </a>
            </div>
        </section>
        <section class="presale" v-if="preSales.length > 0">
            <m-swipe swipeid="swipeN" ref="presale" :autoplay="0" :pagination="preSales.length>1" pagination-type="custom">
                <div v-for="(item, index) in preSales" class="swiper-slide" slot="swiper-con">
                    <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.goodsId" class="content">
                        <div class="left">
                            <div class="title">
                                <img src="{{ fct_cdn('/img/mobile/pre_sale.png') }}">
                                <span class="t" v-if="item.advanceSaleDays > 0">预售宝贝</span>
                                <span class="t" v-else>特惠活动</span>
                            </div>
                            <div class="text">距离@{{ item.status === 0 ? '开始': '结束'}}时间</div>
                            <div class="time"><m-time :end-time="item.discountTime" :callback="end"></m-time></div>
                            <div class="tip" v-if="item.advanceSaleDays > 0">@{{ item.advanceSaleDays }}天后发货</div>
                            <div class="tip" v-else>@{{ item.name }}</div>
                        </div>
                        <div class="right">
                            <img :src="item.defaultImage">
                            <div class="t">
                                <span class="s" v-if="item.singleCount > 0">限购@{{ item.singleCount }}件</span>
                                <span class="s" v-else>不限购</span>
                            </div>
                        </div>
                    </a>
                </div>
            </m-swipe>
        </section>


        <section class="newsale">
            <div class="title">新品首发&nbsp;<a href="{{ url('products', [], env('APP_SECURE')) }}?sort=-1"
                                            class="arr-link">更多&nbsp;<span class="arr"></span></a></div>
            <div class="art-list">
                <div class="line">
                    <div class="inner">
                        <div class="comma">
                            <img src="{{ fct_cdn('/img/mobile/comma_l.png') }}"><span class="text">不止不同，美壶不断出新</span><img src="{{ fct_cdn('/img/mobile/comma_r.png') }}">
                        </div>
                        <div class="txt">每一个作品<br>都有打动你的故事</div>
                    </div>
                </div>
            </div>
            <div class="others">
                <ul class="line-list clearfix">
                    <li class="line" v-for="(item, index) in newProduct">
                        <div class="inner">
                            <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="link">
                                <img :src="item.defaultImage" class="photo">
                                <span class="cont">
                                <span class="title overText">@{{ item.name }}</span>
                                <span class="info">
                                  <span class="left overText">@{{ item.artistName }}</span>
                                  <span class="right">@{{ item.volumes[0] }}CC</span>
                                </span>
                              </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

        </section>
        <section class="optimization">
            <div class="title">为你优选 <a href="{{ url('products', [], env('APP_SECURE')) }}"
                                       class="link">更多&nbsp;<span class="arr"></span></a></div>
            <div class="content">
                <div class="others">
                    <ul class="ul clearfix">
                        <li class="pro-item" v-for="(item, index) in preferenceProduct">
                            <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="link">
                                <img :src="item.defaultImage">
                                <span class="sta">
                                    <span class="item right">@{{ item.volumes[0] }}CC</span>
                                </span>
                            </a>
                            <div class="detail">
                                <div class="info">@{{ item.artistName }}《@{{ item.name }}》</div>
                                <div class="time">@{{ item.subTitle }}&nbsp;</div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </section>

        <section class="auction" v-if="auctions.length > 0">
            <div class="title">拍卖<a href="{{ url('auction', [], env('APP_SECURE')) }}" class="link">更多&nbsp;<span class="arr"></span></a></div>
            <div class="content">
                <div class="fir">
                    <a :href="'{{ url('auction', [], env('APP_SECURE')) }}/' + auctions[0].id" class="link">
                        <img v-view="auctions[0].defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                    </a>
                    <div class="sta">
                        <div class="item left" :class="{gray:auctions[0].status!=1, red:auctions[0].status==1}">@{{ auctions[0].statusName }}</div>
                        <div class="item right">@{{ auctions[0].bidCount }}次出价</div>
                    </div>
                </div>
                <div class="others">
                    <ul class="ul clearfix">
                        <li class="pro-item" v-for="(item, index) in auctions_data">
                            <a :href="'{{ url('auction', [], env('APP_SECURE')) }}/'+item.id" class="link">
                                <img v-view="item.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                                <span class="sta">
                                    <span class="item left" :class="{gray:item.status!=1, red:item.status==1}">@{{ item.statusName }}</span>
                                    <span class="item right">@{{ item.bidCount }}次出价</span>
                                  </span>
                            </a>
                            <div class="detail">
                                <div class="info">@{{ item.name }}</div>
                                <div class="time">结拍时间:&nbsp;@{{ item.auctionTime }}</div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </section>

        <section class="artist">
            <div class="title">守艺人&nbsp;<a href="{{ url('artists', [], env('APP_SECURE')) }}"
                                           class="arr-link">更多&nbsp;<span class="arr"></span></a></div>
            <div class="art-list">
                <div class="line des">
                    <div class="inner">
                        <div class="comma">
                            <img src="{{ fct_cdn('/img/mobile/comma_l.png') }}"><span class="text">60+位匠人入驻</span><img src="{{ fct_cdn('/img/mobile/comma_r.png') }}">
                        </div>
                        <div>心手相通<br>载大道与咫尺之器</div>
                    </div>
                </div>
                <div class="line">
                    <div class="inner">
                        <a :href="'{{ url('artists', [], env('APP_SECURE')) }}/'+artists[0].id" class="link">
                            <img v-view="artists[0].defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}" class="photo">
                        </a>
                    </div>
                </div>
            </div>
            <div class="others">
                <ul class="line-list clearfix">
                    <li class="line" v-for="(item, index) in artists_data">
                        <div class="inner">
                            <a :href="'{{ url('artists', [], env('APP_SECURE')) }}/'+item.id" class="link">
                                <img v-view="item.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}" class="photo">
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </section>

        <section class="recommend">
            <div class="title">精选推荐</div>
            <div class="rec-list">
                <div class="line" v-for="(item, index) in recommends">
                    <div class="inner">
                        <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="link">
                            <span class="img-container">
                              <img v-view="item.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}" class="pro-img">
                              <span class="pro-mark">
                                  <small class="marks" :class="'mark-' + (i - 1)" v-for="(i, index) in item.tags">@{{ tagN[i - 1] }}</small>
                              </span>
                            </span>
                            <span class="pro-title overText">@{{ item.artistName }}《@{{ item.name }}》</span>
                            <span class="pro-vtitle overTextH2">@{{ item.subTitle }}</span>
                            <span class="pro-v">容量：<span class="v">@{{ item.volumes[0] }}CC<span v-if="item.volumes.length > 1">&nbsp;~&nbsp;@{{ item.volumes[1] }}CC</span></span></span>
                        </a>
                    </div>
                </div>
            </div>
            <a href="{{ url('products', [], env('APP_SECURE')) }}" class="arr-link">查看更多&nbsp;<span class="arr"></span></a>
        </section>

        <footer class="footer">
            <div class="inner">
                <a href="{{ url('/', [], env('APP_SECURE')) }}" class="link chosen">
                    <img src="{{ fct_cdn('/img/mobile/i_home_d.png') }}"><br>首页
                </a>
                <a href="{{ url('products', [], env('APP_SECURE')) }}" class="link">
                    <img src="{{ fct_cdn('/img/mobile/i_hu_g.png') }}"><br>选壶
                </a>
                <a href="{{ url('artists', [], env('APP_SECURE')) }}" class="link">
                    <img src="{{ fct_cdn('/img/mobile/i_artist_g.png') }}"><br>守艺人
                </a>
                <a href="{{ url('my', [], env('APP_SECURE')) }}" class="link">
                    <img src="{{ fct_cdn('/img/mobile/i_account_g.png') }}"><br>我的
                </a>
            </div>
        </footer>
        <div class="gift-pop" v-if="isADShow">
            <div class="inner">
                <img src="{{ fct_cdn('/img/mobile/gift_show.png') }}">
                <a href="{{ url('invite', [], env('APP_SECURE')) }}" class="link">&nbsp;</a>
                <a href="javascript:;" class="close" @click="closegift()">&nbsp;</a>
            </div>
        </div>
        <a href="{{ url('invite', [], env('APP_SECURE')) }}" class="gift-icon" v-if="!isADShow">
            <img src="{{ fct_cdn('/img/mobile/gift_icon.png') }}">
        </a>
        <transition name="fade">
            <a href="javascript:;" class="top" @click="top()" v-if="showTop">
                <img src="{{ fct_cdn('/img/mobile/top.png') }}">
            </a>
        </transition>
    </div>
@endsection
@section('javascript')
    <script type="text/x-template" id="m_swipe">
        <div class="swiper-container" :class="swipeid">
            <div class="swiper-wrapper">
                <slot name="swiper-con"></slot>
            </div>
            <!-- 分页器 -->
            <div :class="{'swiper-pagination':pagination}"></div>
        </div>
    </script>
    <script>
        config.isADShow = {!! $hasNewVisitor !!};
        config.index_n = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
        config.searchUrl = "{{ url('search', [], env('APP_SECURE')) }}?keyword=";
    </script>
    <script src="{{ fct_cdn('/js/mobile/hammer.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/swiper.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/index_n.js') }}"></script>
    {!! wechat_share($share) !!}
@endsection