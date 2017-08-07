@extends("layout")

@section('content')
    <div class="collection-container" id="collection" v-cloak>
        <div class="tabs">
            <div class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="category(index)">
                <a href="javascript:;" class="link">@{{ item }}</a>
            </div>
        </div>
        <div class="collection-list" v-if="collection && collection.length > 0">
            <div class="item" v-for="(item, index) in collection">
                <div class="img-container">
                    <img :src="item.image">
                </div>
                <div class="content">
                    <span class="title">@{{ item.name }}&emsp;<span v-if="title">@{{ item.title }}</span></span>
                    <a href="javascript:;" class="close" @click="del(item, index)">
                        <img src="{{ fct_cdn('/images/close.png') }}">
                    </a>
                </div>
            </div>
        </div>

        <ul class="prolist" v-else>
            <li class="noData">
                <img src="{{ fct_cdn('/images/no_data.png') }}">
                <span class="no">当前没有相关数据哟~</span>
            </li>
        </ul>

        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
            </section>
        </div>
    </template>
@endsection
@section('javascript')
    <script>
        config.collectionUrl = "{{ url('my/favorites') }}";
        config.collectionDel = "{{ url('my/favorites') }}";
        config.collection = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="{{ fct_cdn('/js/collection.js') }}"></script>
@endsection