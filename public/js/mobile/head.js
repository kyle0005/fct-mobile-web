"use strict";Vue.component("head-top",{template:"#head_top",computed:{},mounted:function(){this.getTypeList()},props:{isindex:{type:Boolean,default:!1}},data:function(){return{open:!1,docked:!1,transitionName:"slide-left",typeList:[],loading:!1,refreshing:!1,pro_list_type:[]}},methods:{toIndex:function(){location.href=config.index},toLogin:function(){location.href=config.login},change:function(t){var e=this;e.isindex?e.$emit("changelist",t):location.href=config.product_url+"?code="+t},toggle:function(){if(this.open){this.open=!1;var t=this;setTimeout(function(){t.docked=!1},300)}else this.docked=!0,this.open=!0},prevent:function(t){t.preventDefault(),t.stopPropagation()},getTypeList:function(){this.typeList=config.productsType}},components:{}});