"use strict";var app=new Vue({computed:{rightPhoneNumber:function(){return/^1\d{10}$/gi.test(this.phoneNumber)}},data:function(){return{loginWay:!0,phoneNumber:null,userInfo:null,userAccount:null,passWord:null,showAlert:!1,msg:null,mobileCode:null,validate_token:null,computedTime:0,captchaCodeImg:null,codeNumber:null,openid:config.openid,action:"bind"}},methods:{getVerifyCode:function(){var o=this,t=this;this.rightPhoneNumber?(this.computedTime=30,this.timer=setInterval(function(){0==--o.computedTime&&clearInterval(o.timer)},1e3),t.$refs.coderef.post(apis.smsUrl,{cellphone:this.phoneNumber,action:this.action})):(t.msg="手机号码格式不正确",t.showAlert=!0,t.close_auto())},postSuc:function(o){},postTip:function(o){var t=this;t.msg=o.message,t.showAlert=!0,t.close_auto()},postBefore:function(){},postError:function(){},mobileMsgLogin:function(){var o=this;if(!this.rightPhoneNumber)return this.showAlert=!0,this.msg="手机号码不正确",void o.close_auto();o.$refs.subpost.post(apis.userResource,formData.serializeForm("quickLogin"))},succhandle:function(o){var t=this;t.msg=o.message,t.showAlert=!0,o.url?t.close_auto(t.linkto,o.url):t.close_auto()},close:function(){this.showAlert=!1},close_auto:function(o,t){var e=this;setTimeout(function(){e.showAlert=!1,o&&o(t)},1500)},linkto:function(o){o&&(location.href=o)}}}).$mount("#login");