"use strict";var app=new Vue({mounted:function(){this.defaultAddr()},data:{address:config.address,showAlert:!1,msg:null,picked:""},methods:{close:function(){this.showAlert=!1},close_auto:function(e,t){var s=this;setTimeout(function(){s.showAlert=!1,e&&e(t)},1500)},linkto:function(e){e&&(location.href=e)},setDefault:function(e){this.address.forEach(function(e,t){e.isDefault=0}),e.isDefault=1},changeDefault:function(e){var t=this;jAjax({type:"post",url:config.defaultAddrUrl+"?id="+e.id,data:{},timeOut:5e3,before:function(){console.log("before")},success:function(s){s&&(s=JSON.parse(s),200==parseInt(s.code)?(t.msg=s.message,t.showAlert=!0,t.close_auto(),t.setDefault(e),t.defaultAddr()):(t.msg=s.message,t.showAlert=!0,t.close_auto()))},error:function(e,t){console.log(t)}})},edit:function(e){location.href=config.editUrl+"?id="+e.id},del:function(e,t){var s=this;jAjax({type:"post",url:config.delAddrUrl+"?id="+e.id,data:{},timeOut:5e3,before:function(){console.log("before")},success:function(e){e&&(e=JSON.parse(e),200==parseInt(e.code)?(s.msg=e.message,s.showAlert=!0,s.close_auto(),s.address.splice(t,1),s.setDefault(s.address[0]),s.defaultAddr()):(s.msg=e.message,s.showAlert=!0,s.close_auto()))},error:function(e,t){console.log(t)}})},addressStr:function(e){return e.province+e.cityId+e.townId+e.address},defaultAddr:function(){var e=this,t=0,s="";e.address.forEach(function(o){1==(t=parseInt(o.isDefault))&&(s=e.addressStr(o))}),e.picked=s}}}).$mount("#buy_address");