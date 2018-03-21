"use strict";var app=new Vue({mounted:function(){var t=this;""!==t.imgObj.backgroundUrl&&null!==t.imgObj.backgroundUrl&&void 0!==t.imgObj.backgroundUrl?(t.showBtn=!1,t.drawTop()):t.drawCanvas()},data:{showAlert:!1,msg:config.msg,showBtn:!0,imgObj:config.imgObj,ratio:0},methods:{drawTop:function(){var t=this;t.ratio=window.devicePixelRatio||1;var e=window.innerWidth||document.documentElement.clientWidth,i=window.innerHeight||document.documentElement.clientHeight,o=null;o=document.createElement("canvas");var a=document.getElementById("con_result");o.width=e*t.ratio,o.height=i*t.ratio;var n=o.getContext("2d");n.mozImageSmoothingEnabled=!1,n.webkitImageSmoothingEnabled=!1,n.msImageSmoothingEnabled=!1,n.imageSmoothingEnabled=!1,n.fillStyle="#ffffff",n.fillRect(0,0,e*t.ratio,i*t.ratio);var r=0,l=new Image;l.setAttribute("crossOrigin","anonymous"),l.src=t.imgObj.backgroundUrl,l.onload=function(){if(n.drawImage(l,0,0,e*t.ratio,l.height/l.width*e*t.ratio),2===(r+=1)){var m=Canvas2Image.convertToImage(o,e*t.ratio,i*t.ratio);m.style.width="100%",a.appendChild(m)}var c=new Image;c.setAttribute("crossOrigin","anonymous"),c.src=t.imgObj.qrcodeUrl,c.onload=function(){if(n.drawImage(c,(e-350/1242*e)/2*t.ratio,1165/1242*e*t.ratio,350/1242*e*t.ratio,350/1242*e*t.ratio),2===(r+=1)){var l=Canvas2Image.convertToImage(o,e*t.ratio,i*t.ratio);l.style.width="100%",a.appendChild(l)}}}},drawCanvas:function(){var t=this;t.ratio=window.devicePixelRatio||1;var e=window.innerWidth||document.documentElement.clientWidth,i=(window.innerHeight||document.documentElement.clientHeight,null);i=document.createElement("canvas");var o=document.getElementById("btn"),a=document.getElementById("con_result");i.width=e*t.ratio*2,i.height=970/750*e*t.ratio*2,i.style.width=e+"px",i.style.height=970/750*e+"px";var n=i.getContext("2d");n.mozImageSmoothingEnabled=!1,n.webkitImageSmoothingEnabled=!1,n.msImageSmoothingEnabled=!1,n.imageSmoothingEnabled=!1,n.fillStyle="#ffffff",n.fillRect(0,0,e*t.ratio*2,970/750*e*t.ratio*2);var r=.04*e*t.ratio*2;n.fillStyle="#333",n.font=16*t.ratio*2+"px 微软雅黑",n.fillText(t.imgObj.name,r,(e+70/750*e)*t.ratio*2),n.fillStyle="#666",n.font=15*t.ratio*2+"px 微软雅黑",n.fillText(t.imgObj.artistName,r,(e+.16*e)*t.ratio*2),n.fillStyle="#993333",n.font=20*t.ratio*2+"px 微软雅黑",n.fillText(t.imgObj.price,r,(e+.24*e)*t.ratio*2);var l=0,m=new Image;m.setAttribute("crossOrigin","anonymous"),m.src=t.imgObj.defaultImage,m.onload=function(){if(n.drawImage(m,0,0,e*t.ratio*2,m.height/m.width*e*t.ratio*2),3===(l+=1)){var r=Canvas2Image.convertToImage(i,e*t.ratio,970/750*e*t.ratio);r.style.width="100%",a.insertBefore(r,o)}var c=new Image;c.setAttribute("crossOrigin","anonymous"),c.src=t.imgObj.qrcodeUrl,c.onload=function(){if(n.drawImage(c,464/750*e*t.ratio*2,.92*e*t.ratio*2,260/750*e*t.ratio*2,260/750*e*t.ratio*2),3===(l+=1)){var r=Canvas2Image.convertToImage(i,e*t.ratio,970/750*e*t.ratio);r.style.width="100%",a.insertBefore(r,o)}};var g=new Image;g.setAttribute("crossOrigin","anonymous"),g.src=t.imgObj.headPortrait,g.onload=function(){if(t.circleImg(n,g,32/750*e,32/750*e,100/750*e/2),3===(l+=1)){var r=Canvas2Image.convertToImage(i,e*t.ratio,970/750*e*t.ratio);r.style.width="100%",a.insertBefore(r,o)}}}},preImage:function(t,e,i){var o=new Image;if(o.src=t,o.complete)return void e.call(o,i);o.onload=function(){e.call(o,i)},o.onerror=function(){var o=+new Date;vue.preImage(t+"?"+o,e,i)}},circleImg:function(t,e,i,o,a){var n=this;t.save();var r=2*a,l=(i+a)*n.ratio*2,m=(o+a)*n.ratio*2;t.beginPath(),t.lineWidth=3*n.ratio*2,t.strokeStyle="#fff",t.arc(l,m,a*n.ratio*2,0,2*Math.PI),t.stroke(),t.closePath(),t.clip(),t.drawImage(e,i*n.ratio*2,o*n.ratio*2,r*n.ratio*2,r*n.ratio*2),t.restore()},pop:function(){var t=this;t.showAlert=!0,t.close_auto()},close:function(){this.showAlert=!1},close_auto:function(t,e){var i=this;setTimeout(function(){i.showAlert=!1,t&&t(e)},1500)},linkto:function(t){t&&(location.href=t)}}}).$mount("#screenshot");