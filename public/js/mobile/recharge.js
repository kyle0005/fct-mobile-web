"use strict";var app=new Vue({mounted:function(){var e=this;e.loadChargeNum(),e.choose(e.charge_nums[0].giftPercent,e.charge_nums[0].price,0)},data:{showAlert:!1,msg:null,charge:config.charge,charge_nums:config.charge.rules,tab_num:0,isOther:!1,charge_num:0,gift:0,balance:0,data_charge_num:0,discount:config.charge.defaultGift,hasNum:!1,subText:"我要充值"},directives:{focus:{inserted:function(e){e.focus()}}},watch:{charge_num:function(e,t){var a=this,n=0;n=parseFloat(e.toString().replace(/[^\d]/g,"")),a.charge_num=n||"",a.tab_num!=a.charge_nums.length-1&&(a.charge_num>a.charge.max||a.charge_num<a.charge.min)&&(a.charge_num=t),a.charge_num>0?a.hasNum=!0:a.hasNum=!1,a.gift=(parseFloat(a.charge_num)*parseFloat(a.discount)).toFixed(0),a.balance=(parseFloat(a.charge_num)+parseFloat(a.gift)).toFixed(0)}},computed:{},methods:{toFloat:function(e){var t=this;return e>0?(t.data_charge_num=e.toFixed(2),e.toFixed(2)):"0.00"},showText:function(e){var t=!1;return 0==e.price&&(t=!0),t},loadChargeNum:function(){var e=this,t={giftPercent:e.discount,price:0};e.charge_nums.push(t)},choose:function(e,t,a){var n=this;n.tab_num=a,0==parseFloat(t)?(t="",n.isOther=!0,n.discount=config.charge.defaultGift):(n.isOther=!1,n.discount=e),n.charge_num=t},sub:function(){var e=this,t=config.rechargeUrl,a={charge_num:e.data_charge_num};e.$refs.subpost.post(t,a)},succhandle:function(e){var t=this;t.msg=e.message,t.showAlert=!0,e.url?t.close_auto(t.linkto,e.url):t.close_auto()},close:function(){this.showAlert=!1},close_auto:function(e,t){var a=this;setTimeout(function(){a.showAlert=!1,e&&e(t)},1500)},linkto:function(e){e&&(location.href=e)}}}).$mount("#recharge");