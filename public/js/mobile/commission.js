"use strict";var app=new Vue({computed:{},mounted:function(){this.initData()},directives:{"load-more":{bind:function(t,i){var o=window.screen.height,e=void 0,s=void 0,n=void 0,a=void 0,c=void 0,l=void 0,r=void 0,u=void 0,m=t.attributes.type&&t.attributes.type.value;2==m?(r=t,u=t.children[0]):(r=document.body,u=t),t.addEventListener("touchstart",function(){e=u.clientHeight,2==m&&(e=e),s=t.offsetTop,n=tools.getStyle(t,"paddingBottom"),a=tools.getStyle(t,"marginBottom")},!1),t.addEventListener("touchmove",function(){g()},!1),t.addEventListener("touchend",function(){l=r.scrollTop,d()},!1);var d=function t(){c=requestAnimationFrame(function(){r.scrollTop!=l?(l=r.scrollTop,t()):(cancelAnimationFrame(c),e=u.clientHeight,g())})},g=function(){r.scrollTop+o>=e+s+n+a-2&&i.value()}}}},data:{showAlert:!1,msg:null,commissionlist:[],pager:{},status:0,tabs:["等待结算","结算成功"],tab_num:0,preventRepeatReuqest:!1,last_url:"",listloading:!0,nodata:!1},watch:{commissionlist:function(t,i){this.listloading||(this.commissionlist&&this.commissionlist.length>0?this.nodata=!1:this.nodata=!0)}},methods:{initData:function(){var t=this;t.commissionlist=config.commissionlist.entries,t.pager=config.commissionlist.pager,t.listloading=!1},getBefore:function(){this.listloading=!0},category:function(t){var i=this;i.nodata=!1,i.preventRepeatReuqest=!1,i.tab_num=t,i.status=0==t?0:2,i.commissionlist=[],i.nodata=!1;var o=config.commissionUrl+"?status="+i.status;tools.ajaxGet(o,i.cateSucc,i.getBefore)},cateSucc:function(t){var i=this;i.commissionlist=[],i.commissionlist=t.data.entries,i.pager=t.data.pager,i.listloading=!1},nextPage:function(){var t=this;if(t.preventRepeatReuqest=!0,t.pager.next>0){var i=config.commissionUrl+"?status="+t.status+"&page="+t.pager.next;i!==t.last_url&&(t.last_url=i,tools.ajaxGet(i,t.pageSucc,t.getBefore))}},pageSucc:function(t){var i=this;i.pager=t.data.pager,i.commissionlist=t.data.entries.concat(i.commissionlist),i.preventRepeatReuqest=!1,i.listloading=!1},close:function(){this.showAlert=!1},close_auto:function(t,i){var o=this;setTimeout(function(){o.showAlert=!1,t&&t(i)},1500)},linkto:function(t){t&&(location.href=t)}}}).$mount("#commission");