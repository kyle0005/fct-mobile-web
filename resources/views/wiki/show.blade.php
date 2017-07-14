@extends("layout")

@section("title", $title)
@section('content')
    <div class="detail-container">
        <head-top></head-top>

        <div class="tabs">
            <section class="pug-container">
                {{ $entry->description }}
            </section>
            <section class="spec">
                <ul class="others">
                @foreach($entry->productList as $product)
                    <li>
                        <a href="javascript:;" class="item">
                            <img src="{{ $product->defaultImage }}">
                            <span class="p-title">{{ $product->name }}</span>
                        </a>
                    </li>
                @endforeach
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
@endsection