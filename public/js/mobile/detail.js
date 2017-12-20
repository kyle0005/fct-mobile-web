"use strict";function _toConsumableArray(t){if(Array.isArray(t)){for(var e=0,n=Array(t.length);e<t.length;e++)n[e]=t[e];return n}return Array.from(t)}Vue.component("mVideo",{template:"#m_video",data:function(){return{isVideoLoad:!1}},mounted:function(){},props:{poster:{type:String,default:""},url:{type:String,default:""},id:{type:String,default:""}},methods:{loadVideo:function(){var t=this;t.isVideoLoad=!0,t.$nextTick(function(){var e=document.getElementById(t.id);e.play(),e.addEventListener("ended",function(){t.isVideoLoad=!1})})}}}),Vue.component("m-swipe",{template:"#m_swipe",props:{swipeid:{type:String,default:""},effect:{type:String,default:"slide"},loop:{type:Boolean,default:!1},direction:{type:String,default:"horizontal"},pagination:{type:Boolean,default:!0},autoplay:{type:Number,default:5e3},paginationType:{type:String,default:"bullets"}},data:function(){return{dom:""}},mounted:function(){var t=this;this.dom=new Swiper("."+t.swipeid,{loop:t.loop,pagination:".swiper-pagination",paginationType:t.paginationType,autoplay:t.autoplay,direction:t.direction,effect:t.effect,autoplayDisableOnInteraction:!1,observer:!0,observeParents:!0,height:window.innerHeight,lazyLoading:!0,paginationBulletRender:function(t,e,n){return'<span class="en-pagination '+n+'"></span>'},onTransitionStart:function(e){t.$emit("slideindex",e.activeIndex)}})},components:{}});var _time_html='<span :endTime="endTime" :callback="callback" ><slot><span class="time-block">{{ time_content.hour }}</span>:<span class="time-block">{{ time_content.min }}</span>:<span class="time-block">{{ time_content.sec }}</span></slot></span>';Vue.component("m-time",{template:_time_html,data:function(){return{time_content:{day:"00",hour:"00",min:"00",sec:"00"}}},props:{endTime:{type:Number,default:0},callback:{type:Function,default:""}},mounted:function(){this.countdowm(this.endTime)},methods:{countdowm:function(t){var e=this,n=(new Date).getTime(),o=setInterval(function(){var i=new Date,a=new Date(1e3*t+n),s=a.getTime()-i.getTime();if(s>0){var c=Math.floor(s/864e5),r=Math.floor(s/36e5%24),u=Math.floor(s/6e4%60),l=Math.floor(s/1e3%60);r+=24*c,r=r<10?"0"+r:r,u=u<10?"0"+u:u,l=l<10?"0"+l:l,c>0&&(e.time_content.hour=r,e.time_content.min=u,e.time_content.sec=l),c<=0&&r>0&&(e.time_content.hour=r,e.time_content.min=u,e.time_content.sec=l),c<=0&&r<=0&&(e.time_content.min=u,e.time_content.sec=l)}else clearInterval(o),e._callback()},1e3)},_callback:function(){this.callback&&this.callback instanceof Function&&this.callback.apply(this,_toConsumableArray(this))}}}),Vue.component("overview",{template:"#overview",mounted:function(){var t=this;tools.animate(document,{scrollTop:"0"},400,"ease-out"),t.tops=config.product.images;var e=this.$refs.swiper;e&&e.dom&&(this.swiper=e.dom)},activated:function(){this.swiper&&this.swiper.startAutoplay()},deactivated:function(){this.loop=!1,this.swiper&&this.swiper.stopAutoplay()},computed:{calstock:function(){var t=this,e="无货";return t.product.stockCount>0&&(e="有货"),e}},data:function(){return{product:config.product,listloading:!0,pagerloading:!1,isPage:!1,nodata:!1,swiper:"",tops:[]}},methods:{end:function(){console.log("end")}}}),Vue.component("artist",{template:"#artist",mounted:function(){var t=this;tools.animate(document,{scrollTop:"0"},400,"ease-out"),t.loadart()},data:function(){return{artist:[],artistsingle:{},titleshow:!1,chosen:!1,art_num:0,listloading:!0,pagerloading:!1,isPage:!1,nodata:!1}},methods:{getBefore:function(){},loadsingle:function(t){var e=this;tools.animate(document,{scrollTop:"0"},400,"ease-out"),e.artistsingle={},e.art_num=t,e.artistsingle=e.artist[t],e.listloading=!1},loadart:function(){var t=this;tools.ajaxGet(config.artist_url,t.getSucc,t.getBefore)},getSucc:function(t){var e=this;e.artist=t.data,e.titleshow=e.artist.length>1,e.loadsingle(0)}}}),Vue.component("pug",{template:"#pug",mounted:function(){var t=this;tools.animate(document,{scrollTop:"0"},400,"ease-out"),t.loadpug(),t.$nextTick(function(){setTimeout(function(){},500)})},data:function(){return{pugs:[],pugsingle:{},titleshow:!1,chosen:!1,pug_num:0,listloading:!0,pagerloading:!1,isPage:!1,nodata:!1}},methods:{getBefore:function(){this.listloading=!0},loadsingle:function(t){var e=this;tools.animate(document,{scrollTop:"0"},400,"ease-out"),e.pugsingle={},e.pug_num=t,e.pugsingle=e.pugs[t]},loadpug:function(){var t=this;tools.ajaxGet(config.pug_url,t.pugSucc,t.getBefore)},pugSucc:function(t){var e=this;e.pugs=t.data,e.titleshow=e.pugs.length>1,e.loadsingle(0),e.listloading=!1}}}),Vue.component("service",{template:"#service",mounted:function(){var t=this;tools.animate(document,{scrollTop:"0"},400,"ease-out"),t.initData()},data:function(){return{tab_service:"",listloading:!0,pagerloading:!1,isPage:!1,nodata:!1}},methods:{initData:function(){var t=this;t.tab_service=config.tab_service,t.listloading=!1}}}),Vue.component("discuss",{template:"#discuss",mounted:function(){var t=this;tools.animate(document,{scrollTop:"0"},400,"ease-out"),t.loadList()},watch:{commentlist:function(t,e){this.listloading||(this.commentlist&&this.commentlist.length>0?this.nodata=!1:this.nodata=!0)}},data:function(){return{pager:{},commentlist:[],preventRepeatReuqest:!1,last_url:"",listloading:!0,pagerloading:!1,isPage:!1,nodata:!1}},methods:{getBefore:function(){var t=this;t.isPage?t.pagerloading=!0:t.listloading=!0},c_star:function(t){return 5-t},nextPage:function(){var t=this;if(t.preventRepeatReuqest=!0,t.pager.next>0){var e=config.discuss_url+"?page="+t.pager.next;e!==t.last_url&&(t.last_url=e,t.isPage=!0,tools.ajaxGet(e,t.pageSucc,t.getBefore))}},pageSucc:function(t){var e=this;e.commentlist=e.commentlist.concat(t.data.entries),e.pager=t.data.pager,e.preventRepeatReuqest=!1,e.listloading=!1,e.pagerloading=!1,e.isPage=!1},loadList:function(){var t=this;t.nodata=!1,tools.ajaxGet(config.discuss_url,t.listSucc,t.getBefore)},listSucc:function(t){var e=this;e.commentlist=t.data.entries,e.pager=t.data.pager,e.listloading=!1}}});var app=new Vue({data:{product:config.product,ranks_list:[],pro_list:[],loading:!1,refreshing:!1,currentView:"overview",tabs:["概览","作者","泥料","售后保障","评论"],tab_num:0,showAlert:!1,msg:null,open:!1,docked:!1,chosen:!1,input_val:1,specs_single:[],specs_num:0,min:!1,max:!1,collected:config.product.favoriteState,numsshow:!1,isbuy:!1,cart_num:config.product.cartProductCount},mounted:function(){var t=this;t.loadcart(),t.specs_single=t.product.specification[0]},computed:{calstock:function(){var t=this,e=0;return t.product.specification.length<=0?t.product.stockCount>0&&(e="有货"):t.specs_single.stockCount>0&&(e="有货"),e},showprice:function(){var t=this;return t.product.specification.length<=0?t.product.hasDiscount&&(t.product.discount.hasBegin||t.product.discount.canBuy)?t.product.promotionPrice:t.product.salePrice:t.product.hasDiscount&&(t.product.discount.hasBegin||t.product.discount.canBuy)?t.specs_single.promotionPrice:t.specs_single.salePrice}},methods:{loadcart:function(){var t=this,e=t.cart_num;t.numsshow=e>0},top:function(){tools.animate(document,{scrollTop:"0"},400,"ease-out")},collection:function(){var t=this;tools.ajaxPost(config.fav_url,{},t.favSuc,t.postBefore,t.postError,{},t.postTip)},favSuc:function(t){this.collected=t.data.favoriteState},postSuc:function(t){},postTip:function(t){var e=this;e.msg=t.message,e.showAlert=!0,e.close_auto()},postBefore:function(){},postError:function(){},change:function(t){},add:function(){var t=this,e=parseInt(t.input_val.toString().replace(/[^\d]/g,"")),n=0;n=t.product.specification.length<=0?t.product.stockCount:t.specs_single.stockCount,t.min&&(t.min=!1),e<n&&(e+=1)===n&&(t.max=!0),t.input_val=e},minus:function(){var t=this,e=parseInt(t.input_val.toString().replace(/[^\d]/g,""));t.max&&(t.max=!1),e>0&&(e-=1,0===e&&(t.min=!0),t.input_val=e)},footLinkTo:function(t){var e=this;e.specs_num=t,e.specs_single=e.product.specification[t],e.input_val=1,e.min=!1,e.max=!1},prevent:function(t){t.preventDefault(),t.stopPropagation()},choose:function(){var t=this;t.open?(t.open=!1,setTimeout(function(){t.docked=!1},300)):(t.docked=!0,t.open=!0)},chooseSpec:function(){var t=this;t.chosen?t.chosen=!1:t.chosen=!0},buy:function(t){var e=this;if(1==parseInt(t)){var n=config.buy_url+"?product_id="+e.product.id;e.specs_single&&e.specs_single.id&&(n+="&spec_id="+e.specs_single.id),n+="&buy_number="+e.input_val,location.href=n}else{var o=config.addcart_url,i=formData.serializeForm("addcart");e.$refs.subpost.post(o,i)}},linkTo:function(t){var e=this;switch(e.tab_num=t,parseInt(t)){case 0:e.currentView="overview";break;case 1:e.currentView="artist";break;case 2:e.currentView="pug";break;case 3:e.currentView="service";break;case 4:e.currentView="discuss";break;default:e.currentView="overview"}},succhandle:function(t){var e=this;e.cart_num=t.data.cartProductCount,e.loadcart()},close:function(){this.showAlert=!1},close_auto:function(t,e){var n=this;setTimeout(function(){n.showAlert=!1,t&&t(e)},1500)},linkto:function(t){t&&(location.href=t)}},components:{}}).$mount("#detail");