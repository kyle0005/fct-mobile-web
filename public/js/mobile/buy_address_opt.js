"use strict";var app=new Vue({computed:{provincesName:function(){var t=this,i={};return t.toProvince(),t.citylist.forEach(function(t,c){i[c]=t.p}),t.provinceName=i[t.province],i},citysName:function(){var t=this,i={};return t.citylist[t.province]&&t.citylist[t.province].c&&(t.toCity(),t.citylist[t.province].c.forEach(function(t,c){i[c]=t.n})),t.cityName=i[t.city],i},countysName:function(){var t=this,i={};return t.citylist[t.province]&&t.citylist[t.province].c[t.city]&&t.citylist[t.province].c[t.city].a&&(t.toCounty(),t.citylist[t.province].c[t.city].a.forEach(function(t,c){i[c]=t.s})),t.countyName=i[t.county],i}},watch:{province:function(t,i){t==i||this.isFir||(this.city=Object.getOwnPropertyNames(this.citysName)[0])},city:function(t,i){t==i||this.isFir||(this.county=Object.getOwnPropertyNames(this.countysName)[0]),this.isFir=!1}},mounted:function(){},data:{address_obj:config.address,showAlert:!1,msg:null,citylist:citylist,isFir:!0,id:config.address.id||"",province:config.address.province||"北京",city:config.address.cityId||"北京",county:config.address.townId||"东城区",provinceName:"",cityName:"",countyName:"",isDefault:config.address.isDefault||!1,address:config.address.address||"",cellPhone:config.address.cellPhone||"",name:config.address.name||"",subText:"确认保存"},methods:{sub:function(){var t=this,i=config.saveAddressddUrl,c={id:t.id,province:t.provinceName,city:t.cityName,county:t.countyName,isDefault:t.isDefault?1:0,address:t.address,cellPhone:t.cellPhone,name:t.name};t.$refs.subpost.post(i,c)},toProvince:function(){var t=this;t.citylist.forEach(function(i,c){i.p==t.province&&(t.province=c)})},toCity:function(){var t=this;t.citylist[t.province].c.forEach(function(i,c){i.n==t.city&&(t.city=c)})},toCounty:function(){var t=this;t.citylist[t.province].c[t.city].a.forEach(function(i,c){i.s==t.county&&(t.county=c)})},succhandle:function(t){var i=this;i.msg=t.message,i.showAlert=!0,t.url?i.close_auto(i.linkto,t.url):i.close_auto()},close:function(){this.showAlert=!1},close_auto:function(t,i){var c=this;setTimeout(function(){c.showAlert=!1,t&&t(i)},1500)},linkto:function(t){t&&(location.href=t)}}}).$mount("#buy_address");