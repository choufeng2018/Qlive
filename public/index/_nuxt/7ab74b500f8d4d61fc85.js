(window.webpackJsonp=window.webpackJsonp||[]).push([[22],{391:function(e,r,t){"use strict";t.r(r);t(55);var n=t(9),o=t(351),c=t(352),d=t(56),f={props:["clickedNext","currentStep"],mixins:[o.validationMixin],data:function(){return{setPWform:{newPassWord:"",verifyPassWord:""}}},validations:{setPWform:{newPassWord:{required:c.required},verifyPassWord:{required:c.required}}},watch:{$v:{handler:function(e){var r=this;e.$invalid?(this.$emit("can-continue",{value:!1}),setTimeout(function(){r.$emit("change-next",{nextBtnValue:!1})},3e3)):this.$emit("can-continue",{value:!0})},deep:!0},clickedNext:function(e){!0===e&&this.$v.setPWform.$touch()}},methods:{registerApi:function(){var e=Object(n.a)(regeneratorRuntime.mark(function e(){var r,t;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:return r=this,e.next=3,Object(d.updatePassWordApi)(r,r.setPWform.newPassWord,r.setPWform.verifyPassWord);case 3:1===(t=e.sent).code?(r.$message({type:"success",message:t.msg,duration:5e3}),r.$emit("can-continue",{value:!0})):(r.$message({type:"error",message:t.msg,duration:5e3}),r.$emit("can-continue",{value:!1}));case 5:case"end":return e.stop()}},e,this)}));return function(){return e.apply(this,arguments)}}(),checkCode:function(){if(this.setPWform.newPassWord!==this.setPWform.verifyPassWord)return this.$message({type:"error",message:"俩次密码不相等，请确定再重试！",duration:5e3}),!1;this.registerApi()}},mounted:function(){this.$v.$invalid,this.$emit("can-continue",{value:!1})}},m=t(24),component=Object(m.a)(f,function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("div",{staticClass:"forget-main"},[t("b-form",{attrs:{id:"forget2"}},[t("b-form-group",[t("b-form-input",{class:e.$v.setPWform.newPassWord.$error?"error-input":"",attrs:{type:"text",required:"",placeholder:"请输入新密码"},on:{blur:function(r){return e.checkCode()}},model:{value:e.setPWform.newPassWord,callback:function(r){e.$set(e.setPWform,"newPassWord",r)},expression:"setPWform.newPassWord"}})],1),e._v(" "),t("b-form-group",{staticClass:"get-code"},[t("b-form-input",{class:e.$v.setPWform.verifyPassWord.$error?"error-input":"",attrs:{type:"text",required:"",placeholder:"请再次输入密码"},on:{blur:function(r){return e.checkCode()}},model:{value:e.setPWform.verifyPassWord,callback:function(r){e.$set(e.setPWform,"verifyPassWord",r)},expression:"setPWform.verifyPassWord"}})],1)],1)],1)},[],!1,null,null,null);r.default=component.exports}}]);