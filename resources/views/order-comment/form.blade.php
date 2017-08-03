@extends("layout")

@section('content')
    <div class="ordercomment-container" id="ordercomment" v-cloak>
        <section class="list">
            <div class="item" v-for="(item, index) in order_detail.orderGoods">
                <div class="top">
                    <div class="pro-img">
                        <img :src="item.img">
                    </div>
                    <div class="context clearfix">
                        <div class="des">描述相符</div>
                        <star ref="star"></star>
                    </div>
                </div>
                <div class="comment">
                    <m-textarea  ref="text"></m-textarea>
                    <upload ref="uploadimg"></upload>
                </div>
            </div>
            <div class="bot">
                <div class="inner">
                    <label for="anonymous" class="anonymous-container">
                        <input type="checkbox" name="anonymous" id="anonymous" v-model="anonymous" class="anonymous">
                        <span class="">匿名</span>
                    </label>
                    <span class="txt">你的评价能帮助其他小伙伴哟</span>
                </div>
            </div>
        </section>
        <section class="shop-comment">
            <div class="top">
                <img src="/images/logo2.png"><span>店铺评分</span>
            </div>
            <div class="context clearfix">
                <div class="des">物流服务</div>
                <star ref="express"></star>
            </div>
            <div class="context clearfix">
                <div class="des">服务态度</div>
                <star ref="sale"></star>
            </div>
        </section>
        <div class="sub-btn">
            <a href="javascript:;" @click="sub">提交评论</a>
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
        config.uploadFileUrl = "{{ url('upload/image') }}";
        config.commentUrl = "{{ url('my/orders/' . $entity->orderId . '/comments') }}";
        config.order_detail = {!! json_encode($entity, JSON_UNESCAPED_UNICODE) !!};
    </script>
    <script type="text/x-template" id="m_star">
        <div class="stars clearfix">
            <div class="inner">
                <a href="javascript:;" @click="c_star(index)" v-for="(item, index) in stars_chosen">
                    <i class="fa fa-star"></i>
                </a>
                <a href="javascript:;" @click="c_star(index + stars_chosen)" v-for="(item, index) in (stars_num - stars_chosen)">
                    <i class="fa fa-star-o"></i>
                </a>
                <span class="text">@{{ stars_chosen_msg }}</span>
            </div>
        </div>
    </script>
    <script type="text/x-template" id="m_textarea">
        <textarea class="textarea" v-model="content" placeholder="宝贝满足你的期待吗？说说它的优点和美中不足的地方吧"></textarea>
    </script>
    <script type="text/x-template" id="m_upload">
        <div class="upload-container">
            <div class="item" v-for="(item, index) in uploadItem">
                <div class="inner">
                    <img :src="item">
                </div>
                <a href="javascript:;" class="fork" @click="delImg(index)"><i class="fa fa-times"></i></a>
            </div>
            <div class="item" v-if="uploadItem.length < maxNum">
                <div class="inner">
                    <img src="/images/upload.png">
                    <input type="file" name="file" class="upload" @change="fileChange">
                </div>
            </div>
            <input type="hidden" name="uploadimg" :value="subUpload">
        </div>
    </script>
    <script src="/js/ordercomment.js"></script>
@endsection