@extends("layout")
@section("title", $title)
@section('content')
    <div class="share-container" id="share" v-cloak>
        <section class="top">
            <div class="inner">
                <div class="item sort">
                    <select class="sel" v-model="sortsel" @change="sel">
                        <option v-for="(item, index) in sort" :value="index">@{{ item }}</option>
                    </select>
                </div>
                <div class="item category">
                    <select class="sel" v-model="categary" @change="cate">
                        <option v-for="(item, index) in productsType" :value="item.code">@{{ item.name }}</option>
                    </select>
                </div>
                <div class="item search">
                    <a href="javascript:;" class="search-link" @click="subSearch">
                        <i class="fa fa-search"></i>
                    </a>
                    <input type="search" class="search-input" placeholder="宝贝名称" v-model="search">
                    <a href="javascript:;" class="fork-link" @click="clear">
                        <i class="fa fa-times-circle"></i>
                    </a>
                </div>
            </div>
        </section>
        <ul class="list">
            <li>
                <a href="{{ url('/') .'?' . env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}" class="link">
                    <span class="left">
                      <img src="/images/resource/pro01.png">
                    </span>
                    <span class="center">
                      <span class="title">表标题壶</span>
                      <span class="t2">紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶</span>
                    </span>
                    <span class="right"><img src="/images/share.png"></span>
                </a>
            </li>
        </ul>
        <ul class="list" v-load-more="nextPage" type="1">
            <li v-for="(item, index) in shareList">
                <a :href="'/products/' + item.id + '{{ '?' . env('SHARE_SHOP_ID_KEY') . '=' . $member->shopId }}'" class="link">
                    <span class="left">
                      <img :src="item.defaultImage">
                    </span>
                    <span class="center">
                      <span class="title">@{{ item.name }}</span>
                    <span class="t1" v-if="item.price instanceof Array">价格：￥@{{ item.price[0] }}&sim;￥@{{ item.price[1] }}</span>
                      <span class="t1" v-else>价格：￥@{{ item.price }}</span>
                      <span class="t2" v-if="item.commission instanceof Array">利润：<strong class="pri">￥@{{ item.commission[0] }}&sim;￥@{{ item.commission[1] }}</strong></span>
                      <span class="t2" v-else>利润：<strong class="pri">￥@{{ item.commission }}</strong></span>
                    </span>
                    <span class="right"><img src="/images/share.png"></span>
                </a>
            </li>
        </ul>
        <footer class="loader_more" v-show="preventRepeatReuqest">正在加载更多...</footer>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
            </section>
        </div>
    </template>
@endsection
@section('javascript')
    <script>
        config.shareUrl = "{{ url('settings/share') }}";
        config.sort = ['综合排序', '人气最高', '利润最高'];
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
        config.share = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="/js/common/tools.js"></script>
    <script src="/js/share.js"></script>
@endsection