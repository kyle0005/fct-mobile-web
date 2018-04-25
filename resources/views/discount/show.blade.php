@extends("layout")
@section('content')
    <div class="presale-container" id="presale" v-cloak>
        <section class="banner">
            <a href="javascript:;" class="link">
                <img :src="presale.bannerImage">
            </a>
        </section>
        <section class="time">
            <div class="inner">
                距开始仅剩<m-time :end-time="presale.discountTime" :callback="end"></m-time>
            </div>
        </section>
        <section class="list">
            <ul class="ul">
                <li class="item" v-for="(item, index) in presale.productList">
                    <a href="javascript:" class="link">
                        <img :src="item.defaultImage">
                        <span class="pro-con">
            <span class="title">@{{ item.name }}</span>
            <span class="vtitle">@{{ item.subTitle }}</span>
            <span class="price"><small>￥</small>@{{ item.discountPrice }}</span>
            <del class="dprice"><small>￥</small>@{{ item.salePrice }}</del>
          </span>
                    </a>
                    <span class="btn-container">
          <a :href="'url('products', [], env('APP_SECURE'))/' + item.id" class="btn">马上抢购</a>
        </span>

                </li>
            </ul>
        </section>
    </div>
@endsection
@section('javascript')
    <script>
        config.presale = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/presale.js') }}"></script>
@endsection