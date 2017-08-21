"use strict";Vue.component("m-swipe",{template:"#m_swipe",props:{swipeid:{type:String,default:""},effect:{type:String,default:"slide"},loop:{type:Boolean,default:!1},direction:{type:String,default:"horizontal"},pagination:{type:Boolean,default:!0},autoplay:{type:Number,default:5e3},paginationType:{type:String,default:"bullets"},spaceBetween:{type:Number,default:10}},data:function(){return{dom:""}},mounted:function(){var t=this;this.dom=new Swiper("."+t.swipeid,{loop:t.loop,pagination:".swiper-pagination",paginationType:t.paginationType,autoplay:t.autoplay,direction:t.direction,spaceBetween:t.spaceBetween,effect:t.effect,autoplayDisableOnInteraction:!1,observer:!0,observeParents:!0,height:window.innerHeight,lazyLoading:!0,paginationBulletRender:function(t,e,i){return'<span class="en-pagination '+i+'"></span>'}})},components:{}}),Vue.component("m-search",{template:"#search",mounted:function(){},data:function(){return{show_search:!1,placeholder:"",keywords:""}},props:{dat:{type:Array,default:[]},sid:{type:String,default:""}},methods:{search:function(t){var e=this;if(e.show_search){if(e.placeholder="",1==t){var i={},n=[];i.keywords=e.keywords;for(var a=0;a<e.dat.length;a++)n=n.concat(e.dat[a]);i.dat=n,i.sid=e.sid,e.$emit("subsearch",i),e.keywords=""}}else e.placeholder="请输入关键字";e.show_search=!e.show_search}}}),Vue.component("info",{template:"#info",computed:{},mounted:function(){},watch:{},activated:function(){},deactivated:function(){},data:function(){return{positionY:0,timer:null}},props:["msg"],methods:{close:function(){this.$emit("close")}}});var app=new Vue({computed:{},mounted:function(){var t=this;t.getProductsType();var e=this.$refs.swiper;e&&e.dom&&(this.swiper=e.dom),t.getProductsOtherType();var i=this.$refs.swipert;i&&i.dom&&(this.swipert=i.dom),t.getTermType();var n=this.$refs.swiperterm;n&&n.dom&&(this.swiperterm=n.dom)},data:{ranks_list:[],pro_list:[],loading:!1,refreshing:!1,img_url:"public/images",currentView:"overview",tabs:[],tab_num:0,list:[],swiper:"",tabs_t:[],tab_num_t:0,swipert:"",list_t:[],swiperterm:"",list_term:[],showAlert:!1,msg:null,wikiCategories:config.wikiCategories,materials:config.materials,term:config.term,listloading:!1,nodata:!1},methods:{close:function(){this.showAlert=!1},showinfo:function(t){var e=this;e.showAlert=!0,e.msg=t},getProductsType:function(){var t=this;t.wikiCategories.forEach(function(e){t.tabs.push(e.name)}),t.linkTo(0)},linkTo:function(t){var e=this,i=[];if(e.list=[],e.tab_num=t,e.wikiCategories.length>0){i=e.wikiCategories[t].subList;for(var n=i.length,a=[],o=0,r=0;o<n;o+=12,r++)a[r]=i.slice(o,12+o);e.list=a}},getProductsOtherType:function(){this.linkToOther(0)},linkToOther:function(t){var e=this;e.list_t=[];var i=e.materials;if(i.length>0){for(var n=i.length,a=[],o=0,r=0;o<n;o+=20,r++)a[r]=i.slice(o,o+20);e.list_t=a}},getTermType:function(){this.linkToTerm(0)},linkToTerm:function(t){var e=this;e.list_term=[];var i=e.term;if(i.length>0){for(var n=i.length,a=[],o=0,r=0;o<n;o+=20,r++)a[r]=i.slice(o,o+20);e.list_term=a}},upSearch:function(t){var e=this,i=[];e.list=[],i=e.searchNotes(t.dat,t.keywords);for(var n=i.length,a=[],o=0,r=0;o<n;o+=12,r++)a[r]=i.slice(o,12+o);e.list=a,e.listloading=!1,e.list.length>0?e.nodata=!1:e.nodata=!0},downSearch:function(t){var e=this,i=[];e.list_t=[],i=e.searchNotes(t.dat,t.keywords);for(var n=i.length,a=[],o=0,r=0;o<n;o+=20,r++)a[r]=i.slice(o,20+o);e.list_t=a,e.listloading=!1,e.list_t.length>0?e.nodata=!1:e.nodata=!0},termSearch:function(t){var e=this,i=[];e.list_term=[],i=e.searchNotes(t.dat,t.keywords);for(var n=i.length,a=[],o=0,r=0;o<n;o+=20,r++)a[r]=i.slice(o,20+o);e.list_term=a,e.listloading=!1,e.list_term.length>0?e.nodata=!1:e.nodata=!0},subsearch:function(t){var e=this;"up"==t.sid&&e.upSearch(t),"down"==t.sid&&e.downSearch(t),"term"==t.sid&&e.termSearch(t)},searchNotes:function(t,e){for(var i,n=[],a=e.split(" "),o="",r=0,s=a.length;r<s;r++)o+="("+a[r]+")([\\s\\S]*)";i=new RegExp(o);for(var l=0,c=t.length;l<c;l++){var p=t[l].name,d=p.match(i),h={};if(0,null!==d){for(var u in t[l])t[l].hasOwnProperty(u)&&(h[u]=t[l][u]);n.push(h)}}return n}},components:{}}).$mount("#encyclopedias");