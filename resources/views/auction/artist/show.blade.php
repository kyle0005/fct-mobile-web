@extends("layout")
@section('content')
    <div class="auctionartist-contianer" id="auctionartist" v-cloak>
        <section class="content" :class="{'top-max':!titleshow,'top-min':titleshow}">
            <div class="intro">
                      <span class="photo">
                          <img :src="artistsingle.image">
                      </span>
                <span class="intro-info">
                      <span class="intro-name">@{{ artistsingle.name }}&nbsp;-&nbsp;<span class="v-title">@{{ artistsingle.title }}</span></span>
                      <span class="intro-content">@{{ artistsingle.intro }}</span>
                    </span>
            </div>
        </section>
        <section class="text-container" v-html="artistsingle.description"></section>
        <section class="comment" v-if="artistsingle.products && artistsingle.products.length > 0">
            <div class="lines">
                <div class="text">相关宝贝</div>
            </div>
            <ul class="others">
                <li v-for="p in artistsingle.products">
                    <a :href="'{{ url('products', [], env('APP_SECURE')) }}/' + p.id" class="item">
                        <img v-view="p.defaultImage" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                        <span class="p-title">@{{ p.name }}</span>
                    </a>
                </li>
            </ul>
        </section>
        <section class="comment" v-if="artistsingle.isCooperation == 2">
            <a :href="'{{ url('artists', [], env('APP_SECURE')) }}/' + artistsingle.id" class="for-more">点击了解更多》</a>
        </section>
    </div>
@endsection
@section('javascript')
    <script>
        config.artist = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{fct_cdn('/js/mobile/auction_artist.js')}}"></script>
@endsection