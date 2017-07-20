"use strict";Vue.component("m-swipe",{template:"#m_swipe",computed:{},watch:{},activated:function(){},deactivated:function(){},props:{swipeid:{type:String,default:""},effect:{type:String,default:"slide"},loop:{type:Boolean,default:!1},direction:{type:String,default:"horizontal"},pagination:{type:Boolean,default:!0},autoplay:{type:Number,default:5e3},centeredSlides:{type:Boolean,default:!0},slidesPerView:{type:String,default:"auto"},paginationType:{type:String,default:"bullets"}},data:function(){return{dom:""}},mounted:function(){var t=this;this.dom=new Swiper("."+t.swipeid,{loop:t.loop,pagination:".swiper-pagination",paginationType:t.paginationType,autoplay:t.autoplay,direction:t.direction,effect:t.effect,autoplayDisableOnInteraction:!1,observer:!0,observeParents:!0,height:window.innerHeight,lazyLoading:!0,centeredSlides:t.centeredSlides,slidesPerView:t.slidesPerView,coverflow:{rotate:50,stretch:0,depth:100,modifier:1,slideShadows:!1}})},components:{}});var app=new Vue({computed:{},mounted:function(){this.load();var t=this.$refs.swiper;t.dom&&(this.swiper=t.dom)},activated:function(){this.swiper&&this.swiper.startAutoplay()},deactivated:function(){this.loop=!1,this.swiper&&this.swiper.stopAutoplay()},data:{artist:[]},watch:{},methods:{load:function(){this.artist=config.artist}},components:{}}).$mount("#artist_list");