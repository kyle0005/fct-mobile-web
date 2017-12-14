"use strict";var _typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(t){return typeof t}:function(t){return t&&"function"==typeof Symbol&&t.constructor===Symbol&&t!==Symbol.prototype?"symbol":typeof t};Vue.component("mVideo",{template:"#m_video",data:function(){return{isVideoLoad:!1}},mounted:function(){},props:{poster:{type:String,default:""},url:{type:String,default:""},id:{type:String,default:""}},methods:{loadVideo:function(){var t=this;t.isVideoLoad=!0,t.$nextTick(function(){var e=document.getElementById(t.id);e.play(),e.addEventListener("ended",function(){t.isVideoLoad=!1})})}}}),Vue.component("m-swipe",{template:"#m_swipe",props:{swipeid:{type:String,default:""},effect:{type:String,default:"slide"},loop:{type:Boolean,default:!1},direction:{type:String,default:"horizontal"},pagination:{type:Boolean,default:!0},autoplay:{type:Number,default:5e3},paginationType:{type:String,default:"bullets"}},data:function(){return{dom:""}},mounted:function(){var t=this;this.dom=new Swiper("."+t.swipeid,{loop:t.loop,pagination:".swiper-pagination",paginationType:t.paginationType,autoplay:t.autoplay,direction:t.direction,effect:t.effect,autoplayDisableOnInteraction:!1,observer:!0,observeParents:!0,height:window.innerHeight,lazyLoading:!0,onTransitionStart:function(e){t.$emit("slideindex",e.activeIndex)}})},components:{}});var app=new Vue({data:{time_content:{day:"00",hour:"00",min:"00",sec:"00"},_sec:0,product:config.product,chat_list:config.chatList,ranks_list:[],pro_list:[],loading:!1,refreshing:!1,currentPrice:config.product.bidPrice,showAlert:!1,msg:null,open:!1,docked:!1,chosen:!1,swiper:"",tops:config.product.images,onId:0,addpri:"",wsurl:config.ws_auction_url+"?token="+config.product.token+"&relation_id="+config.product.id,ws:{},wsMsg:"",depositText:"预交保证金",subText:"我要出价"},watch:{chat_list:function(t,e){this.$nextTick(function(){var t=this.$el.querySelector("#chatContainer");console.log(t),t.scrollTop=t.scrollHeight})}},mounted:function(){var t=this,e=this.$refs.swiper;e.dom&&(this.swiper=e.dom);var o=document.querySelector("#chatContainer"),i=new Hammer(o);i.on("swipeleft",function(t){console.log("swipeleft")}),i.on("swiperight",function(e){t.choose()}),t.choose(),t.product.status&&1===parseInt(t.product.status)&&t.choose(),t.init_ws()},methods:{initTime:function(){var t=this,e=t.product,o=0;1===e.status?o=parseInt((e.startTime-e.nowTime)/1e3):4!==e.status&&(o=parseInt((e.endTime-e.nowTime)/1e3)),t._sec=o},countdowm:function(t){var e=this,o=(new Date).getTime(),i=setInterval(function(){var n=new Date,a=new Date(1e3*t+o),r=a.getTime()-n.getTime();if(r>0){var s=Math.floor(r/864e5),c=Math.floor(r/36e5%24),d=Math.floor(r/6e4%60),u=Math.floor(r/1e3%60);c+=24*s,c=c<10?"0"+c:c,d=d<10?"0"+d:d,u=u<10?"0"+u:u,s>0&&(e.time_content.hour=c,e.time_content.min=d,e.time_content.sec=u),s<=0&&c>0&&(e.time_content.hour=c,e.time_content.min=d,e.time_content.sec=u),s<=0&&c<=0&&(e.time_content.min=d,e.time_content.sec=u)}else clearInterval(i),e.end()},1e3)},top:function(){tools.animate(document,{scrollTop:"0"},400,"ease-out")},choose:function(){var t=this;t.open?(t.open=!1,setTimeout(function(){t.docked=!1},300)):(t.docked=!0,t.open=!0)},add:function(){var t=this,e=t.product,o=parseFloat(t.addpri)||0,i=parseFloat(t.currentPrice);3===e.status&&(o<i?o=i+e.increasePrice:o+=e.increasePrice,t.addpri=o)},end:function(){4!==this.product.status&&tools.ajaxGet(config.reload_url,this.reloadData_suc,this.reloadData_bef)},reloadData_bef:function(){},reloadData_suc:function(t){var e=this;e.product=t.data,e.init_ws()},succhandle:function(t){var e=this;e.msg=t.message,e.showAlert=!0,t.url?e.close_auto(e.linkto,t.url):e.close_auto()},close:function(){this.showAlert=!1},close_auto:function(t,e){var o=this;setTimeout(function(){o.showAlert=!1,t&&t(e)},1500)},linkto:function(t){t&&(location.href=t)},init_ws:function(){var t=this;t.isEmpty(t.product);if(4!==t.product.status){var e=new WebSocket(t.wsurl);e.addEventListener("open",function(t){}),e.addEventListener("message",function(e){t.listenSocket(e)}),t.ws=e}t.setBidOn(t.chat_list);var o=t.$el.querySelector("#chatContainer");console.log(o),o.scrollTop=o.scrollHeight,t.initTime(),t.countdowm(this._sec)},listenSocket:function(t){var e=this;if(!e.isEmpty(t.data)){var o=JSON.parse(t.data);if(401===o.code&&(location.href=config.loginUrl),200!==o.code)return e.msg=o.msg,e.showAlert=!0,void e.close_auto();var i=e.product;1===o.data.roleType&&(o.data.bidStatus=1,i.bidCount=i.bidCount+1);var n=e.chat_list;if(n.push(o.data),e.chat_list=[],e.chat_list=n,e.product={},e.product=i,1===o.data.roleType){var a=e.product;e.product={},a.product.bidUserHeadPortrait=o.data.headPortrait,a.product.bidUserName=o.data.userName,a.product.bidStatusName=o.data.bidStatusName?o.data.bidStatusName:"领先",a.product.bidPrice=o.data.bidPrice,e.currentPrice=o.data.bidPrice,e.product=a,e.setBidOn(e.chat_list)}}},setBidOn:function(t){var e=this,o=e.onId;if(o>0)o=t[t.length-1].id;else for(var i in t)if(t[i].bidStatus>0){o=t[i].id;break}e.onId=o},isEmpty:function(t){if(null===t||""===t||void 0===t||!1===t)return!0;if("object"==(void 0===t?"undefined":_typeof(t))){for(var e in t)return!1;return!0}return!1},bindDepositTap:function(){var t=this,e=this.product,o={goods_id:e.id};2===e.status?(console.log(t.$refs),t.$refs.deppost.post(config.auction_signup_url,o)):1===e.status?(t.msg="拍卖还未开始",t.showAlert=!0,t.close_auto()):4!==e.status?(t.msg="您已报过名了",t.showAlert=!0,t.close_auto()):4===e.status&&(t.msg="拍卖已经结束了",t.showAlert=!0,t.close_auto())},bindSubmitTap:function(){var t=this,e={goods_id:t.product.id,price:t.addpri};if(t.addpri<=0)return void console.log("出价不能小于当前最高价！");t.$refs.subpost.post(config.auction_bid_url,e)},bindSendTap:function(){var t=this;t.product.token&&""!==t.product.token&&null!==t.product.token?(t.ws.send(t.wsMsg),t.wsMsg=""):location.href=config.loginUrl},clear:function(){this.addpri=""}},components:{}}).$mount("#auctiondetail");