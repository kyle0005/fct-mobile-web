"use strict";var app=new Vue({mounted:function(){var t=this;t.initdata(),t.defaultAddr()},watch:{address:function(t,s){this.listloading||(this.address&&this.address.length>0?this.nodata=!1:this.nodata=!0)}},data:{address:[],showAlert:!1,msg:null,picked:"",subText:"删除",del_index:null,listloading:!0,nodata:!1},methods:{initdata:function(){var t=this;t.address=config.address,t.listloading=!1},setDefault:function(t){this.address.forEach(function(t,s){t.isDefault=0}),t.isDefault=1},changeDefault:function(t){var s=this,i=config.defaultAddrUrl+"?id="+t.id,e={};tools.ajaxPost(i,e,s.postSuc,s.postBefore,s.postError,t,s.postTip)},postSuc:function(t,s){var i=this;i.setDefault(s),i.defaultAddr()},postTip:function(t){var s=this;s.msg=t.message,s.showAlert=!0,s.close_auto()},postBefore:function(){},postError:function(){},edit:function(t){location.href=config.editUrl+"?id="+t.id},del:function(t){var s=this,i=config.delAddrUrl+"?id="+t.item.id,e={};s.del_index=t.index;var d="subpost"+t.index;s.$refs[d][0].post(i,e)},addressStr:function(t){return t.province+t.cityId+t.townId+t.address},defaultAddr:function(){var t=this,s=0,i="";t.address.forEach(function(e){1==(s=parseInt(e.isDefault))&&(i=t.addressStr(e))}),t.picked=i},succhandle:function(t){var s=this;s.msg=t.message,s.showAlert=!0,404!=parseInt(t.code)&&(s.address.splice(s.del_index,1),s.defaultAddr(),t.url?s.close_auto(s.linkto,t.url):s.close_auto())},close:function(){this.showAlert=!1},close_auto:function(t,s){var i=this;setTimeout(function(){i.showAlert=!1,t&&t(s)},1500)},linkto:function(t){t&&(location.href=t)}}}).$mount("#buy_address");