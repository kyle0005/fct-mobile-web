@extends("layout")

@section("title", $title)
@section('content')
    <div class="detail-container">
        <head-top></head-top>

        <div class="tabs">
            <section class="pug-container">
                {!! $entry->description !!}
            </section>
            <section class="spec">
                <ul class="others">
                @if ($entry->productList)
                @foreach($entry->productList as $product)
                    <li>
                        <a href="{{ url('products/'. $product->id) }}" class="item">
                            <img src="{{ $product->defaultImage }}">
                            <span class="p-title">{{ $product->name }}</span>
                        </a>
                    </li>
                @endforeach
                @endif
                </ul>
            </section>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        var config = {
            "productsType": {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!}
        }
    </script>
    <script src="/js/head.js"></script>

    {!! \App\FctCommon::weChatJs($share) !!}
    <script>
        var _mtac = {};
        (function() {
            var mta = document.createElement("script");
            mta.src = "http://pingjs.qq.com/h5/stats.js?v2.0.2";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500500357");
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        })();
    </script>
@endsection