@extends("layout")
@section("title", $title)
@section('content')
    <div class="collection-container" id="collection" v-cloak>
        <div class="tabs">
            <div class="item" v-for="(item, index) in tabs" :class="{chosen: index===tab_num}" @click="category(index)">
                <a href="javascript:;" class="link">@{{ item }}</a>
            </div>
        </div>
        <div class="collection-list">
            <div class="item" v-for="(item, index) in collection">
                <div class="img-container">
                    <img :src="item.image">
                </div>
                <div class="content">
                    <span class="title">@{{ item.name }}&emsp;<span v-if="title">@{{ item.title }}</span></span>
                    <a href="javascript:;" class="close" @click="del(item, index)">
                        <img src="/images/close.png">
                    </a>
                </div>
            </div>
        </div>
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
        config.collectionUrl = "{{ url('settings/favorites') }}";
        config.collectionDel = "{{ url('settings/favorites') }}";
        config.collection = {!! json_encode($entries, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script src="/js/collection.js"></script>
@endsection