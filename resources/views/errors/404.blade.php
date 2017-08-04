@extends("layout")
@section('content')
    <div class="no-container" id="notfound" v-cloak>
        <head-top></head-top>
        <img src="{{ fct_cdn('/images/404.png') }}" class="icon">
        <section class="info">
            @if (isset($message) && $message)
                <div class="title">{{ $message }}</div>
            @else
                <div class="title">404&nbsp;error</div>
            @endif
            <div class="txt">别着急，点击<a href="{{ (isset($url) && $url) ? $url : url('/') }}" class="link">这里</a>可以继续访问</div>
        </section>
    </div>
@endsection
@section('javascript')
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/notfound.js') }}"></script>
@endsection