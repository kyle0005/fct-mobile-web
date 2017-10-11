@extends("layout")
@section('content')
    <div class="help-container" id="help" v-cloak>
        <router-view></router-view>
    </div>
    <template id="articlecate">
        <section class="user-sec">
            <div class="search-container">
                <a href="javascript:;" class="inner" @click="pop()">
                    <i class="fa fa-search"></i>&nbsp;请输入问题关键词
                </a>
                <div class="bg" :class="{show: show}" @click.prevent="pop()">
                    <div class="search-box"  @click.stop="">
                        <div class="inner clearfix">
                            <a href="javascript:;" class="search" @click="search()">
                                <i class="fa fa-search"></i>
                            </a>
                            <input type="text" v-focus="" placeholder="请输入问题关键词" class="keywords" v-model="keywords">
                            <a href="javascript:;" class="fork-link" @click="clear()" v-if="keywords !== ''">
                                <i class="fa fa-times-circle"></i>
                            </a>
                            <a href="javascript:;" @click="pop()" class="cancel">取消</a>
                        </div>
                    </div>
                </div>
            </div>
            <ul class="funcs-list" v-if="searchlist.length <= 0">
                <li v-for="(item, index) in articleCategories" :class="{br: item.hasBr == 1}">
                    <router-link v-if="item.articleId == 0 && item.articles.length > 0"
                                 :to="{ name: 'list', query: { id:item.id }}"
                                 class="link">
                          <span class="img-container item">
                            <img :src="item.image">
                          </span>
                        <span class="item t">@{{ item.name }}</span>
                        <span class="wei-arrow-right"></span>
                    </router-link>
                    <router-link v-else :to="{ name: 'detail', query: { articleId: item.articleId }}" class="link">
                          <span class="img-container item">
                            <img :src="item.image">
                          </span>
                        <span class="item t">@{{ item.name }}</span>
                        <span class="wei-arrow-right"></span>
                    </router-link>
                </li>
            </ul>
            <ul class="funcs-list" v-else>
                <li v-for="(obj, i) in searchlist">
                    <router-link :to="{ name: 'detail', query: { articleId: obj.id }}" class="link">
                        <span class="item">@{{ obj.title }}</span>
                        <span class="wei-arrow-right"></span>
                    </router-link>
                </li>
            </ul>
        </section>
    </template>
    <template id="articlelist">
        <section class="user-sec">
            <ul class="funcs-list">
                <li v-for="(item, index) in articles">
                    <router-link :to="{ name: 'detail', query: { articleId: item.id }}" class="link">
                        <span class="item">@{{ item.name }}</span>
                        <span class="wei-arrow-right"></span>
                    </router-link>
                </li>
            </ul>
        </section>
    </template>
    <template id="articledetail">
        <section class="service">
            <div class="service-container" v-html="article.content">
            </div>
        </section>
    </template>
@endsection
@section('javascript')
    <script>
        config.articleCategories = {!! json_encode($articleCategories, JSON_UNESCAPED_UNICODE) !!};
        config.articles = {!! json_encode($articles, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/vue-router.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/help.js') }}"></script>
    {!! wechat_share($share) !!}
@endsection