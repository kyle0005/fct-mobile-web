@extends("layout")
@section('content')
    <div class="collection-container" id="collection" v-cloak>
        <div class="tabs">
            <div class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="category(index)">
                <a href="javascript:;" class="link">@{{ item }}</a>
            </div>
        </div>
        <div class="collection-list">
            <div class="item" v-for="(item, index) in collection" v-if="collection && collection.length > 0">
                <div class="img-container">
                    <img v-view="item.image" src="{{ fct_cdn('/img/mobile/img_loader.gif') }}">
                </div>
                <div class="content">
                    <span class="title">@{{ item.name }}&emsp;<span v-if="item.title">@{{ item.title }}</span></span>
                    <a href="javascript:;" class="close" @click="del(item, index)">
                        <img src="{{ fct_cdn('/img/mobile/close.png') }}">
                    </a>
                </div>
            </div>

            <no-data v-if="nodata"></no-data>
            <img src="{{ fct_cdn('/img/mobile/img_loader_s.gif') }}" class="list-loader" v-if="listloading">
        </div>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
@endsection
@section('javascript')
    <script>
        config.collectionUrl = "{{ url('my/favorites') }}";
        config.collectionDel = "{{ url('my/favorites') }}";
        config.collection = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/mobile/collection.js') }}"></script>
@endsection