(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{348:function(e,t,o){"use strict";o(98),o(67),o(37),o(55);var n=o(9),r=o(2),l=o(54),d=o(56),c=o(21),v={data:function(){return{liveSearch:"",timeout:null,logoutVisible:!1}},computed:Object(r.a)({},Object(l.b)(["user"])),methods:{gotoLogin:function(){this.$router.push("/login")},gotoUser:function(){this.$router.push("/user/userinfo")},querySearchAsync:function(){var e=Object(n.a)(regeneratorRuntime.mark(function e(t,o){var n,r,l,data,c,v,m,f,h,i;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:if(n=this,void 0===t||""===t){e.next=30;break}return r=[{}],e.next=5,Object(d.searchApi)(n,t);case 5:for(l=e.sent,data=l.data,c=!0,v=!1,m=void 0,e.prev=10,f=data[Symbol.iterator]();!(c=(h=f.next()).done);c=!0)(i=h.value).value=i.title;e.next=18;break;case 14:e.prev=14,e.t0=e.catch(10),v=!0,m=e.t0;case 18:e.prev=18,e.prev=19,c||null==f.return||f.return();case 21:if(e.prev=21,!v){e.next=24;break}throw m;case 24:return e.finish(21);case 25:return e.finish(18);case 26:r=data,0===data.length&&(r=[{value:"没有搜到相关项目，请重新再搜索！"}]),clearTimeout(this.timeout),this.timeout=setTimeout(function(){o(r)},3e3*Math.random());case 30:case"end":return e.stop()}},e,this,[[10,14,18,26],[19,,21,25]])}));return function(t,o){return e.apply(this,arguments)}}(),handleSelectSearch:function(e){e.is_living?this.$router.push({path:"/future-live/"+e.id}):this.$router.push({path:"/history-live/"+e.id})},logoutUser:function(){var e=Object(n.a)(regeneratorRuntime.mark(function e(){var t;return regeneratorRuntime.wrap(function(e){for(;;)switch(e.prev=e.next){case 0:t=this,Object(c.removeToken)(),t.$router.push("/login");case 3:case"end":return e.stop()}},e,this)}));return function(){return e.apply(this,arguments)}}(),getToken:function(){return Object(c.getToken)()}},mounted:function(){}},m=(o(397),o(24)),component=Object(m.a)(v,function(){var e=this,t=e.$createElement,o=e._self._c||t;return o("header",{staticClass:"live-header"},[e._m(0),e._v(" "),o("nav",{staticClass:"navbar navbar-expand-md navbar-light live-narbar"},[o("div",{staticClass:"container"},[o("nuxt-link",{staticClass:"navbar-brand",attrs:{to:"/"}},[o("img",{staticClass:"logo",attrs:{src:"/images/live2.png",alt:"live2"}})]),e._v(" "),e._m(1),e._v(" "),o("div",{staticClass:"collapse navbar-collapse",attrs:{id:"navbarCollapse"}},[o("ul",{staticClass:"navbar-nav ml-auto"},[o("li",{staticClass:"nav-item active"},[o("nuxt-link",{staticClass:"nav-link",attrs:{to:"/"}},[e._v("首页")])],1),e._v(" "),o("li",{staticClass:"nav-item"},[o("nuxt-link",{staticClass:"nav-link",attrs:{to:"/future-live"}},[e._v("直播")])],1),e._v(" "),o("li",{staticClass:"nav-item"},[o("nuxt-link",{staticClass:"nav-link",attrs:{to:"/history-live"}},[e._v("往期")])],1)]),e._v(" "),o("form",{staticClass:"form-inline mt-2 mt-md-0 search"},[o("div",{staticClass:"inner-addon right-addon"},[o("el-autocomplete",{staticClass:"live-search",attrs:{"fetch-suggestions":e.querySearchAsync,placeholder:"","prefix-icon":"el-icon-search"},on:{select:e.handleSelectSearch},model:{value:e.liveSearch,callback:function(t){e.liveSearch=t},expression:"liveSearch"}})],1)]),e._v(" "),void 0!==e.getToken()?o("el-popover",{attrs:{placement:"top"},model:{value:e.logoutVisible,callback:function(t){e.logoutVisible=t},expression:"logoutVisible"}},[o("el-button",{staticClass:"my-1",staticStyle:{width:"100%","margin-left":"0"},attrs:{size:"mini"},on:{click:function(t){return e.gotoUser()}}},[e._v("个人中心")]),e._v(" "),o("el-button",{staticClass:"my-1",staticStyle:{width:"100%","margin-left":"0"},attrs:{size:"mini"},on:{click:function(t){return e.logoutUser()}}},[e._v("退出登录")]),e._v(" "),o("div",{staticClass:"user",attrs:{slot:"reference"},slot:"reference"},[o("i",{staticClass:"fas fa-user p-2"}),e._v(" "),o("span",{staticClass:"align-middle"},[e._v(e._s(e.user.name))])])],1):o("div",{staticClass:"user",on:{click:function(t){return e.gotoLogin()}}},[o("i",{staticClass:"fas fa-user p-2"}),e._v(" "),o("span",{staticClass:"align-middle"},[e._v("登录网站")])])],1)],1)])])},[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"top-bar d-flex flex-column align-items-center"},[t("img",{staticClass:"logo",attrs:{src:"/images/live1.png",alt:"live1"}})])},function(){var e=this.$createElement,t=this._self._c||e;return t("button",{staticClass:"navbar-toggler",attrs:{type:"button","data-toggle":"collapse","data-target":"#navbarCollapse","aria-controls":"navbarCollapse","aria-expanded":"false","aria-label":"Toggle navigation"}},[t("span",{staticClass:"navbar-toggler-icon"})])}],!1,null,null,null);t.a=component.exports},349:function(e,t,o){"use strict";o(399);var n=o(24),component=Object(n.a)({},function(){var e=this,t=e.$createElement,o=e._self._c||t;return o("footer",{staticClass:"live-footer"},[e._m(0),e._v(" "),o("div",{staticClass:"live-about py-4"},[o("div",{staticClass:"container"},[o("div",{staticClass:"row"},[e._m(1),e._v(" "),o("div",{staticClass:"col-md-12 col-lg-6 align-self-center text-center"},[o("div",{staticClass:"row mt-4 mt-sm-4 mt-md-4 mt-lg-0 mt-xl-0"},[o("div",{staticClass:"col"},[o("nuxt-link",{attrs:{to:"/"}},[e._v("首页")])],1),e._v(" "),o("div",{staticClass:"col"},[o("nuxt-link",{attrs:{to:"/future-live"}},[e._v("直播中心")])],1),e._v(" "),o("div",{staticClass:"col"},[o("nuxt-link",{attrs:{to:"/history-live"}},[e._v("往期直播")])],1),e._v(" "),o("div",{staticClass:"col"},[o("nuxt-link",{attrs:{to:"#"}},[e._v("联系我们")])],1)])])])])]),e._v(" "),e._m(2)])},[function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"bottom-bar d-flex"},[t("div",{staticClass:"container"},[t("img",{staticClass:"logo",attrs:{src:"/images/live9.png",alt:"live9"}})])])},function(){var e=this.$createElement,t=this._self._c||e;return t("div",{staticClass:"col-md-12 col-lg-6"},[t("div",{staticClass:"row"},[t("div",{staticClass:"col-12 col-sm-6"},[t("div",{staticClass:"media"},[t("img",{staticClass:"mr-3",attrs:{src:"/images/live10.png",alt:"live10"}}),this._v(" "),t("div",{staticClass:"media-body d-flex align-self-center"},[this._v("扫一扫,关注尔听美公众号")])])]),this._v(" "),t("div",{staticClass:"col-12 col-sm-6 mt-4 mt-sm-0 mt-md-0 mt-lg-0 mt-xl-0"},[t("div",{staticClass:"media"},[t("img",{staticClass:"mr-3",attrs:{src:"/images/live10.png",alt:"live10"}}),this._v(" "),t("div",{staticClass:"media-body d-flex align-self-center"},[this._v("扫一扫,关注尔听美公众号")])])])])])},function(){var e=this,t=e.$createElement,o=e._self._c||t;return o("div",{staticClass:"live-copyright py-4"},[o("div",{staticClass:"container"},[o("div",{staticClass:"copyright text-center"},[e._v("\n        © 2018 Natus Medical Incorporated。版权所有。\n        "),o("a",{attrs:{href:"#"}},[e._v("隐私政策")]),e._v(" |\n        "),o("a",{attrs:{href:"#"}},[e._v("法律声明")]),e._v(" |\n        "),o("a",{attrs:{href:"#"}},[e._v("求职者隐私声明")]),e._v(" |\n        "),o("a",{attrs:{href:"#"}},[e._v("网站地图")]),e._v(" |\n        "),o("a",{attrs:{href:"#"}},[e._v("条款和条件")])])])])}],!1,null,null,null);t.a=component.exports},358:function(e,t,o){var content=o(398);"string"==typeof content&&(content=[[e.i,content,""]]),content.locals&&(e.exports=content.locals);(0,o(97).default)("f3edac3e",content,!0,{sourceMap:!1})},359:function(e,t,o){var content=o(400);"string"==typeof content&&(content=[[e.i,content,""]]),content.locals&&(e.exports=content.locals);(0,o(97).default)("71549d7d",content,!0,{sourceMap:!1})},397:function(e,t,o){"use strict";var n=o(358);o.n(n).a},398:function(e,t,o){(e.exports=o(96)(!1)).push([e.i,'a{color:#999}a,a:hover{text-decoration:none;background-color:transparent}a:hover{color:#000;cursor:pointer}.video-play-icon{width:80px;border-radius:50px;background-color:rgba(0,0,0,.5);padding:10px 0;cursor:pointer;z-index:1}.video-play-icon i.fa-play{color:#fff;font-size:18px}.video-play-icon:hover{background-color:#00889c}.video-play-cover{position:absolute;top:0;left:0;background-color:rgba(0,0,0,.3);z-index:0}.video-author{z-index:1;padding:20px;width:100%;background-image:linear-gradient(180deg,rgba(0,0,0,.8),transparent)}.video-author .left{color:#fff;font-size:16px;font-weight:500}.video-author .left img{border-radius:50%;width:40px;margin-right:5px}.video-author .right{position:absolute;right:20px}.video-author .right .bottom-title a{color:#fff;font-size:13px;font-weight:400}.video-author .right .bottom-title i{font-size:20px;margin-bottom:5px}.video-author .right .bottom-title:first-child{margin-right:20px}.page-enter-active,.page-leave-active{transition:opacity .2s}.page-enter,.page-leave-active{opacity:0}.live-pagination ul.pagination.b-pagination{justify-content:center}.live-pagination ul.pagination.b-pagination li.page-item{margin:0 5px}.live-pagination ul.pagination.b-pagination li.page-item:last-child{margin-left:0;margin-right:0}.live-pagination ul.pagination.b-pagination li.page-item.active a.page-link{color:#fff;background-color:#00889c;border-color:#067586}.live-pagination ul.pagination.b-pagination li.page-item.active a.page-link:focus{box-shadow:0 0 0 .2rem rgba(6,117,134,.2)}.live-pagination ul.pagination.b-pagination li.page-item a.page-link{color:#333}.btn.btn-reservation{width:170px;border:none;color:#fff;padding:10px 0;font-size:14px;letter-spacing:1px}.btn.btn-reservation.video-toll{background-image:linear-gradient(270deg,#fd4c65,#ff6a7f)}.btn.btn-reservation.video-free{background-image:linear-gradient(270deg,#00889c,#47bdcf)}.btn.btn-advisory{width:170px;background-image:linear-gradient(270deg,#b4b5b6,#e3e3e3);border:none;color:#000;padding:10px 0;font-size:14px;letter-spacing:1px}.cursor-default{cursor:auto!important}.overflow-y-hidden{overflow-y:hidden}.phone-display-none{display:none}.phone-display-block{display:block;margin-bottom:1.5rem}.custom-control-input:checked~.custom-control-label:before{color:#00889c;border-color:#00889c;background-color:#00889c}.user-main .user-content-title{font-size:1rem;color:#00889c;font-weight:600;letter-spacing:1px}.user-main .user-content-title i{font-size:1.5rem;margin-right:10px}.table .thead-light th{background-color:#ececec;border-color:#ececec}.table{border:1px solid #ececec}.live-home .card-img-top{height:18.75rem;overflow-x:hidden}.live-home .card-img-top img{height:100%}.noData .shadow-none{height:50vh;align-content:center;align-items:center;justify-content:center;display:flex;background-color:#fff!important}.animated{-webkit-animation-duration:.3s;animation-duration:.3s;-webkit-animation-fill-mode:both;animation-fill-mode:both}.animated-1000ms{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes bounceInDown{0%,60%,75%,90%,to{transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{opacity:0;-webkit-transform:translate3d(0,-3000px,0);transform:translate3d(0,-3000px,0)}60%{opacity:1;-webkit-transform:translate3d(0,25px,0);transform:translate3d(0,25px,0)}75%{-webkit-transform:translate3d(0,-10px,0);transform:translate3d(0,-10px,0)}90%{-webkit-transform:translate3d(0,5px,0);transform:translate3d(0,5px,0)}to{-webkit-transform:none;transform:none}}@keyframes bounceInDown{0%,60%,75%,90%,to{transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{opacity:0;-webkit-transform:translate3d(0,-3000px,0);transform:translate3d(0,-3000px,0)}60%{opacity:1;-webkit-transform:translate3d(0,25px,0);transform:translate3d(0,25px,0)}75%{-webkit-transform:translate3d(0,-10px,0);transform:translate3d(0,-10px,0)}90%{-webkit-transform:translate3d(0,5px,0);transform:translate3d(0,5px,0)}to{-webkit-transform:none;transform:none}}.bounceInDown{-webkit-animation-name:bounceInDown;animation-name:bounceInDown}@-webkit-keyframes fadeInLeft{0%{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}to{opacity:1;-webkit-transform:none;transform:none}}@keyframes fadeInLeft{0%{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}to{opacity:1;-webkit-transform:none;transform:none}}.fadeInLeft{-webkit-animation-name:fadeInLeft;animation-name:fadeInLeft}@-webkit-keyframes fadeInRight{0%{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}to{opacity:1;-webkit-transform:none;transform:none}}@keyframes fadeInRight{0%{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}to{opacity:1;-webkit-transform:none;transform:none}}.fadeInRight{-webkit-animation-name:fadeInRight;animation-name:fadeInRight}@-webkit-keyframes fadeOutLeft{0%{opacity:1}to{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}}@keyframes fadeOutLeft{0%{opacity:1}to{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}}.fadeOutLeft{-webkit-animation-name:fadeOutLeft;animation-name:fadeOutLeft}@-webkit-keyframes fadeOutRight{0%{opacity:1}to{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}}@keyframes fadeOutRight{0%{opacity:1}to{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}}.fadeOutRight{-webkit-animation-name:fadeOutRight;animation-name:fadeOutRight}@font-face{font-family:nf-icon;src:url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.eot);src:url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.eot#iefix) format("embedded-opentype"),url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.woff) format("woff"),url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.ttf) format("truetype"),url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.svg#nf-icon-v1-86) format("svg");font-weight:400;font-style:normal}.video-js{font-size:16px;color:#cacaca}.vjs-default-skin .vjs-big-play-button{font-size:4em;line-height:1.5em;height:1.5em;width:1.5em;border:.06666em solid #b7090b;border-radius:50%;display:none;left:50%!important;top:40%!important;margin-left:-.75em;margin-top:-.75em}.video-js .vjs-play-control,.video-js .vjs-remaining-time,.video-js .vjs-volume-menu-button{border-right:1px solid #323232}.video-js .vjs-volume-menu-button .vjs-menu-content:before{content:"";display:inline-block;vertical-align:middle;height:100%}.video-js .vjs-volume-menu-button .vjs-menu-content .vjs-volume-bar{display:inline-block;vertical-align:middle}.video-js .vjs-control:before{font-family:nf-icon}.video-js .vjs-control.vjs-play-control:before{content:"\\e646"}.video-js .vjs-control.vjs-play-control.vjs-playing:before{content:"\\e645"}.video-js .vjs-control.vjs-fullscreen-control:before{content:"\\e642"}.video-js .vjs-control.vjs-volume-menu-button:before{content:"\\e630"}.video-js .vjs-control.vjs-captions-button:before{content:"\\e650"}.video-js .vjs-big-play-button,.video-js .vjs-control-bar,.video-js .vjs-menu-button .vjs-menu-content{background-color:#262626;background-color:rgba(38,38,38,.9)}.video-js .vjs-control-bar{background-color:rgba(38,38,38,.9);width:auto;left:4em;right:4em;bottom:2em;border-radius:.5em}.video-js .vjs-control-bar:hover .vjs-progress-control{opacity:1;top:-2.5em}.video-js .vjs-control-bar .vjs-menu{z-index:2;height:100%}.video-js.vjs-fullscreen .vjs-control-bar{bottom:4em}.video-js .vjs-current-time{display:block;position:absolute;right:0;top:-2.5em}.video-js .vjs-slider{background-color:#2e2e2e;background-color:rgba(46,46,46,.8);border-radius:1em}.video-js .vjs-remaining-time{flex:1;text-align:left}.video-js .vjs-play-progress,.video-js .vjs-slider-bar,.video-js .vjs-volume-level{background:#cacaca;border-radius:1em}.video-js .vjs-play-progress{color:#b7090b;background:#b7090b;font-size:1.3em}.video-js .vjs-play-progress:before{transition:width .1s ease-out,height .1s ease-out;content:"";top:-.2em;border:0;background:radial-gradient(#b7090b 33%,#830607);width:1em;height:1em;border-radius:50%;box-shadow:0 0 2px #000}.video-js .vjs-play-progress:hover:before{width:1.1em;height:1.1em;border:2px solid transparent}.video-js .vjs-progress-control{position:absolute;left:0;right:0;width:100%;padding:0 4em 0 .4em;top:-2.3em;border-radius:1em;transition:top .15s linear,opacity .15s linear,transform .15s linear,-webkit-transform .15s linear;z-index:1;opacity:0}.video-js .vjs-progress-control:hover .vjs-progress-holder{font-size:inherit}.video-js .vjs-progress-control .vjs-mouse-display{background:#cacaca}.video-js .vjs-progress-control .vjs-mouse-display:before{top:100%;content:" ";height:0;width:0;position:absolute;border:.8em solid transparent;border-top-color:#262626;right:25%;margin-left:-.8em}.video-js .vjs-time-tooltip{background:#cacaca!important;color:#b7090b}.video-js .vjs-time-tooltip:before{top:100%;content:" ";height:0;width:0;position:absolute;border:.8em solid transparent;border-top-color:#262626;right:25%;margin-left:-.8em}.video-js .vjs-load-progress,.video-js .vjs-play-progress{height:.7em!important}.video-js .vjs-progress-holder{height:.9em}.video-js .vjs-load-progress{background:#3a3a3a;background:rgba(46,46,46,.5);border-radius:1em;height:.9em!important}.video-js .vjs-load-progress div{background:#3a3a3a;background:rgba(46,46,46,.75);border-radius:1em;height:.9em!important}.vjs-loading-spinner{border:none;opacity:0;visibility:hidden;-webkit-animation:vjs-spinner-fade-out 2s linear 1;animation:vjs-spinner-fade-out 2s linear 1;-webkit-animation-delay:2s;animation-delay:2s}.vjs-loading-spinner:after,.vjs-loading-spinner:before{border:none}.vjs-loading-spinner:after{background-image:url(https://assets.nflxext.com/en_us/pages/wiplayer/site-spinner.png);background-repeat:no-repeat;background-position-x:50%;background-position-y:50%;background-size:100%}.vjs-seeking .vjs-loading-spinner:after,.vjs-waiting .vjs-loading-spinner:after{-webkit-animation:vjs-spinner-spin 1.1s linear infinite,vjs-spinner-fade 1.1s linear 1!important;animation:vjs-spinner-spin 1.1s linear infinite,vjs-spinner-fade 1.1s linear 1!important;-webkit-animation-delay:2s;animation-delay:2s}.vjs-seeking .vjs-loading-spinner,.vjs-waiting .vjs-loading-spinner{opacity:1;visibility:visible;-webkit-animation:vjs-spinner-fade-in 2s linear 1;animation:vjs-spinner-fade-in 2s linear 1;-webkit-animation-delay:2s;animation-delay:2s}@-webkit-keyframes vjs-spinner-fade-in{0%{opacity:0;visibility:visible}to{opacity:1;visibility:visible}}@keyframes vjs-spinner-fade-in{0%{opacity:0;visibility:visible}to{opacity:1;visibility:visible}}@-webkit-keyframes vjs-spinner-fade-out{0%{opacity:1;visibility:visible}to{opacity:0;visibility:visible}}@keyframes vjs-spinner-fade-out{0%{opacity:1;visibility:visible}to{opacity:0;visibility:visible}}.live-header .top-bar{background-color:#00889c;height:40px;justify-content:center}.live-header .live-narbar .search .inner-addon{width:100%}.live-header .live-narbar .search .inner-addon .live-search{padding:0;border-radius:0;margin-left:2rem;margin-right:1.25rem;right:.75rem;width:130px}.live-header .live-narbar .search .inner-addon .live-search input{width:100%}.live-header .live-narbar .search input.form-control{border:1px solid #d7d8d9;width:100%;margin-left:0}.live-header .live-narbar .search .search-btn{background-color:#fff;color:#00889c;border-color:#00889c;margin:0 auto}.live-header .live-narbar .search .search-btn:hover{background-color:#00889c;color:#fff;border-color:#00889c}.live-header .live-narbar .search .search-btn:focus{box-shadow:0 0 0 .2rem rgba(0,136,156,.36)}.live-header .live-narbar.navbar-light .navbar-nav .nav-link{position:relative;font-size:16px;color:#333}.live-header .live-narbar.navbar-light .navbar-nav .nav-link:after{content:"/";position:absolute;right:0;font-size:1rem;color:#ececec}.live-header .live-narbar.navbar-light .navbar-nav li:last-child .nav-link:after{content:""}.live-header .live-narbar.navbar-light .navbar-nav .nav-link:focus,.live-header .live-narbar.navbar-light .navbar-nav .nav-link:hover{color:#00889c}.live-header .live-narbar.navbar-expand-md{box-shadow:0 1px 4px 0 rgba(0,0,0,.37)}.live-header .live-narbar.navbar-expand-md .navbar-brand img{width:70%}.live-header .live-narbar .user{text-align:center;cursor:pointer}.live-header .live-narbar .user i{background-color:#dddcdc;border-radius:50%;color:#00889c;font-size:18px}.live-header .live-narbar .user span{margin-top:10px;font-size:16px;color:#00889c;display:block}@media (min-width:768px) and (max-width:991px){.live-header .live-narbar.navbar-expand-md .navbar-nav .nav-link{padding-right:10px;padding-left:10px}}@media (min-width:992px){.live-header .live-narbar.navbar-expand-md .navbar-nav .nav-link{padding-right:2rem;padding-left:2rem}}@media (max-width:768px){.live-header .live-narbar .search .inner-addon .live-search{padding:0;border-radius:0;margin-left:0;margin-right:1.25rem;right:0;width:100%;margin-bottom:1rem}}@media (min-width:768px){.live-header .live-narbar.navbar-expand-md{background-color:#fff;box-shadow:none}.live-header .live-narbar .user i{background-color:#dddcdc;border-radius:50%;color:#00889c;font-size:12px}.live-header .live-narbar .user span{font-size:14px;color:#00889c;display:inline}}',""])},399:function(e,t,o){"use strict";var n=o(359);o.n(n).a},400:function(e,t,o){(e.exports=o(96)(!1)).push([e.i,'a{color:#999}a,a:hover{text-decoration:none;background-color:transparent}a:hover{color:#000;cursor:pointer}.video-play-icon{width:80px;border-radius:50px;background-color:rgba(0,0,0,.5);padding:10px 0;cursor:pointer;z-index:1}.video-play-icon i.fa-play{color:#fff;font-size:18px}.video-play-icon:hover{background-color:#00889c}.video-play-cover{position:absolute;top:0;left:0;background-color:rgba(0,0,0,.3);z-index:0}.video-author{z-index:1;padding:20px;width:100%;background-image:linear-gradient(180deg,rgba(0,0,0,.8),transparent)}.video-author .left{color:#fff;font-size:16px;font-weight:500}.video-author .left img{border-radius:50%;width:40px;margin-right:5px}.video-author .right{position:absolute;right:20px}.video-author .right .bottom-title a{color:#fff;font-size:13px;font-weight:400}.video-author .right .bottom-title i{font-size:20px;margin-bottom:5px}.video-author .right .bottom-title:first-child{margin-right:20px}.page-enter-active,.page-leave-active{transition:opacity .2s}.page-enter,.page-leave-active{opacity:0}.live-pagination ul.pagination.b-pagination{justify-content:center}.live-pagination ul.pagination.b-pagination li.page-item{margin:0 5px}.live-pagination ul.pagination.b-pagination li.page-item:last-child{margin-left:0;margin-right:0}.live-pagination ul.pagination.b-pagination li.page-item.active a.page-link{color:#fff;background-color:#00889c;border-color:#067586}.live-pagination ul.pagination.b-pagination li.page-item.active a.page-link:focus{box-shadow:0 0 0 .2rem rgba(6,117,134,.2)}.live-pagination ul.pagination.b-pagination li.page-item a.page-link{color:#333}.btn.btn-reservation{width:170px;border:none;color:#fff;padding:10px 0;font-size:14px;letter-spacing:1px}.btn.btn-reservation.video-toll{background-image:linear-gradient(270deg,#fd4c65,#ff6a7f)}.btn.btn-reservation.video-free{background-image:linear-gradient(270deg,#00889c,#47bdcf)}.btn.btn-advisory{width:170px;background-image:linear-gradient(270deg,#b4b5b6,#e3e3e3);border:none;color:#000;padding:10px 0;font-size:14px;letter-spacing:1px}.cursor-default{cursor:auto!important}.overflow-y-hidden{overflow-y:hidden}.phone-display-none{display:none}.phone-display-block{display:block;margin-bottom:1.5rem}.custom-control-input:checked~.custom-control-label:before{color:#00889c;border-color:#00889c;background-color:#00889c}.user-main .user-content-title{font-size:1rem;color:#00889c;font-weight:600;letter-spacing:1px}.user-main .user-content-title i{font-size:1.5rem;margin-right:10px}.table .thead-light th{background-color:#ececec;border-color:#ececec}.table{border:1px solid #ececec}.live-home .card-img-top{height:18.75rem;overflow-x:hidden}.live-home .card-img-top img{height:100%}.noData .shadow-none{height:50vh;align-content:center;align-items:center;justify-content:center;display:flex;background-color:#fff!important}.animated{-webkit-animation-duration:.3s;animation-duration:.3s;-webkit-animation-fill-mode:both;animation-fill-mode:both}.animated-1000ms{-webkit-animation-duration:1s;animation-duration:1s;-webkit-animation-fill-mode:both;animation-fill-mode:both}@-webkit-keyframes bounceInDown{0%,60%,75%,90%,to{transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{opacity:0;-webkit-transform:translate3d(0,-3000px,0);transform:translate3d(0,-3000px,0)}60%{opacity:1;-webkit-transform:translate3d(0,25px,0);transform:translate3d(0,25px,0)}75%{-webkit-transform:translate3d(0,-10px,0);transform:translate3d(0,-10px,0)}90%{-webkit-transform:translate3d(0,5px,0);transform:translate3d(0,5px,0)}to{-webkit-transform:none;transform:none}}@keyframes bounceInDown{0%,60%,75%,90%,to{transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{opacity:0;-webkit-transform:translate3d(0,-3000px,0);transform:translate3d(0,-3000px,0)}60%{opacity:1;-webkit-transform:translate3d(0,25px,0);transform:translate3d(0,25px,0)}75%{-webkit-transform:translate3d(0,-10px,0);transform:translate3d(0,-10px,0)}90%{-webkit-transform:translate3d(0,5px,0);transform:translate3d(0,5px,0)}to{-webkit-transform:none;transform:none}}.bounceInDown{-webkit-animation-name:bounceInDown;animation-name:bounceInDown}@-webkit-keyframes fadeInLeft{0%{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}to{opacity:1;-webkit-transform:none;transform:none}}@keyframes fadeInLeft{0%{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}to{opacity:1;-webkit-transform:none;transform:none}}.fadeInLeft{-webkit-animation-name:fadeInLeft;animation-name:fadeInLeft}@-webkit-keyframes fadeInRight{0%{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}to{opacity:1;-webkit-transform:none;transform:none}}@keyframes fadeInRight{0%{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}to{opacity:1;-webkit-transform:none;transform:none}}.fadeInRight{-webkit-animation-name:fadeInRight;animation-name:fadeInRight}@-webkit-keyframes fadeOutLeft{0%{opacity:1}to{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}}@keyframes fadeOutLeft{0%{opacity:1}to{opacity:0;-webkit-transform:translate3d(-100%,0,0);transform:translate3d(-100%,0,0)}}.fadeOutLeft{-webkit-animation-name:fadeOutLeft;animation-name:fadeOutLeft}@-webkit-keyframes fadeOutRight{0%{opacity:1}to{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}}@keyframes fadeOutRight{0%{opacity:1}to{opacity:0;-webkit-transform:translate3d(100%,0,0);transform:translate3d(100%,0,0)}}.fadeOutRight{-webkit-animation-name:fadeOutRight;animation-name:fadeOutRight}@font-face{font-family:nf-icon;src:url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.eot);src:url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.eot#iefix) format("embedded-opentype"),url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.woff) format("woff"),url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.ttf) format("truetype"),url(https://assets.nflxext.com/ffe/siteui/fonts/nf-icon-v1-86.svg#nf-icon-v1-86) format("svg");font-weight:400;font-style:normal}.video-js{font-size:16px;color:#cacaca}.vjs-default-skin .vjs-big-play-button{font-size:4em;line-height:1.5em;height:1.5em;width:1.5em;border:.06666em solid #b7090b;border-radius:50%;display:none;left:50%!important;top:40%!important;margin-left:-.75em;margin-top:-.75em}.video-js .vjs-play-control,.video-js .vjs-remaining-time,.video-js .vjs-volume-menu-button{border-right:1px solid #323232}.video-js .vjs-volume-menu-button .vjs-menu-content:before{content:"";display:inline-block;vertical-align:middle;height:100%}.video-js .vjs-volume-menu-button .vjs-menu-content .vjs-volume-bar{display:inline-block;vertical-align:middle}.video-js .vjs-control:before{font-family:nf-icon}.video-js .vjs-control.vjs-play-control:before{content:"\\e646"}.video-js .vjs-control.vjs-play-control.vjs-playing:before{content:"\\e645"}.video-js .vjs-control.vjs-fullscreen-control:before{content:"\\e642"}.video-js .vjs-control.vjs-volume-menu-button:before{content:"\\e630"}.video-js .vjs-control.vjs-captions-button:before{content:"\\e650"}.video-js .vjs-big-play-button,.video-js .vjs-control-bar,.video-js .vjs-menu-button .vjs-menu-content{background-color:#262626;background-color:rgba(38,38,38,.9)}.video-js .vjs-control-bar{background-color:rgba(38,38,38,.9);width:auto;left:4em;right:4em;bottom:2em;border-radius:.5em}.video-js .vjs-control-bar:hover .vjs-progress-control{opacity:1;top:-2.5em}.video-js .vjs-control-bar .vjs-menu{z-index:2;height:100%}.video-js.vjs-fullscreen .vjs-control-bar{bottom:4em}.video-js .vjs-current-time{display:block;position:absolute;right:0;top:-2.5em}.video-js .vjs-slider{background-color:#2e2e2e;background-color:rgba(46,46,46,.8);border-radius:1em}.video-js .vjs-remaining-time{flex:1;text-align:left}.video-js .vjs-play-progress,.video-js .vjs-slider-bar,.video-js .vjs-volume-level{background:#cacaca;border-radius:1em}.video-js .vjs-play-progress{color:#b7090b;background:#b7090b;font-size:1.3em}.video-js .vjs-play-progress:before{transition:width .1s ease-out,height .1s ease-out;content:"";top:-.2em;border:0;background:radial-gradient(#b7090b 33%,#830607);width:1em;height:1em;border-radius:50%;box-shadow:0 0 2px #000}.video-js .vjs-play-progress:hover:before{width:1.1em;height:1.1em;border:2px solid transparent}.video-js .vjs-progress-control{position:absolute;left:0;right:0;width:100%;padding:0 4em 0 .4em;top:-2.3em;border-radius:1em;transition:top .15s linear,opacity .15s linear,transform .15s linear,-webkit-transform .15s linear;z-index:1;opacity:0}.video-js .vjs-progress-control:hover .vjs-progress-holder{font-size:inherit}.video-js .vjs-progress-control .vjs-mouse-display{background:#cacaca}.video-js .vjs-progress-control .vjs-mouse-display:before{top:100%;content:" ";height:0;width:0;position:absolute;border:.8em solid transparent;border-top-color:#262626;right:25%;margin-left:-.8em}.video-js .vjs-time-tooltip{background:#cacaca!important;color:#b7090b}.video-js .vjs-time-tooltip:before{top:100%;content:" ";height:0;width:0;position:absolute;border:.8em solid transparent;border-top-color:#262626;right:25%;margin-left:-.8em}.video-js .vjs-load-progress,.video-js .vjs-play-progress{height:.7em!important}.video-js .vjs-progress-holder{height:.9em}.video-js .vjs-load-progress{background:#3a3a3a;background:rgba(46,46,46,.5);border-radius:1em;height:.9em!important}.video-js .vjs-load-progress div{background:#3a3a3a;background:rgba(46,46,46,.75);border-radius:1em;height:.9em!important}.vjs-loading-spinner{border:none;opacity:0;visibility:hidden;-webkit-animation:vjs-spinner-fade-out 2s linear 1;animation:vjs-spinner-fade-out 2s linear 1;-webkit-animation-delay:2s;animation-delay:2s}.vjs-loading-spinner:after,.vjs-loading-spinner:before{border:none}.vjs-loading-spinner:after{background-image:url(https://assets.nflxext.com/en_us/pages/wiplayer/site-spinner.png);background-repeat:no-repeat;background-position-x:50%;background-position-y:50%;background-size:100%}.vjs-seeking .vjs-loading-spinner:after,.vjs-waiting .vjs-loading-spinner:after{-webkit-animation:vjs-spinner-spin 1.1s linear infinite,vjs-spinner-fade 1.1s linear 1!important;animation:vjs-spinner-spin 1.1s linear infinite,vjs-spinner-fade 1.1s linear 1!important;-webkit-animation-delay:2s;animation-delay:2s}.vjs-seeking .vjs-loading-spinner,.vjs-waiting .vjs-loading-spinner{opacity:1;visibility:visible;-webkit-animation:vjs-spinner-fade-in 2s linear 1;animation:vjs-spinner-fade-in 2s linear 1;-webkit-animation-delay:2s;animation-delay:2s}@-webkit-keyframes vjs-spinner-fade-in{0%{opacity:0;visibility:visible}to{opacity:1;visibility:visible}}@keyframes vjs-spinner-fade-in{0%{opacity:0;visibility:visible}to{opacity:1;visibility:visible}}@-webkit-keyframes vjs-spinner-fade-out{0%{opacity:1;visibility:visible}to{opacity:0;visibility:visible}}@keyframes vjs-spinner-fade-out{0%{opacity:1;visibility:visible}to{opacity:0;visibility:visible}}.live-footer .bottom-bar{background-color:#00889c;padding:15px 0}.live-footer .live-about{background-color:#dcdcdc}.live-footer .live-about .media-body{font-size:14px;color:#333;line-height:1.5}.live-footer .live-about a{color:#333;text-decoration:none;background-color:transparent;font-size:16px;font-weight:400;letter-spacing:1px}.live-footer .live-about a:hover{color:#00889c;text-decoration:underline;background-color:transparent;cursor:pointer;font-weight:600}.live-footer .live-copyright{background-color:#ededed}.live-footer .live-copyright .copyright,.live-footer .live-copyright .copyright a{font-size:14px;color:#333}',""])}}]);