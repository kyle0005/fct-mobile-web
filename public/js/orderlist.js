"use strict";Vue.component("pop",{template:"#pop",data:function(){return{positionY:0,timer:null}},props:["msg"],methods:{close:function(){this.$emit("close")}}});var app=new Vue({computed:{},mounted:function(){},directives:{"load-more":{bind:function(e,t){var o=window.screen.height,r=void 0,n=void 0,s=void 0,a=void 0,i=void 0,c=void 0,l=void 0,u=void 0,d=e.attributes.type&&e.attributes.type.value;2==d?(l=e,u=e.children[0]):(l=document.body,u=e),e.addEventListener("touchstart",function(){r=u.clientHeight,2==d&&(r=r),n=e.offsetTop,s=tools.getStyle(e,"paddingBottom"),a=tools.getStyle(e,"marginBottom")},!1),e.addEventListener("touchmove",function(){f()},!1),e.addEventListener("touchend",function(){c=l.scrollTop,p()},!1);var p=function e(){i=requestAnimationFrame(function(){l.scrollTop!=c?(c=l.scrollTop,e()):(cancelAnimationFrame(i),r=u.clientHeight,f())})},f=function(){l.scrollTop+o>=r+n+s+a-2&&t.value()}}}},data:{showAlert:!1,msg:null,show_search:!1,placeholder:"",keywords:"",orderlist:config.orderlist.entries,tabs:["全部","待付款","待发货","待收货","待评价"],tab_num:0,preventRepeatReuqest:!1,last_url:"",pager:config.orderlist.pager,status:""},watch:{},methods:{todetail:function(e){location.href=config.detail_url+"?order_id="+e.orderId},nextPage:function(){var e=this;if(e.preventRepeatReuqest=!0,e.pager.next>0){var t=config.orderlist_url+"?status="+e.status+"&page="+e.pager.next;t!==e.last_url&&(e.last_url=t,jAjax({type:"get",url:t,timeOut:5e3,before:function(){console.log("before")},success:function(t){t&&(t=JSON.parse(t),200==parseInt(t.code)?(e.pager=t.data.pager,e.orderlist=t.data.entries.concat(e.orderlist),e.preventRepeatReuqest=!1):console.log("false"))},error:function(){console.log("error")}}))}},category:function(e){var t=this;t.preventRepeatReuqest=!1,t.tab_num=e,t.status=0==e?"":e-1;var o=config.orderlist_url+"?status="+t.status;jAjax({type:"get",url:o,timeOut:5e3,before:function(){console.log("before")},success:function(e){e&&(e=JSON.parse(e),200==parseInt(e.code)?(t.orderlist=e.data.entries,t.pager=e.data.pager):console.log("false"))},error:function(){console.log("error")}})},subSearch:function(){var e=this;jAjax({type:"post",url:config.search_url,data:{keyword:e.keywords},timeOut:5e3,before:function(){console.log("before")},success:function(t){t&&(t=JSON.parse(t),200==parseInt(t.code)?(e.orderlist=t.data.entries,e.pager=t.data.pager):(e.msg=t.message,e.showAlert=!0,e.close_auto()))},error:function(){console.log("error")}})},close:function(){this.showAlert=!1},close_auto:function(e,t){var o=this;setTimeout(function(){o.showAlert=!1,e&&e(t)},1500)},linkto:function(e){e&&(location.href=e)},search:function(e){var t=this;t.show_search?(t.placeholder="",1==e&&(t.subSearch(),t.keywords="")):t.placeholder="请输入订单号或者商品名称",t.show_search=!t.show_search}}}).$mount("#orderlist");