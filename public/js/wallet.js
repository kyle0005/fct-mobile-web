"use strict";Vue.component("pop",{template:"#pop",data:function(){return{positionY:0,timer:null}},props:["msg"],methods:{close:function(){this.$emit("close")}}});var app=new Vue({computed:{},mounted:function(){},data:{showAlert:!1,msg:null,show_search:!1,show_detail:!1},watch:{},methods:{getCoupon:function(){var o=this;jAjax({type:"post",url:config.coupon_url,data:{validateCoupon:config.validateCoupon,couponCode:o.couponcode},timeOut:5e3,before:function(){console.log("before")},success:function(t){t&&(t=JSON.parse(t),200==parseInt(t.code)?(o.coupon.couponAmount=t.data,o.coupon.couponCode=o.couponcode,o.loadCoupon(),o.calculateAmount(0)):(o.msg=t.message,o.showAlert=!0,o.close_auto()))},error:function(){console.log("error")}})},close:function(){this.showAlert=!1},close_auto:function(o,t){var e=this;setTimeout(function(){e.showAlert=!1,o&&o(t)},1500)},linkto:function(o){o&&(location.href=o)}}}).$mount("#wallet");