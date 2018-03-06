@extends("layout")
@section('content')
    <div class="screenshot-container" id="screenshot" v-cloak>
        <div class="result-container" id="con_result">
            <div class="btn" id="btn">
                <a href="javascript:;" @click="pop" class="save">保存图片</a>
            </div>
        </div>
        <pop v-if="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.imgObj = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
        config.msg = '长按保存图片';
    </script>
    <script src="{{ fct_cdn('/js/mobile/api/index.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/common/tools.js') }}"></script>
    <script src="{{ fct_cdn('/js/mobile/canvas2image.js') }}"></script>
@endsection