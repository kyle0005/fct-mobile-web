"use strict";var app=new Vue({computed:{},mounted:function(){this.initData()},watch:{shareList:function(a,e){this.listloading||(this.shareList&&this.shareList.length>0?this.nodata=!1:this.nodata=!0)}},data:{showAlert:!1,msg:null,shareList:[],pager:config.share.pager,productsType:config.productsType,sort:config.sort,sortsel:0,categary:config.productsType[0].code,preventRepeatReuqest:!1,last_url:"",search:"",listloading:!0,pagerloading:!1,isPage:!1,nodata:!1,show:!1,qrurl:"",qrname:""},methods:{popqrcode:function(a,e){var t=this;t.show=!t.show,a&&(t.qrurl=config.shareTopUrl+"?"+config.shareParam,t.qrname="方寸堂-只为不同"),e&&(t.qrurl=config.shareProUrl+"/"+e.id+"?"+config.shareParam,t.qrname=e.name+"-"+e.artistName)},initData:function(){var a=this;a.shareList=config.share.entries,a.listloading=!1},getBefore:function(){var a=this;a.isPage?a.pagerloading=!0:a.listloading=!0},subSearch:function(){var a=this;a.nodata=!1;var e=config.shareUrl+"?";a.categary&&(e+="&code="+a.categary),a.sortsel&&(e+="&sort="+a.sortsel),a.search&&tools.ajaxGet(e+"&keyword="+a.search,a.searchSuc,a.getBefore)},searchSuc:function(a){var e=this;e.shareList=a.data.entries,e.pager=a.data.pager},searchTxt:function(){var a=this;console.log(a.search)},clear:function(){this.search=""},nextPage:function(){var a=this;if(a.preventRepeatReuqest=!0,a.pager.next>0){var e=config.shareUrl+"?page="+a.pager.next;a.categary&&(e+="&code="+a.categary),a.sortsel&&(e+="&sort="+a.sortsel),e!==a.last_url&&(a.last_url=e,a.isPage=!0,tools.ajaxGet(e,a.pageSucc,a.getBefore))}},pageSucc:function(a){var e=this;e.pager=a.data.pager,e.shareList=e.shareList.concat(a.data.entries),e.preventRepeatReuqest=!1,e.listloading=!1,e.pagerloading=!1,e.isPage=!1},sel:function(){var a=this;a.nodata=!1;var e=config.shareUrl+"?sort="+a.sortsel+"&page="+a.pager.next;a.categary&&(e+="&code="+a.categary),tools.ajaxGet(e,a.selSucc,a.getBefore)},selSucc:function(a){var e=this;e.shareList=a.data.entries,e.pager=a.data.pager,e.listloading=!1},cate:function(){var a=this;a.nodata=!1;var e=config.shareUrl+"?code="+a.categary+"&page="+a.pager.next;a.sortsel&&(e+="&sort="+a.sortsel),tools.ajaxGet(e,a.cateSucc,a.getBefore)},cateSucc:function(a){var e=this;e.shareList=a.data.entries,e.pager=a.data.pager,e.listloading=!1},close:function(){this.showAlert=!1},close_auto:function(a,e){var t=this;setTimeout(function(){t.showAlert=!1,a&&a(e)},1500)},linkto:function(a){a&&(location.href=a)}}}).$mount("#share");