@extends("layout")
@section('content')
    <div class="no-container" id="notfound" v-cloak>
        <?php if (!env('APP_CLOSE')):?>
        <head-top></head-top>
        <?php endif;?>
        <img src="{{ fct_cdn('/img/mobile/404.png') }}" class="icon">
        <section class="info">
            @if (isset($message) && $message)
                <div class="title">{{ $message }}</div>
            @else
                <div class="title">404&nbsp;error</div>
            @endif
            <div class="txt">别着急，点击<a href="{{ (isset($url) && $url) ? $url : url('/', [], env('APP_SECURE')) }}" class="link">这里</a>可以继续访问</div>
        </section>
    </div>
@endsection
@section('javascript')
    <script>
        config.productsType = {!! json_encode($categories, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/head.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/notfound.js') }}"></script>
@endsection