"use strict";var app=new Vue({mounted:function(){},data:{ranks_list:config.productsRank,pro_list:config.products,loading:!1,refreshing:!1,msg:0,isindex:config.isindex,code:"",_code:"",tab_num:null,listloading:!1,nodata:!1},methods:{showImg:function(){return"public/images/img_loader.gif"},getBefore:function(){this.listloading=!0},getprolist:function(o,t,i){var n=this;n.tab_num=i,n.nodata=!1,n.pro_list={};var e="";o=o||"",t=t||0,""!=o?(e="?code="+o,t>0&&(e+="&level_id="+t)):t>0&&(o=n.code,e="?level_id="+t,""!=o&&(e+="&code="+o)),n._code=o,e=config.product_url+e,tools.ajaxGet(e,n.getSucc,n.getBefore)},getSucc:function(o){var t=this;t.pro_list=o.data,t.code=t._code,t.listloading=!1,t.pro_list.length>0?t.nodata=!1:t.nodata=!0}}}).$mount("#main");