"use strict";var confirm_html='<div class="confirm-container pay"><section class="inner"><div class="confirm-text"><div class="title">交纳保证金</div>{{ msg }}</div><div class="confirm-btn"><a href="javascript:;" class="cancel" @click="no()">取消</a><a href="javascript:;" class="ok" @click="ok()">前往支付</a></div></section></div>';Vue.component("confirm",{template:confirm_html,data:function(){return{positionY:0,timer:null}},props:["msg","callback","obj"],methods:{no:function(){this.$emit("no")},ok:function(){this.$emit("ok",this.callback,this.obj)}}});var app=new Vue({computed:{},mounted:function(){},data:{msg:null,callback:null,showConfirm:!1},methods:{comf:function(){var o=this;o.confirm(o.link)},link:function(){var o=this;jAjax({type:"post",url:config.rechange_url,data:{can_withdraw:1,pay_amount:2e3},timeOut:5e3,before:function(){},success:function(n){n&&(n=JSON.parse(n),200==parseInt(n.code)?n.url?o.close_auto(o.linkto,n.url):o.close_auto():(o.msg=n.message,o.showAlert=!0,o.close_auto()))},error:function(){}})},linkto:function(o){o&&(location.href=o)},confirm:function(o){var n=this;n.callback=o,n.msg="您确认交纳拍卖保证金2000元？",n.showConfirm=!0},no:function(){this.showConfirm=!1},ok:function(o,n){this.showConfirm=!1,o&&o(n)}}}).$mount("#wallet");