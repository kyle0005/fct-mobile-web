"use strict";Vue.component("pop",{template:"#pop",data:function(){return{positionY:0,timer:null}},props:["msg"],methods:{close:function(){this.$emit("close")}}}),Vue.component("coupons",{template:"#coupon_item",data:function(){return{show_search:!1,show_detail:!1}},props:["couponitem"],mounted:function(){},methods:{showdetail:function(){var o=this;o.couponitem.goods.length>0&&(o.show_detail=!o.show_detail)},sub:function(o){var t=this;jAjax({type:"post",url:config.useUrl,data:{id:o},timeOut:5e3,before:function(){console.log("before")},success:function(o){o&&(o=JSON.parse(o),200==parseInt(o.code)?(t.msg=o.message,t.showAlert=!0,o.url?t.close_auto(t.linkto,o.url):t.close_auto()):(t.msg=o.message,t.showAlert=!0,t.close_auto()))},error:function(){console.log("error")}})},receive:function(o){var t=this;jAjax({type:"post",url:config.getCouponUrl,data:{id:o},timeOut:5e3,before:function(){console.log("before")},success:function(o){o&&(o=JSON.parse(o),200==parseInt(o.code)&&t.$emit("pop",o.message,o.url))},error:function(){console.log("error")}})}}});var app=new Vue({computed:{},mounted:function(){},data:{showAlert:!1,msg:null,couponlist:config.couponlist,couponcount:config.couponcount,status:0,tabs:["未使用","使用记录","已过期"],tab_num:0},watch:{},methods:{pop:function(o,t){var e=this;e.msg=o,e.showAlert=!0,t?e.close_auto(e.linkto,t):e.close_auto()},category:function(o){var t=this;t.preventRepeatReuqest=!1,t.tab_num=o,t.status=0==o?0:1==o?2:3;var e=config.couponlistUrl+"?status="+t.status;jAjax({type:"get",url:e,timeOut:5e3,before:function(){console.log("before")},success:function(o){o&&(o=JSON.parse(o),200==parseInt(o.code)?t.couponlist=o.data:console.log("false"))},error:function(){console.log("error")}})},close:function(){this.showAlert=!1},close_auto:function(o,t){var e=this;setTimeout(function(){e.showAlert=!1,o&&o(t)},1500)},linkto:function(o){o&&(location.href=o)}}}).$mount("#coupon");