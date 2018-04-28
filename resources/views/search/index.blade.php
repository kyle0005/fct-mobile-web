@extends("layout")
@section('content')
    <div class="isearch-container" id="isearch" v-cloak>
        <section class="search-container">
            <div class="inner">
                <img src="{{ fct_cdn('/img/mobile/logo2.png') }}" class="logo">
                <input type="search" class="search-input" placeholder="宝贝名称 守艺人名字 壶型" v-model="search">
                <a href="javascript:;" class="search-link" @click="subSearch">
                    <i class="fa fa-search"></i>
                </a>
            </div>
        </section>
        <section class="content">
            <ul class="list">
                <li class="item" v-for="(item, index) in isearch"
                    :class="{'artist-n':item.fromType==='artist'&&!item.extras,'artist-t':item.fromType==='artist'&&item.extras,category:item.fromType==='category',product:item.fromType==='product'}">
                    <a :href="'{{ url('artists', [], env('APP_SECURE')) }}/' + item.id" class="link" v-if="item.fromType=='artist'">
                        <img :src="item.defaultImage" class="img">
                        <span class="con">
                            <span class="name">@{{ item.name }}<span v-if="item.extras">(@{{ item.extras.birthday }})</span></span>
                            <span class="text overTextH3" v-if="!item.extras">@{{ item.intro }}</span>
                            <span class="text overTextH3" v-if="item.extras">职称：@{{ item.extras.title }}</span>
                            <span class="text overTextH3" v-if="item.extras">专业：@{{ item.extras.major }}</span>
                            <span class="text overTextH3" v-if="item.extras">评审日期：@{{ item.extras.reviewDate }}</span>
                          </span>
                    </a>

                    <a :href="'{{ url('wiki/item', [], env('APP_SECURE')) }}?from_type=category&from_id=' + item.id" class="link" v-if="item.fromType=='category'">
                        <img :src="item.defaultImage" class="img">
                        <span class="con">
                            <span class="name">@{{ item.name }}</span>
                            <span class="text overTextH3">@{{ item.intro }}</span>
                          </span>
                    </a>

                    <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="link" v-if="item.fromType=='product'">
                        <img :src="item.defaultImage" class="img">
                        <span class="con">
                            <span class="name">@{{ item.name }}</span>
                            <span class="text overTextH3">@{{ item.intro }}</span>
                            <span class="price"><small>￥</small>@{{ item.extras.salePrice }}</span>
                          </span>
                    </a>
                    <div class="btn-container" v-if="item.fromType=='product'">
                        <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="btn">立即购买</a>
                    </div>
                </li>


                <!--<li class="item artist-n">
                  <a href="javascript:;" class="link">
                    <img src="{{ fct_cdn('/img/mobile/resource/pro01.png') }}" class="img">
                    <span class="con">
                      <span class="name">顾景舟</span>
                      <span class="text overTextH3">简介：简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介</span>
                    </span>
                  </a>
                </li>
                <li class="item artist-t">
                  <a href="javascript:;" class="link">
                    <img src="{{ fct_cdn('/img/mobile/resource/pro01.png') }}" class="img">
                    <span class="con">
                      <span class="name">顾景舟(1915-～～)</span>
                      <span class="text overTextH3">职称：中国工艺美术师</span>
                      <span class="text overTextH3">专业：制壶</span>
                      <span class="text overTextH3">评审日期：2015年09月09日</span>
                    </span>
                  </a>
                </li>
                <li class="item category">
                  <a href="javascript:;" class="link">
                    <img src="{{ fct_cdn('/img/mobile/resource/pro01.png') }}" class="img">
                    <span class="con">
                      <span class="name">半月</span>
                      <span class="text overTextH3">简介：简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介简介</span>
                    </span>
                  </a>
                </li>
                <li class="item product">
                  <a href="javascript:;" class="link">
                    <img src="{{ fct_cdn('/img/mobile/resource/pro01.png') }}" class="img">
                    <span class="con">
                      <span class="name">梅花信xx 顾景舟</span>
                      <span class="text overTextH3">品质一流 xxxxxx</span>
                      <span class="price"><small>￥</small>234.00</span>
                    </span>
                  </a>
                  <div class="btn-container">
                    <a href="javascript:;" class="btn">立即购买</a>
                  </div>
                </li>-->
            </ul>
        </section>
    </div>
@endsection
@section('javascript')
    <script>
        config.isearch = {!! json_encode($entities, JSON_UNESCAPED_UNICODE) !!};
        config.searchUrl = "{{ url('search', [], env('APP_SECURE')) }}?keyword=";
    </script>
    <script src="{{ fct_cdn('/js/mobile/index_search.js') }}"></script>
@endsection