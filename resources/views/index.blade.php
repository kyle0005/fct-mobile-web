@extends("layout")

@section("title", $title)
@section('content')
    <div id="main">
        <div class="main-container">
            <div class="copyright-container">
                <div class="info">
                    Copyright&nbsp;&copy;&nbsp;2017&nbsp;,fangcuntang&nbsp;Co.,Ltd.All&nbsp;Rights&nbsp;Reserved.<br>
                    宜兴方寸堂文化传媒有限公司&ensp;|&ensp;<a href="" class="law">法律声明</a><br>
                    <span class="bottom">沪ICP备12022967号-1&nbsp;沪公网安备11010502025474</span>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        var app =new Vue({
            el: '#loginForm',

        })
    </script>
@endsection