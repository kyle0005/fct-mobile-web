"use strict";function _toConsumableArray(e){if(Array.isArray(e)){for(var t=0,n=Array(e.length);t<e.length;t++)n[t]=e[t];return n}return Array.from(e)}function _classCallCheck(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function base64_encode(e){var t=0,n=[],o=0,i=0;if(e.length>0)for(;i<e.length;){var r=e.charCodeAt(i++);switch(++t){case 1:n.push(tab[r>>2]),o=3&r,i>=e.length&&(n.push(tab[o<<4]),n.push("=="));break;case 2:n.push(tab[r>>4|o<<4]),o=15&r,i>=e.length&&(n.push(tab[o<<2]),n.push("="));break;case 3:n.push(tab[r>>6|o<<2]),n.push(tab[63&r]),o=0,t=0}}return n.join("")}var _createClass=function(){function e(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(t,n,o){return n&&e(t.prototype,n),o&&e(t,o),t}}(),_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e};!function(){function e(t,o){var i;if(o=o||{},this.trackingClick=!1,this.trackingClickStart=0,this.targetElement=null,this.touchStartX=0,this.touchStartY=0,this.lastTouchIdentifier=0,this.touchBoundary=o.touchBoundary||10,this.layer=t,this.tapDelay=o.tapDelay||200,this.tapTimeout=o.tapTimeout||700,!e.notNeeded(t)){for(var r=["onMouse","onClick","onTouchStart","onTouchMove","onTouchEnd","onTouchCancel"],a=this,s=0,c=r.length;s<c;s++)a[r[s]]=function(e,t){return function(){return e.apply(t,arguments)}}(a[r[s]],a);n&&(t.addEventListener("mouseover",this.onMouse,!0),t.addEventListener("mousedown",this.onMouse,!0),t.addEventListener("mouseup",this.onMouse,!0)),t.addEventListener("click",this.onClick,!0),t.addEventListener("touchstart",this.onTouchStart,!1),t.addEventListener("touchmove",this.onTouchMove,!1),t.addEventListener("touchend",this.onTouchEnd,!1),t.addEventListener("touchcancel",this.onTouchCancel,!1),Event.prototype.stopImmediatePropagation||(t.removeEventListener=function(e,n,o){var i=Node.prototype.removeEventListener;"click"===e?i.call(t,e,n.hijacked||n,o):i.call(t,e,n,o)},t.addEventListener=function(e,n,o){var i=Node.prototype.addEventListener;"click"===e?i.call(t,e,n.hijacked||(n.hijacked=function(e){e.propagationStopped||n(e)}),o):i.call(t,e,n,o)}),"function"==typeof t.onclick&&(i=t.onclick,t.addEventListener("click",function(e){i(e)},!1),t.onclick=null)}}var t=navigator.userAgent.indexOf("Windows Phone")>=0,n=navigator.userAgent.indexOf("Android")>0&&!t,o=/iP(ad|hone|od)/.test(navigator.userAgent)&&!t,i=o&&/OS 4_\d(_\d)?/.test(navigator.userAgent),r=o&&/OS [6-7]_\d/.test(navigator.userAgent),a=navigator.userAgent.indexOf("BB10")>0;e.prototype.needsClick=function(e){switch(e.nodeName.toLowerCase()){case"button":case"select":case"textarea":if(e.disabled)return!0;break;case"input":if(o&&"file"===e.type||e.disabled)return!0;break;case"label":case"iframe":case"video":return!0}return/\bneedsclick\b/.test(e.className)},e.prototype.needsFocus=function(e){switch(e.nodeName.toLowerCase()){case"textarea":return!0;case"select":return!n;case"input":switch(e.type){case"button":case"checkbox":case"file":case"image":case"radio":case"submit":return!1}return!e.disabled&&!e.readOnly;default:return/\bneedsfocus\b/.test(e.className)}},e.prototype.sendClick=function(e,t){var n,o;document.activeElement&&document.activeElement!==e&&document.activeElement.blur(),o=t.changedTouches[0],n=document.createEvent("MouseEvents"),n.initMouseEvent(this.determineEventType(e),!0,!0,window,1,o.screenX,o.screenY,o.clientX,o.clientY,!1,!1,!1,!1,0,null),n.forwardedTouchEvent=!0,e.dispatchEvent(n)},e.prototype.determineEventType=function(e){return n&&"select"===e.tagName.toLowerCase()?"mousedown":"click"},e.prototype.focus=function(e){var t;o&&e.setSelectionRange&&0!==e.type.indexOf("date")&&"time"!==e.type&&"month"!==e.type?(t=e.value.length,e.setSelectionRange(t,t)):e.focus()},e.prototype.updateScrollParent=function(e){var t,n;if(!(t=e.fastClickScrollParent)||!t.contains(e)){n=e;do{if(n.scrollHeight>n.offsetHeight){t=n,e.fastClickScrollParent=n;break}n=n.parentElement}while(n)}t&&(t.fastClickLastScrollTop=t.scrollTop)},e.prototype.getTargetElementFromEventTarget=function(e){return e.nodeType===Node.TEXT_NODE?e.parentNode:e},e.prototype.onTouchStart=function(e){var t,n,r;if(e.targetTouches.length>1)return!0;if(t=this.getTargetElementFromEventTarget(e.target),n=e.targetTouches[0],o){if(r=window.getSelection(),r.rangeCount&&!r.isCollapsed)return!0;if(!i){if(n.identifier&&n.identifier===this.lastTouchIdentifier)return e.preventDefault(),!1;this.lastTouchIdentifier=n.identifier,this.updateScrollParent(t)}}return this.trackingClick=!0,this.trackingClickStart=e.timeStamp,this.targetElement=t,this.touchStartX=n.pageX,this.touchStartY=n.pageY,e.timeStamp-this.lastClickTime<this.tapDelay&&e.preventDefault(),!0},e.prototype.touchHasMoved=function(e){var t=e.changedTouches[0],n=this.touchBoundary;return Math.abs(t.pageX-this.touchStartX)>n||Math.abs(t.pageY-this.touchStartY)>n},e.prototype.onTouchMove=function(e){return!this.trackingClick||((this.targetElement!==this.getTargetElementFromEventTarget(e.target)||this.touchHasMoved(e))&&(this.trackingClick=!1,this.targetElement=null),!0)},e.prototype.findControl=function(e){return void 0!==e.control?e.control:e.htmlFor?document.getElementById(e.htmlFor):e.querySelector("button, input:not([type=hidden]), keygen, meter, output, progress, select, textarea")},e.prototype.onTouchEnd=function(e){var t,a,s,c,l,u=this.targetElement;if(!this.trackingClick)return!0;if(e.timeStamp-this.lastClickTime<this.tapDelay)return this.cancelNextClick=!0,!0;if(e.timeStamp-this.trackingClickStart>this.tapTimeout)return!0;if(this.cancelNextClick=!1,this.lastClickTime=e.timeStamp,a=this.trackingClickStart,this.trackingClick=!1,this.trackingClickStart=0,r&&(l=e.changedTouches[0],u=document.elementFromPoint(l.pageX-window.pageXOffset,l.pageY-window.pageYOffset)||u,u.fastClickScrollParent=this.targetElement.fastClickScrollParent),"label"===(s=u.tagName.toLowerCase())){if(t=this.findControl(u)){if(this.focus(u),n)return!1;u=t}}else if(this.needsFocus(u))return e.timeStamp-a>100||o&&window.top!==window&&"input"===s?(this.targetElement=null,!1):(this.focus(u),this.sendClick(u,e),o&&"select"===s||(this.targetElement=null,e.preventDefault()),!1);return!(!o||i||!(c=u.fastClickScrollParent)||c.fastClickLastScrollTop===c.scrollTop)||(this.needsClick(u)||(e.preventDefault(),this.sendClick(u,e)),!1)},e.prototype.onTouchCancel=function(){this.trackingClick=!1,this.targetElement=null},e.prototype.onMouse=function(e){return!this.targetElement||(!!e.forwardedTouchEvent||(!e.cancelable||(!(!this.needsClick(this.targetElement)||this.cancelNextClick)||(e.stopImmediatePropagation?e.stopImmediatePropagation():e.propagationStopped=!0,e.stopPropagation(),e.preventDefault(),!1))))},e.prototype.onClick=function(e){var t;return this.trackingClick?(this.targetElement=null,this.trackingClick=!1,!0):"submit"===e.target.type&&0===e.detail||(t=this.onMouse(e),t||(this.targetElement=null),t)},e.prototype.destroy=function(){var e=this.layer;n&&(e.removeEventListener("mouseover",this.onMouse,!0),e.removeEventListener("mousedown",this.onMouse,!0),e.removeEventListener("mouseup",this.onMouse,!0)),e.removeEventListener("click",this.onClick,!0),e.removeEventListener("touchstart",this.onTouchStart,!1),e.removeEventListener("touchmove",this.onTouchMove,!1),e.removeEventListener("touchend",this.onTouchEnd,!1),e.removeEventListener("touchcancel",this.onTouchCancel,!1)},e.notNeeded=function(e){var t,o,i;if(void 0===window.ontouchstart)return!0;if(o=+(/Chrome\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1]){if(!n)return!0;if(t=document.querySelector("meta[name=viewport]")){if(-1!==t.content.indexOf("user-scalable=no"))return!0;if(o>31&&document.documentElement.scrollWidth<=window.outerWidth)return!0}}if(a&&(i=navigator.userAgent.match(/Version\/([0-9]*)\.([0-9]*)/),i[1]>=10&&i[2]>=3&&(t=document.querySelector("meta[name=viewport]")))){if(-1!==t.content.indexOf("user-scalable=no"))return!0;if(document.documentElement.scrollWidth<=window.outerWidth)return!0}return"none"===e.style.msTouchAction||"manipulation"===e.style.touchAction||(!!(+(/Firefox\/([0-9]+)/.exec(navigator.userAgent)||[,0])[1]>=27&&(t=document.querySelector("meta[name=viewport]"))&&(-1!==t.content.indexOf("user-scalable=no")||document.documentElement.scrollWidth<=window.outerWidth))||("none"===e.style.touchAction||"manipulation"===e.style.touchAction))},e.attach=function(t,n){return new e(t,n)},"function"==typeof define&&"object"===_typeof(define.amd)&&define.amd?define(function(){return e}):"undefined"!=typeof module&&module.exports?(module.exports=e.attach,module.exports.FastClick=e):window.FastClick=e}();var tools={animate:function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:400,o=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"ease-out",i=arguments[4];clearInterval(e.timer),n instanceof Function?(i=n,n=400):n instanceof String&&(o=n,n=400),o instanceof Function&&(i=o,o="ease-out");var r=function(t){return"opacity"===t?Math.round(100*tools.getStyle(e,t,"float")):tools.getStyle(e,t)},a=parseFloat(document.documentElement.style.fontSize),s={},c={};Object.keys(t).forEach(function(e){/[^\d^\.]+/gi.test(t[e])?s[e]=t[e].match(/[^\d^\.]+/gi)[0]||"px":s[e]="px",c[e]=r(e)}),Object.keys(t).forEach(function(e){"rem"==s[e]?t[e]=Math.ceil(parseInt(t[e])*a):t[e]=parseInt(t[e])});var l=!0,u={};e.timer=setInterval(function(){Object.keys(t).forEach(function(a){var s,d=0,h=!1,m=r(a)||0,f=0;switch(o){case"ease-out":f=m,s=5*n/400;break;case"linear":f=c[a],s=20*n/400;break;case"ease-in":d=(u[a]||0)+(t[a]-c[a])/n,u[a]=d;break;default:f=m,s=5*n/400}switch("ease-in"!==o&&(d=(t[a]-f)/s,d=d>0?Math.ceil(d):Math.floor(d)),o){case"ease-out":h=m!=t[a];break;case"linear":case"ease-in":h=Math.abs(Math.abs(m)-Math.abs(t[a]))>Math.abs(d);break;default:h=m!=t[a]}h?(l=!1,"opacity"===a?(e.style.filter="alpha(opacity:"+(m+d)+")",e.style.opacity=(m+d)/100):"scrollTop"===a?e.scrollTop=m+d:e.style[a]=m+d+"px"):l=!0,l&&(clearInterval(e.timer),i&&i())})},20)},showBack:function(e){var t,n;document.addEventListener("scroll",function(){i()},!1),document.addEventListener("touchstart",function(){i()},{passive:!0}),document.addEventListener("touchmove",function(){i()},{passive:!0}),document.addEventListener("touchend",function(){n=document.body.scrollTop,o()},{passive:!0});var o=function e(){t=requestAnimationFrame(function(){document.body.scrollTop!=n?(n=document.body.scrollTop,e()):cancelAnimationFrame(t),i()})},i=function(){e(document.body.scrollTop>500?!0:!1)}},loadMore:function(e,t){var n,o,i,r,a,s,c=window.screen.height;document.body.addEventListener("scroll",function(){u()},!1),e.addEventListener("touchstart",function(){n=e.offsetHeight,o=e.offsetTop,i=tools.getStyle(e,"paddingBottom"),r=tools.getStyle(e,"marginBottom")},{passive:!0}),e.addEventListener("touchmove",function(){u()},{passive:!0}),e.addEventListener("touchend",function(){s=document.body.scrollTop,l()},{passive:!0});var l=function t(){a=requestAnimationFrame(function(){document.body.scrollTop!=s?(s=document.body.scrollTop,u(),t()):(cancelAnimationFrame(a),n=e.offsetHeight,u())})},u=function(){document.body.scrollTop+c>=n+o+i+r&&t()}},getStyle:function(e,t){var n,o=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"int";return n="scrollTop"===t?e.scrollTop:e.currentStyle?e.currentStyle[t]:document.defaultView.getComputedStyle(e,null)[t],"float"==o?parseFloat(n):parseInt(n)},getUrlKey:function(e){return decodeURIComponent((new RegExp("[?|&]"+e+"=([^&;]+?)(&|#|;|$)").exec(location.href)||[,""])[1].replace(/\+/g,"%20"))||null}};Object.keys||(Object.keys=function(){var e=Object.prototype.hasOwnProperty,t=!{toString:null}.propertyIsEnumerable("toString"),n=["toString","toLocaleString","valueOf","hasOwnProperty","isPrototypeOf","propertyIsEnumerable","constructor"],o=n.length;return function(i){if("object"!==(void 0===i?"undefined":_typeof(i))&&"function"!=typeof i||null===i)throw new TypeError("Object.keys called on non-object");var r=[];for(var a in i)e.call(i,a)&&r.push(a);if(t)for(var s=0;s<o;s++)e.call(i,n[s])&&r.push(n[s]);return r}}());var _util={debounce:function(e,t){var n=this,o=arguments,i=void 0;return function(){clearTimeout(i),i=setTimeout(function(){e.apply(n,o)},t)}},getPicInfo:function(e){var t=e.src||"",n=e.fastCallback,o=e.loadedCallback,i=e.errorCallback,r=new Image,a={isError:!1,width:0,height:0},s=function(){(a.isError||r.width>0||r.height>0)&&(clearInterval(c),a.width=r.width,a.height=r.height,n&&n(a))},c=void 0;r.src=t,r.addEventListener("error",function(e){a.isError=!0,i&&i(a)},!1),r.complete?(a.width=r.width,a.height=r.height,n&&n(a),o&&o(a)):(r.addEventListener("load",function(){a.width=r.width,a.height=r.height,o&&o(a)},!1),c=setInterval(s,50))}},VueViewload=function(){function e(t){_classCallCheck(this,e),this.emptyPic="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7",this.defaultPic=t&&t.defaultPic||this.emptyPic,this.errorPic=t&&t.errorPic||this.emptyPic,this.container=t&&t.container||window,this.threshold=t&&parseInt(t.threshold,10)||0,this.effectFadeIn=t&&t.effectFadeIn||!1,this.callback=t&&t.callback||new Function,this.selector=t&&t.selector||[],this.event=["scroll","resize"],this.status=["loading","loaded","error"],this.delayRender=_util.debounce(this.render.bind(this),200)}return _createClass(e,[{key:"inView",value:function(e){var t=!1,n=e.getBoundingClientRect(),o=this.container==window?{left:0,top:0}:this.container.getBoundingClientRect(),i=this.container==window?window.innerWidth:this.container.clientWidth,r=this.container==window?window.innerHeight:this.container.clientHeight;return n.bottom>this.threshold+o.top&&n.top+this.threshold<r+o.top&&n.right>this.threshold+o.left&&n.left+this.threshold<i+o.left&&(t=!0),t}},{key:"bindUI",value:function(){var e=this;this.event.forEach(function(t,n){e.container.addEventListener(t,e.delayRender,!1),e.container!==window&&"resize"==t&&window.addEventListener(t,e.delayRender,!1)})}},{key:"unbindUI",value:function(){var e=this;this.event.forEach(function(t,n){e.container.removeEventListener(t,e.delayRender,!1),e.container!==window&&"resize"==t&&window.removeEventListener(t,e.delayRender,!1)})}},{key:"render",value:function(){var e=this;this.isLoadEvent||(this.isLoadEvent=!0,this.bindUI()),this.selector.length||this.unbindUI();for(var t=0;t<this.selector.length;t++){(function(n){var o=e.selector[n],i=o.ele.nodeName.toLowerCase();if("none"==getComputedStyle(o.ele,null).display)return e.selector.splice(n--,1),"continue";"img"==i&&(o.ele.getAttribute("data-src")||(o.ele.setAttribute("data-src",o.src),o.ele.setAttribute("data-status",e.status[0])),o.ele.getAttribute("src")||o.ele.setAttribute("src",e.defaultPic)),e.inView(o.ele)&&("img"==i?(_util.getPicInfo({src:o.src,errorCallback:function(t){o.ele.src=e.errorPic,o.ele.setAttribute("data-status",e.status[2])},loadedCallback:function(t){e.effectFadeIn&&(o.ele.style.opacity=0),o.ele.src=t.isError?e.errorPic:o.src,o.ele.removeAttribute("data-src"),o.ele.setAttribute("data-status",e.status[1]),setTimeout(function(){o.ele.style.opacity=1,o.ele.style.transition="all 1s"},50)}}),e.callback(o.ele,o.src)):"function"==typeof o.src&&o.src.call(o.ele),e.selector.splice(n--,1)),t=n})(t)}}}]),e}();Vue.directive("view",{bind:function(e,t){var n={},o={threshold:-50},i=void 0,r=void 0==t.arg?"window":t.arg;void 0==n[r]&&(n[r]=[]),n[r].push({ele:e,src:t.value}),Vue.nextTick(function(){void 0===i&&(i=_util.debounce(function(){for(var e in n)o.container="window"==e?window:document.getElementById(e),o.selector=n[e],new VueViewload(o).render()},200)),i()})}});var photo_html='<div class="photogallery-container"><transition appear name="v-img-fade"><div v-if="!closed" class="fullscreen-v-img" @click.self="close()"><div class="header-v-img"><span v-if="images.length > 1" class="count-v-img">{{ currentImageIndex + 1 }}/{{ images.length }}</span><span class="close-v-img" @click="close">&times;</span></div><transition appear name="v-img-fade"><span v-if="visibleUI && images.length !== 1" class="prev-v-img" @click="prev"><svg width="25" height="25" viewBox="0 0 1792 1915" xmlns="http://www.w3.org/2000/svg"><path d="M1664 896v128q0 53-32.5 90.5t-84.5 37.5h-704l293 294q38 36 38 90t-38 90l-75 76q-37 37-90 37-52 0-91-37l-651-652q-37-37-37-90 0-52 37-91l651-650q38-38 91-38 52 0 90 38l75 74q38 38 38 91t-38 91l-293 293h704q52 0 84.5 37.5t32.5 90.5z" fill="#fff"/></svg></span></transition><transition appear name="v-img-fade"><span v-if="visibleUI && images.length !== 1" class="next-v-img" @click="next"><svg width="25" height="25" viewBox="0 0 1792 1915" xmlns="http://www.w3.org/2000/svg"><path d="M1600 960q0 54-37 91l-651 651q-39 37-91 37-51 0-90-37l-75-75q-38-38-38-91t38-91l293-293h-704q-52 0-84.5-37.5t-32.5-90.5v-128q0-53 32.5-90.5t84.5-37.5h704l-293-294q-38-36-38-90t38-90l75-75q38-38 90-38 53 0 91 38l651 651q37 35 37 90z" fill="#fff"/></svg></span></transition><div class="content-v-img"><img :src="images[currentImageIndex]" @click="next"></div></div></transition></div>',screen=Vue.extend({template:photo_html,data:function(){return{images:[],visibleUI:!0,currentImageIndex:0,closed:!0,uiTimeout:null}},methods:{close:function(){document.querySelector("body").classList.remove("body-fs-v-img"),this.images=[],this.currentImageIndex=0,this.closed=!0},next:function(){this.currentImageIndex+1<this.images.length?this.currentImageIndex++:this.currentImageIndex=0},prev:function(){this.currentImageIndex>0?this.currentImageIndex--:this.currentImageIndex=this.images.length-1},showUI:function(){var e=this;clearTimeout(this.uiTimeout),this.visibleUI=!0,this.uiTimeout=setTimeout(function(){e.visibleUI=!1},3500)}},created:function(){var e=this;window.addEventListener("keyup",function(t){27!==t.keyCode&&81!==t.keyCode||e.close(),39!==t.keyCode&&76!==t.keyCode||e.next(),37!==t.keyCode&&72!==t.keyCode||e.prev()}),window.addEventListener("scroll",function(){e.close()}),window.addEventListener("mousemove",function(){e.showUI()})}});Vue.directive("img",{bind:function(e,t){var n="pointer",o=e.src,i=t.arg||null;void 0!==t.value&&(n=t.value.cursor||n,o=t.value.src||o,i=t.value.group||i),e.setAttribute("data-vue-img-group",i||null),t.value&&t.value.src&&e.setAttribute("data-vue-img-src",t.value.src),o||console.error("v-img element missing src parameter."),e.style.cursor=n;var r=window.vueImg;if(!r){var a=document.createElement("div");a.setAttribute("id","imageScreen"),document.querySelector("body").appendChild(a),r=window.vueImg=(new screen).$mount("#imageScreen")}e.addEventListener("click",function(){document.querySelector("body").classList.add("body-fs-v-img");var t=[].concat(_toConsumableArray(document.querySelectorAll('img[data-vue-img-group="'+i+'"]')));0==t.length?Vue.set(r,"images",[o]):(Vue.set(r,"images",t.map(function(e){return e.dataset.vueImgSrc||e.src})),Vue.set(r,"currentImageIndex",t.indexOf(e))),Vue.set(r,"closed",!1)})}});var pop_html='<div class="alet_container"><section class="tip_text_container"><div class="tip_text">{{ msg }}</div></section></div>';Vue.component("pop",{template:pop_html,data:function(){return{positionY:0,timer:null}},props:["msg"],methods:{close:function(){this.$emit("close")}}});var confirm_html='<div class="confirm-container"><section class="inner"><div class="confirm-text">{{ msg }}</div><div class="confirm-btn"><a href="javascript:;" class="cancel" @click="no()">取消</a><a href="javascript:;" class="ok" @click="ok()">确定</a></div></section></div>';Vue.component("confirm",{template:confirm_html,data:function(){return{positionY:0,timer:null}},props:["msg","callback","obj"],methods:{no:function(){this.$emit("no")},ok:function(){this.$emit("ok",this.callback,this.obj)}}});var post_html='<span class="post-container"><span class="post-inner" v-if="postProcess">{{ txt }}...</span><span class="post-inner" @click="sub()" v-else>{{ txt }}</span></span>';Vue.component("subpost",{template:post_html,props:{txt:{type:String,default:""}},data:function(){return{postProcess:!1}},mounted:function(){},methods:{sub:function(){this.$emit("callback")},post:function(e,t){var n=this;jAjax({type:"post",url:e,data:t,timeOut:5e3,before:function(){n.postProcess=!0},success:function(e){e&&(e=JSON.parse(e),parseInt(e.code),n.$emit("succhandle",e)),n.postProcess=!1},error:function(e,t){n.postProcess=!1}})}}});