"use strict";var app=new Vue({computed:{},mounted:function(){this.initData()},data:{showAlert:!1,msg:null,status:0,tabs:["宝贝","合作艺人"],tab_num:0,collection:[],listloading:!0,nodata:!1},watch:{collection:function(t,o){this.listloading||(this.collection&&this.collection.length>0?this.nodata=!1:this.nodata=!0)}},methods:{initData:function(){var t=this;t.collection=config.collection,t.listloading=!1},getBefore:function(){this.listloading=!0},del:function(t,o){var e=this;jAjax({type:"post",url:config.collectionDel+"?from_type="+t.favType+"&from_id="+t.favoriteId,data:{keyword:e.keywords},timeOut:5e3,before:function(){},success:function(t){t&&(t=JSON.parse(t),200==parseInt(t.code)?e.collection.splice(o,1):(e.msg=t.message,e.showAlert=!0,e.close_auto()))},error:function(){}})},category:function(t){var o=this;o.preventRepeatReuqest=!1,o.tab_num=t,o.collection=[],o.nodata=!1;var e=config.collectionUrl+"?from_type="+t;tools.ajaxGet(e,o.cateSucc,o.getBefore)},cateSucc:function(t){var o=this;o.collection=t.data,o.listloading=!1},close:function(){this.showAlert=!1},close_auto:function(t,o){var e=this;setTimeout(function(){e.showAlert=!1,t&&t(o)},1500)},linkto:function(t){t&&(location.href=t)}}}).$mount("#collection");