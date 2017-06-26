<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <!-- build:css styles/main.css -->
    <link rel="stylesheet" href="css/app.css">
    <!-- endbuild -->
</head>
<body>
<div class="index-container" id="welcome">
    <div class="btns">
        <div class="enter">
            <a href="{{ url('/') }}">
                <span>进入商城</span>
            </a>
        </div>
        <div class="download">
            <a href="{{ url('download/app') }}">
                <span>下载APP</span>
            </a>
        </div>
    </div>
    <m-swipe swipeid="swipe" ref="swiper" :autoplay="0" effect="slide">
        <div v-for="top in tops" class="swiper-slide" slot="swiper-con">
            <img :data-src="top.image" class="swiper-lazy silde-img">
        </div>
    </m-swipe>
</div>
<script type="text/x-template" id="m_swipe">
    <div class="swiper-container" :class="swipeid">
        <div class="swiper-wrapper">
            <slot name="swiper-con"></slot>
        </div>
        <!-- 分页器 -->
        <div :class="{'swiper-pagination':pagination}"></div>
    </div>
</script>
<script>
    var swipes = [
        {}
    ]
</script>
<script src="js/app.js"></script>
</body>
</html>
