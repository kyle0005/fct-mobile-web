"use strict";var confirm_html='<div class="confirm-container pay"><section class="inner"><div class="confirm-text"><div class="title">交纳保证金</div>{{ msg }}</div><div class="confirm-btn"><a href="javascript:;" class="cancel" @click="no()">取消</a><a href="javascript:;" class="ok" @click="ok()">前往支付</a></div></section></div>';Vue.component("confirm",{template:confirm_html,data:function(){return{positionY:0,timer:null}},props:["msg","callback","obj"],methods:{no:function(){this.$emit("no")},ok:function(){this.$emit("ok",this.callback,this.obj)}}});var app=new Vue({computed:{},mounted:function(){},data:{msg:null,callback:null,showConfirm:!1},methods:{comf:function(){var o=this;o.confirm(o.link)},link:function(){this.$refs.confref.post(config.rechange_url,{can_withdraw:1,pay_amount:2e3})},postSuc:function(o,n){},postTip:function(o){var n=this;n.msg=o.message,n.showAlert=!0,n.close_auto()},postBefore:function(){},postError:function(){},close:function(){this.showAlert=!1},close_auto:function(o,n){var t=this;setTimeout(function(){t.showAlert=!1,o&&o(n)},1500)},linkto:function(o){o&&(location.href=o)},confirm:function(o){var n=this;n.callback=o,n.msg="您确认交纳拍卖保证金2000元？",n.showConfirm=!0},no:function(){this.showConfirm=!1},ok:function(o,n){this.showConfirm=!1,o&&o(n)}}}).$mount("#wallet");