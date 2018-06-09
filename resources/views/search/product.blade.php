@extends("layout")
@section('content')
<div class="isearchn-container" id="isearch" v-cloak>
  <section class="search-container">
    <div class="inner-container">
      <div class="search-inp">
        <div class="inner">
            <a href="{{ url('/', [], env('APP_SECURE')) }}">
              <img src="{{ fct_cdn('/img/mobile/search_logo.png')}}" class="logo">
          </a>
          <input type="search" class="search-input" placeholder="" v-model="search">
          <a href="javascript:;" class="search-link" @click="subSearch">
            <i class="fa fa-search"></i>
          </a>
        </div>
      </div>
      <div class="search-attrs">
        <div class="items">
          <a href="javascript:;" class="link" @click="toggle(0)">
            <span class="txt">综合</span>
            <img src="{{ fct_cdn('img/mobile/arr_down.png')}}" class="arr">
          </a>
        </div>
        <div class="items">
          <a href="javascript:;" class="link" @click="toggle(1)">
            <span class="txt">作者</span>
            <img src="{{ fct_cdn('img/mobile/arr_down.png')}}" class="arr">
          </a>
        </div>
        <div class="items">
          <a href="javascript:;" class="link" @click="toggle(2)">
            <span class="txt">价格</span>
            <img src="{{ fct_cdn('img/mobile/arr_down.png')}}" class="arr">
          </a>
        </div>
        <div class="items">
          <a href="javascript:;" class="link" @click="toggle(3)">
            <span class="txt">容量</span>
            <img src="{{ fct_cdn('img/mobile/arr_down.png')}}" class="arr">
          </a>
        </div>
        <div class="items">
          <a href="javascript:;" class="link" @click="toggle(4)">
            <i class="fa fa-bars"></i>
          </a>
        </div>
        <div class="sorts-pop">
          <div class="aside" :class="{open:open,docked:docked}" @click="toggle(-1)">
            <div class="container">
              <div class="head-sorts" v-if="showPop==0" @click.stop="">
                <ul class="types">
                  <li class="types-item" v-for="(types, index) in sorts" :class="{chosen:index===sort_tab}"
                      @click="sortsV(types, index)">
                    @{{ types.name }}
                  </li>
                </ul>
              </div>
              <div class="head-artists" v-if="showPop==1" @click.stop="">
                <ul class="types">
                  <li class="types-item" v-for="(types, index) in artists" :class="{chosen:index===art_tab}"
                      @click="artistsV(types, index)">
                    @{{ types.name }}
                  </li>
                </ul>
              </div>
              <div class="head-priceSorts" v-if="showPop==2" @click.stop="">
                <div class="inner">
                  <div class="de">
                    <span class="txt">筛选：</span><input type="text" class="pri-inp" placeholder="最低价" v-model="lowpri_cache"><span
                    class="mark">─</span><input type="text" class="pri-inp" placeholder="最高价" v-model="highpri_cache">
                  </div>
                  <div class="so">
                    <span class="txt">排序：</span><span class="so-pri"
                                                      v-for="(item, index) in priceSorts"
                                                      :class="{chosen:index===pri_cache_tab}"
                                                      @click="priceSortsV(index)">@{{ item.name }}</span>
                  </div>
                  <div class="btn-container">
                    <a href="javascript:;" class="btn" @click="priceSortsVOK()">确认</a>
                  </div>
                </div>
              </div>
              <div class="head-volumes" v-if="showPop==3" @click.stop="">
                <div class="inner">
                  <div class="de">
                    <span class="txt">筛选：</span><input type="text" class="pri-inp" placeholder="最小容量" v-model="lowvol_cache"><span
                    class="mark">─</span><input type="text" class="pri-inp" placeholder="最大容量" v-model="highvol_cache">
                  </div>
                  <div class="so clearfix">
                    <span class="txt">区域：</span>
                    <div class="choose">
                      <span class="so-pri" v-for="(item, index) in volumes" :class="{chosen:index===vol_cache_tab}"
                            @click="volumesV(index)">@{{ item.min === 0 ? "" : item.min }}<span v-if="item.min !== 0 && item.max !== 0">-</span>@{{ item.max === 0 ? "" : item.max}}CC<span v-if="item.min === 0">以下</span><span v-if="item.max === 0">以上</span></span>
                    </div>

                  </div>
                  <div class="btn-container">
                    <a href="javascript:;" class="btn" @click="volumesVOK()">确认</a>
                  </div>
                </div>
              </div>
              <div class="head-top" v-if="showPop==4">
                <ul class="types">
                  <li class="item" v-for="(types, index) in categorys" :class="{chosen:index===cat_tab}"
                      @click="categorysV(types, index)">
                    <span>@{{ types.name }}</span>
                    <i class="fa fa-angle-right"></i>
                  </li>
                </ul>
                <ul class="lines clearfix">
                    <li class="item">
                        <a href="{{ url('auction', [], env('APP_SECURE')) }}">
                            <img src="{{ fct_cdn('/img/mobile/search_auction.png')}}">
                            <span>拍卖</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ url('artists', [], env('APP_SECURE')) }}">
                            <img src="{{ fct_cdn('/img/mobile/search_artist.png')}}">
                            <span>守艺师</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ url('wiki', [], env('APP_SECURE')) }}">
                            <img src="{{ fct_cdn('/img/mobile/search_en.png')}}">
                            <span>百科</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ url('welcome', [], env('APP_SECURE')) }}">
                            <img src="{{ fct_cdn('/img/mobile/search_brand.png')}}">
                            <span>品牌理念</span>
                        </a>
                    </li>
                </ul>
              </div>
            </div>
            <div class="cover" @click="toggle(-1)"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <ul class="list" v-load-more="nextPage" type="1" v-if="result && result.length > 0">
      <li class="item product" v-for="(item, index) in result">
          <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="link">
          <img :src="item.defaultImage" class="img">
          <span class="con">
            <span class="name overText">@{{ item.title }}</span>
            <span class="text overText">@{{ item.subTitle }}</span>
            <span class="volumes"><span class="volumes-b">@{{ item.volumes[0] }}CC</span><span v-if="item.volumes.length>1">&nbsp;─&nbsp;</span><span class="volumes-b" v-if="item.volumes.length>1">@{{ item.volumes[1] }}CC</span></span>
            <span class="price">@{{ item.stockCount > 0 ? "有货" : "无货" }}</span>
          </span>
        </a>
        <div class="btn-container">
            <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="btn" v-if="item.stockCount>0">我要购买</a>
            <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + item.id" class="btn" v-else>我去看看</a>
        </div>
      </li>
    </ul>
    <no-data v-if="nodata" :imgurl="'{{ fct_cdn('img/mobile/no_data.png')}}'" :text="'当前没有相关数据哟~'"></no-data>
    <img src="{{ fct_cdn('img/mobile/img_loader_s.gif" class="list-loader" v-if="listloading">
    <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
  </section>
</div>
@endsection
@section('javascript')
    <script>
        config.search =  {!! json_encode($result->search, JSON_UNESCAPED_UNICODE) !!};
        config.filter =  {!! json_encode($result->filter, JSON_UNESCAPED_UNICODE) !!};
        config.result =  {!! json_encode($result->products, JSON_UNESCAPED_UNICODE) !!};
        config.url = "{{ url('products', [], env('APP_SECURE')) }}";
    </script>
    <script src="{{ fct_cdn('/js/mobile/index_search_n.js') }}"></script>
    {!! wechat_share($share) !!}
@endsection