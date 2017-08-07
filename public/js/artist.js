"use strict";Vue.component("live",{template:"#live",computed:{topImg:function(){var t=this,e=!1;return config.artist.dynamicList.entries.forEach(function(e){e.isTop&&(t.top=e)}),t.top.images.length>0&&(e=!0),e}},directives:{"load-more":{bind:function(t,e){var o=window.screen.height,n=void 0,i=void 0,a=void 0,r=void 0,s=void 0,c=void 0,l=void 0,u=void 0,d=t.attributes.type&&t.attributes.type.value;2==d?(l=t,u=t.children[0]):(l=document.body,u=t),t.addEventListener("touchstart",function(){n=u.clientHeight,2==d&&(n=n),i=t.offsetTop,a=tools.getStyle(t,"paddingBottom"),r=tools.getStyle(t,"marginBottom")},!1),t.addEventListener("touchmove",function(){p()},!1),t.addEventListener("touchend",function(){c=l.scrollTop,f()},!1);var f=function t(){s=requestAnimationFrame(function(){l.scrollTop!=c?(c=l.scrollTop,t()):(cancelAnimationFrame(s),n=u.clientHeight,p())})},p=function(){l.scrollTop+o>=n+i+a+r-2&&e.value()}}}},mounted:function(){this.loadLive()},data:function(){return{dynamicList:config.artist.dynamicList,liveList:config.artist.dynamicList.entries,top:{},preventRepeatReuqest:!1,last_url:""}},methods:{nextPage:function(){var t=this;document.body.scrollTop,document.body.clientHeight,document.body.scrollHeight;if(t.preventRepeatReuqest=!0,t.dynamicList.pager.next>0){var e=config.artistPage_url+"?page="+t.dynamicList.pager.next;e!==t.last_url&&(t.last_url=e,jAjax({type:"get",url:e,timeOut:5e3,before:function(){console.log("before")},success:function(e){e&&(e=JSON.parse(e),200==parseInt(e.code)?(t.dynamicList=e.data,t.liveList=e.data.entries.concat(t.liveList),t.loadLive(),t.preventRepeatReuqest=!1,console.log("ok")):console.log("false"))},error:function(){console.log("error")}}))}},loadLive:function(){var t=this;t.liveList.forEach(function(e,o){e.isTop?(t.liveList.splice(o,1),t.$nextTick(function(){t.loadVideo("video_top",e.url,e.videoImage)})):t.$nextTick(function(){t.loadVideo("video_"+o,e.url,e.videoImage)})})},loadVideo:function(t,e,o){if(t&&e&&o){var n={fluid:!0,aspectRatio:"2:1",preload:"auto",poster:o};videojs(t,n,function(){this.src(e),videojs.log("Your player is ready!"),this.play(),this.on("ended",function(){videojs.log("Awww...over so soon?!")})})}}}}),Vue.component("works",{template:"#works",mounted:function(){this.loadWorks()},data:function(){return{workslist:[],last_url:""}},methods:{loadWorks:function(){var t=this,e=config.artistWorks_url;e!==t.last_url&&(t.last_url=e,jAjax({type:"get",url:e,timeOut:5e3,before:function(){console.log("before")},success:function(e){e&&(e=JSON.parse(e),200==parseInt(e.code)?t.workslist=e.data:console.log("false"))},error:function(){console.log("error")}}))}}}),Vue.component("chat",{template:"#chat",computed:{},directives:{"load-more":{bind:function(t,e){var o=window.screen.height,n=void 0,i=void 0,a=void 0,r=void 0,s=void 0,c=void 0,l=void 0,u=void 0,d=t.attributes.type&&t.attributes.type.value;2==d?(l=t,u=t.children[0]):(l=document.body,u=t),t.addEventListener("touchstart",function(){n=u.clientHeight,2==d&&(n=n),i=t.offsetTop,a=tools.getStyle(t,"paddingBottom"),r=tools.getStyle(t,"marginBottom")},!1),t.addEventListener("touchmove",function(){p()},!1),t.addEventListener("touchend",function(){c=l.scrollTop,f()},!1);var f=function t(){s=requestAnimationFrame(function(){l.scrollTop!=c?(c=l.scrollTop,t()):(cancelAnimationFrame(s),n=u.clientHeight,p())})},p=function(){l.scrollTop+o>=n+i+a+r-2&&e.value()}}}},mounted:function(){this.loadChat()},data:function(){return{chatlist:[],last_url:"",pager:{},open:!1,docked:!1,preventRepeatReuqest:!1,showAlert:!1,msg:null,message:""}},methods:{nextPage:function(){var t=this;if(t.preventRepeatReuqest=!0,t.pager.next>0){var e=config.artistChat_url+"?page="+t.pager.next;e!==t.last_url&&(t.last_url=e,jAjax({type:"get",url:e,timeOut:5e3,before:function(){console.log("before")},success:function(e){e&&(e=JSON.parse(e),200==parseInt(e.code)?(t.pager=e.data.pager,t.chatlist=e.data.entries.concat(t.chatlist),t.preventRepeatReuqest=!1):console.log("false"))},error:function(){console.log("error")}}))}},pop:function(){var t=this;t.open?(t.open=!1,setTimeout(function(){t.docked=!1},300)):(t.docked=!0,t.open=!0)},send:function(){var t=this;jAjax({type:"post",url:config.chat_url,data:{message:t.message},timeOut:5e3,before:function(){console.log("before")},success:function(e){e&&(e=JSON.parse(e),200==parseInt(e.code)?(t.msg="留言提交成功，我们将通知“"+config.artist.name+"”给您回复，请留意！",t.showAlert=!0,t.close_auto(),t.pop()):(t.msg=e.message,t.showAlert=!0,t.close_auto()))},error:function(){console.log("error")}})},loadChat:function(){var t=this,e=config.artistChat_url;e!==t.last_url&&(t.last_url=e,jAjax({type:"get",url:e,timeOut:5e3,before:function(){console.log("before")},success:function(e){e&&(e=JSON.parse(e),200==parseInt(e.code)?(t.chatlist=e.data.entries,t.pager=e.data.pager):console.log("false"))},error:function(){console.log("error")}}))},close:function(){this.showAlert=!1},close_auto:function(t,e){var o=this;setTimeout(function(){o.showAlert=!1,t&&t(e)},1500)},linkto:function(t){t&&(location.href=t)}}});var app=new Vue({computed:{},mounted:function(){},activated:function(){},deactivated:function(){},data:{haslive:!0,currentView:"live",tabs:["实时动态","相关作品","对话艺人"],tab_num:0,artist:config.artist},watch:{},methods:{linkTo:function(t){var e=this;switch(this.tab_num=t,parseInt(t)){case 0:e.currentView="live";break;case 1:e.currentView="works";break;case 2:e.currentView="chat";break;default:e.currentView="live"}}},components:{}}).$mount("#artist");