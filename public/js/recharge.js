"use strict";var app=new Vue({computed:{},mounted:function(){var e=this;e.loadChargeNum(),e.choose(e.charge_nums[0][Object.keys(e.charge_nums[0])[0]],Object.keys(e.charge_nums[0])[0],0)},data:{showAlert:!1,msg:null,charge:config.charge,charge_nums:[],tab_num:0,isOther:!1,charge_num:0,gift:0,balance:0,discount:config.charge.defaultGift,hasNum:!1},directives:{focus:{inserted:function(e){e.focus()}}},watch:{charge_num:function(e,a){var t=this;t.tab_num!=t.charge_nums.length-1&&(t.charge_num>t.charge.max||t.charge_num<t.charge.min)&&(t.charge_num=a),t.charge_num>0?t.hasNum=!0:t.hasNum=!1,t.gift=(parseFloat(t.charge_num)*parseFloat(t.discount)).toFixed(0),t.balance=(parseFloat(t.charge_num)+parseFloat(t.gift)).toFixed(0)}},methods:{showText:function(e){var a=!1;return 0==Object.keys(e)[0]&&(a=!0),a},loadChargeNum:function(){var e=this,a={0:e.discount};for(var t in config.charge.rules){var r={};config.charge.rules.hasOwnProperty(t)&&(r[t]=config.charge.rules[t],e.charge_nums.push(r))}e.charge_nums.push(a)},choose:function(e,a,t){var r=this;r.tab_num=t,0==parseFloat(a)?(a="",r.isOther=!0,r.discount=config.charge.defaultGift):(r.isOther=!1,r.discount=e),r.charge_num=a},sub:function(){var e=this;jAjax({type:"post",url:config.rechargeUrl,data:{charge_num:e.charge_num},timeOut:5e3,before:function(){console.log("before")},success:function(a){a&&(a=JSON.parse(a),200==parseInt(a.code)?(e.msg=a.message,e.showAlert=!0,e.close_auto(e.linkto,a.url)):(e.msg=a.message,e.showAlert=!0,e.close_auto()))},error:function(){console.log("error")}})},close:function(){this.showAlert=!1},close_auto:function(e,a){var t=this;setTimeout(function(){t.showAlert=!1,e&&e(a)},1500)},linkto:function(e){e&&(location.href=e)}}}).$mount("#recharge");