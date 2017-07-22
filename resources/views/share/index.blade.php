@extends("layout")
@section("title", $title)
@section('content')
    <div class="share-container" id="share">
        <section class="top">
            <div class="inner">
                <div class="item sort">
                    <select class="sel">
                        <option selected value="综合排序">综合排序</option>
                        <option value="1">1</option>
                    </select>
                </div>
                <div class="item category">
                    <select class="sel">
                        <option selected value="选择分类">选择分类</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="item search">
                    <a href="javascript:;" class="search-link">
                        <i class="fa fa-search"></i>
                    </a>
                    <input type="search" class="search-input" placeholder="宝贝名称 ">
                    <a href="javascript:;" class="fork-link">
                        <i class="fa fa-times-circle"></i>
                    </a>
                </div>
            </div>
        </section>
        <ul class="list">
            <li>
                <a href="javascript:;" class="link">
        <span class="left">
          <img src="/images/resource/pro01.png">
        </span>
                    <span class="center">
          <span class="title">表标题壶</span>
          <span class="t2">紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂壶紫砂</span>
        </span>
                    <span class="right"><img src="/images/share.png"></span>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="link">
        <span class="left">
          <img src="/images/resource/pro01.png">
        </span>
                    <span class="center">
          <span class="title">表标题壶</span>
          <span class="t1">成本：￥232334344</span>
          <span class="t2">利润：<strong class="pri">￥2342&sim;￥434343</strong></span>
        </span>
                    <span class="right"><img src="/images/share.png"></span>
                </a>
            </li>
        </ul>
        <pop v-if="showAlert" :showHide="showAlert" @close="close" :msg="msg"></pop>
    </div>
    <template id="pop">
        <div class="alet_container">
            <section class="tip_text_container">
                <div class="tip_text">@{{ msg }}</div>
                <!--<div class="confrim" @click="close">确认</div>-->
            </section>
        </div>
    </template>
@endsection
@section('javascript')

@endsection