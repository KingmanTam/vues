/*!
 * mysite v1.0.1
 * Copyright 2020-2023 Inc.
 * Licensed under the MIT license
 */
if("undefined"==typeof jQuery)throw new Error("Bootstrap's JavaScript requires jQuery");+function(t){"use strict";var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1==e[0]&&9==e[1]&&e[2]<1||e[0]>3)throw new Error("Bootstrap's JavaScript requires jQuery version 1.9.1 or higher, but lower than version 4")}(jQuery),+function(t){"use strict";function e(e){var i=e.attr("data-target");i||(i=e.attr("href"),i=i&&/#[A-Za-z]/.test(i)&&i.replace(/.*(?=#[^\s]*$)/,""));var n="#"!==i?t(document).find(i):null;return n&&n.length?n:e.parent()}function i(i){i&&3===i.which||(t(o).remove(),t(s).each(function(){var n=t(this),o=e(n),s={relatedTarget:this};o.hasClass("open")&&(i&&"click"==i.type&&/input|textarea/i.test(i.target.tagName)&&t.contains(o[0],i.target)||(o.trigger(i=t.Event("hide.bs.dropdown",s)),i.isDefaultPrevented()||(n.attr("aria-expanded","false"),o.removeClass("open").trigger(t.Event("hidden.bs.dropdown",s)))))}))}function n(e){return this.each(function(){var i=t(this),n=i.data("bs.dropdown");n||i.data("bs.dropdown",n=new a(this)),"string"==typeof e&&n[e].call(i)})}var o=".dropdown-backdrop",s='[data-toggle="dropdown"]',a=function(e){t(e).on("click.bs.dropdown",this.toggle)};a.VERSION="3.4.1",a.prototype.toggle=function(n){var o=t(this);if(!o.is(".disabled, :disabled")){var s=e(o),a=s.hasClass("open");if(i(),!a){"ontouchstart"in document.documentElement&&!s.closest(".navbar-nav").length&&t(document.createElement("div")).addClass("dropdown-backdrop").insertAfter(t(this)).on("click",i);var r={relatedTarget:this};if(s.trigger(n=t.Event("show.bs.dropdown",r)),n.isDefaultPrevented())return;o.trigger("focus").attr("aria-expanded","true"),s.toggleClass("open").trigger(t.Event("shown.bs.dropdown",r))}return!1}},a.prototype.keydown=function(i){if(/(38|40|27|32)/.test(i.which)&&!/input|textarea/i.test(i.target.tagName)){var n=t(this);if(i.preventDefault(),i.stopPropagation(),!n.is(".disabled, :disabled")){var o=e(n),a=o.hasClass("open");if(!a&&27!=i.which||a&&27==i.which)return 27==i.which&&o.find(s).trigger("focus"),n.trigger("click");var r=" li:not(.disabled):visible a",l=o.find(".dropdown-menu"+r);if(l.length){var h=l.index(i.target);38==i.which&&h>0&&h--,40==i.which&&h<l.length-1&&h++,~h||(h=0),l.eq(h).trigger("focus")}}}};var r=t.fn.dropdown;t.fn.dropdown=n,t.fn.dropdown.Constructor=a,t.fn.dropdown.noConflict=function(){return t.fn.dropdown=r,this},t(document).on("click.bs.dropdown.data-api",i).on("click.bs.dropdown.data-api",".dropdown form",function(t){t.stopPropagation()}).on("click.bs.dropdown.data-api",s,a.prototype.toggle).on("keydown.bs.dropdown.data-api",s,a.prototype.keydown).on("keydown.bs.dropdown.data-api",".dropdown-menu",a.prototype.keydown)}(jQuery),+function(t){"use strict";function e(e){return this.each(function(){var n=t(this),o=n.data("bs.tab");o||n.data("bs.tab",o=new i(this)),"string"==typeof e&&o[e]()})}var i=function(e){this.element=t(e)};i.VERSION="3.4.1",i.TRANSITION_DURATION=150,i.prototype.show=function(){var e=this.element,i=e.closest("ul:not(.dropdown-menu)"),n=e.data("target");if(n||(n=e.attr("href"),n=n&&n.replace(/.*(?=#[^\s]*$)/,"")),!e.parent("li").hasClass("active")){var o=i.find(".active:last a"),s=t.Event("hide.bs.tab",{relatedTarget:e[0]}),a=t.Event("show.bs.tab",{relatedTarget:o[0]});if(o.trigger(s),e.trigger(a),!a.isDefaultPrevented()&&!s.isDefaultPrevented()){var r=t(document).find(n);this.activate(e.closest("li"),i),this.activate(r,r.parent(),function(){o.trigger({type:"hidden.bs.tab",relatedTarget:e[0]}),e.trigger({type:"shown.bs.tab",relatedTarget:o[0]})})}}},i.prototype.activate=function(e,n,o){function s(){a.removeClass("active").find("> .dropdown-menu > .active").removeClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!1),e.addClass("active").find('[data-toggle="tab"]').attr("aria-expanded",!0),r?(e[0].offsetWidth,e.addClass("in")):e.removeClass("fade"),e.parent(".dropdown-menu").length&&e.closest("li.dropdown").addClass("active").end().find('[data-toggle="tab"]').attr("aria-expanded",!0),o&&o()}var a=n.find("> .active"),r=o&&t.support.transition&&(a.length&&a.hasClass("fade")||!!n.find("> .fade").length);a.length&&r?a.one("bsTransitionEnd",s).emulateTransitionEnd(i.TRANSITION_DURATION):s(),a.removeClass("in")};var n=t.fn.tab;t.fn.tab=e,t.fn.tab.Constructor=i,t.fn.tab.noConflict=function(){return t.fn.tab=n,this};var o=function(i){i.preventDefault(),e.call(t(this),"show")};t(document).on("click.bs.tab.data-api",'[data-toggle="tab"]',o).on("click.bs.tab.data-api",'[data-toggle="pill"]',o)}(jQuery),+function(t){"use strict";function e(e){var i,n=e.attr("data-target")||(i=e.attr("href"))&&i.replace(/.*(?=#[^\s]+$)/,"");return t(document).find(n)}function i(e){return this.each(function(){var i=t(this),o=i.data("bs.collapse"),s=t.extend({},n.DEFAULTS,i.data(),"object"==typeof e&&e);!o&&s.toggle&&/show|hide/.test(e)&&(s.toggle=!1),o||i.data("bs.collapse",o=new n(this,s)),"string"==typeof e&&o[e]()})}var n=function(e,i){this.$element=t(e),this.options=t.extend({},n.DEFAULTS,i),this.$trigger=t('[data-toggle="collapse"][href="#'+e.id+'"],[data-toggle="collapse"][data-target="#'+e.id+'"]'),this.transitioning=null,this.options.parent?this.$parent=this.getParent():this.addAriaAndCollapsedClass(this.$element,this.$trigger),this.options.toggle&&this.toggle()};n.VERSION="3.4.1",n.TRANSITION_DURATION=350,n.DEFAULTS={toggle:!0},n.prototype.dimension=function(){var t=this.$element.hasClass("width");return t?"width":"height"},n.prototype.show=function(){if(!this.transitioning&&!this.$element.hasClass("in")){var e,o=this.$parent&&this.$parent.children(".panel").children(".in, .collapsing");if(!(o&&o.length&&(e=o.data("bs.collapse"),e&&e.transitioning))){var s=t.Event("show.bs.collapse");if(this.$element.trigger(s),!s.isDefaultPrevented()){o&&o.length&&(i.call(o,"hide"),e||o.data("bs.collapse",null));var a=this.dimension();this.$element.removeClass("collapse").addClass("collapsing")[a](0).attr("aria-expanded",!0),this.$trigger.removeClass("collapsed").attr("aria-expanded",!0),this.transitioning=1;var r=function(){this.$element.removeClass("collapsing").addClass("collapse in")[a](""),this.transitioning=0,this.$element.trigger("shown.bs.collapse")};if(!t.support.transition)return r.call(this);var l=t.camelCase(["scroll",a].join("-"));this.$element.one("bsTransitionEnd",t.proxy(r,this)).emulateTransitionEnd(n.TRANSITION_DURATION)[a](this.$element[0][l])}}}},n.prototype.hide=function(){if(!this.transitioning&&this.$element.hasClass("in")){var e=t.Event("hide.bs.collapse");if(this.$element.trigger(e),!e.isDefaultPrevented()){var i=this.dimension();this.$element[i](this.$element[i]())[0].offsetHeight,this.$element.addClass("collapsing").removeClass("collapse in").attr("aria-expanded",!1),this.$trigger.addClass("collapsed").attr("aria-expanded",!1),this.transitioning=1;var o=function(){this.transitioning=0,this.$element.removeClass("collapsing").addClass("collapse").trigger("hidden.bs.collapse")};return t.support.transition?void this.$element[i](0).one("bsTransitionEnd",t.proxy(o,this)).emulateTransitionEnd(n.TRANSITION_DURATION):o.call(this)}}},n.prototype.toggle=function(){this[this.$element.hasClass("in")?"hide":"show"]()},n.prototype.getParent=function(){return t(document).find(this.options.parent).find('[data-toggle="collapse"][data-parent="'+this.options.parent+'"]').each(t.proxy(function(i,n){var o=t(n);this.addAriaAndCollapsedClass(e(o),o)},this)).end()},n.prototype.addAriaAndCollapsedClass=function(t,e){var i=t.hasClass("in");t.attr("aria-expanded",i),e.toggleClass("collapsed",!i).attr("aria-expanded",i)};var o=t.fn.collapse;t.fn.collapse=i,t.fn.collapse.Constructor=n,t.fn.collapse.noConflict=function(){return t.fn.collapse=o,this},t(document).on("click.bs.collapse.data-api",'[data-toggle="collapse"]',function(n){var o=t(this);o.attr("data-target")||n.preventDefault();var s=e(o),a=s.data("bs.collapse"),r=a?"toggle":o.data();i.call(s,r)})}(jQuery),+function(t){"use strict";function e(i,n){this.$body=t(document.body),this.$scrollElement=t(t(i).is(document.body)?window:i),this.options=t.extend({},e.DEFAULTS,n),this.selector=(this.options.target||"")+" .nav li > a",this.offsets=[],this.targets=[],this.activeTarget=null,this.scrollHeight=0,this.$scrollElement.on("scroll.bs.scrollspy",t.proxy(this.process,this)),this.refresh(),this.process()}function i(i){return this.each(function(){var n=t(this),o=n.data("bs.scrollspy"),s="object"==typeof i&&i;o||n.data("bs.scrollspy",o=new e(this,s)),"string"==typeof i&&o[i]()})}e.VERSION="3.4.1",e.DEFAULTS={offset:10},e.prototype.getScrollHeight=function(){return this.$scrollElement[0].scrollHeight||Math.max(this.$body[0].scrollHeight,document.documentElement.scrollHeight)},e.prototype.refresh=function(){var e=this,i="offset",n=0;this.offsets=[],this.targets=[],this.scrollHeight=this.getScrollHeight(),t.isWindow(this.$scrollElement[0])||(i="position",n=this.$scrollElement.scrollTop()),this.$body.find(this.selector).map(function(){var e=t(this),o=e.data("target")||e.attr("href"),s=/^#./.test(o)&&t(o);return s&&s.length&&s.is(":visible")&&[[s[i]().top+n,o]]||null}).sort(function(t,e){return t[0]-e[0]}).each(function(){e.offsets.push(this[0]),e.targets.push(this[1])})},e.prototype.process=function(){var t,e=this.$scrollElement.scrollTop()+this.options.offset,i=this.getScrollHeight(),n=this.options.offset+i-this.$scrollElement.height(),o=this.offsets,s=this.targets,a=this.activeTarget;if(this.scrollHeight!=i&&this.refresh(),e>=n)return a!=(t=s[s.length-1])&&this.activate(t);if(a&&e<o[0])return this.activeTarget=null,this.clear();for(t=o.length;t--;)a!=s[t]&&e>=o[t]&&(void 0===o[t+1]||e<o[t+1])&&this.activate(s[t])},e.prototype.activate=function(e){this.activeTarget=e,this.clear();var i=this.selector+'[data-target="'+e+'"],'+this.selector+'[href="'+e+'"]',n=t(i).parents("li").addClass("active");n.parent(".dropdown-menu").length&&(n=n.closest("li.dropdown").addClass("active")),n.trigger("activate.bs.scrollspy")},e.prototype.clear=function(){t(this.selector).parentsUntil(this.options.target,".active").removeClass("active")};var n=t.fn.scrollspy;t.fn.scrollspy=i,t.fn.scrollspy.Constructor=e,t.fn.scrollspy.noConflict=function(){return t.fn.scrollspy=n,this},t(window).on("load.bs.scrollspy.data-api",function(){t('[data-spy="scroll"]').each(function(){var e=t(this);i.call(e,e.data())})})}(jQuery),+function(t){"use strict";function e(){var t=document.createElement("bootstrap"),e={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(var i in e)if(void 0!==t.style[i])return{end:e[i]};return!1}t.fn.emulateTransitionEnd=function(e){var i=!1,n=this;t(this).one("bsTransitionEnd",function(){i=!0});var o=function(){i||t(n).trigger(t.support.transition.end)};return setTimeout(o,e),this},t(function(){t.support.transition=e(),t.support.transition&&(t.event.special.bsTransitionEnd={bindType:t.support.transition.end,delegateType:t.support.transition.end,handle:function(e){return t(e.target).is(this)?e.handleObj.handler.apply(this,arguments):void 0}})})}(jQuery);
!function(a,b,c,d){var e=a(b);a.fn.lazyload=function(f){function g(){var b=0;i.each(function(){var c=a(this);if(!j.skip_invisible||c.is(":visible"))if(a.abovethetop(this,j)||a.leftofbegin(this,j));else if(a.belowthefold(this,j)||a.rightoffold(this,j)){if(++b>j.failure_limit)return!1}else c.trigger("appear"),b=0})}var h,i=this,j={threshold:0,failure_limit:0,event:"scroll",effect:"show",container:b,data_attribute:"original",skip_invisible:!1,appear:null,load:null,placeholder:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"};return f&&(d!==f.failurelimit&&(f.failure_limit=f.failurelimit,delete f.failurelimit),d!==f.effectspeed&&(f.effect_speed=f.effectspeed,delete f.effectspeed),a.extend(j,f)),h=j.container===d||j.container===b?e:a(j.container),0===j.event.indexOf("scroll")&&h.bind(j.event,function(){return g()}),this.each(function(){var b=this,c=a(b);b.loaded=!1,(c.attr("src")===d||c.attr("src")===!1)&&c.is("img")&&c.attr("src",j.placeholder),c.one("appear",function(){if(!this.loaded){if(j.appear){var d=i.length;j.appear.call(b,d,j)}a("<img />").bind("load",function(){var d=c.attr("data-"+j.data_attribute);c.hide(),c.is("img")?c.attr("src",d):c.css("background-image","url('"+d+"')"),c[j.effect](j.effect_speed),b.loaded=!0;var e=a.grep(i,function(a){return!a.loaded});if(i=a(e),j.load){var f=i.length;j.load.call(b,f,j)}}).attr("src",c.attr("data-"+j.data_attribute))}}),0!==j.event.indexOf("scroll")&&c.bind(j.event,function(){b.loaded||c.trigger("appear")})}),e.bind("resize",function(){g()}),/(?:iphone|ipod|ipad).*os 5/gi.test(navigator.appVersion)&&e.bind("pageshow",function(b){b.originalEvent&&b.originalEvent.persisted&&i.each(function(){a(this).trigger("appear")})}),a(c).ready(function(){g()}),this},a.belowthefold=function(c,f){var g;return g=f.container===d||f.container===b?(b.innerHeight?b.innerHeight:e.height())+e.scrollTop():a(f.container).offset().top+a(f.container).height(),g<=a(c).offset().top-f.threshold},a.rightoffold=function(c,f){var g;return g=f.container===d||f.container===b?e.width()+e.scrollLeft():a(f.container).offset().left+a(f.container).width(),g<=a(c).offset().left-f.threshold},a.abovethetop=function(c,f){var g;return g=f.container===d||f.container===b?e.scrollTop():a(f.container).offset().top,g>=a(c).offset().top+f.threshold+a(c).height()},a.leftofbegin=function(c,f){var g;return g=f.container===d||f.container===b?e.scrollLeft():a(f.container).offset().left,g>=a(c).offset().left+f.threshold+a(c).width()},a.inviewport=function(b,c){return!(a.rightoffold(b,c)||a.leftofbegin(b,c)||a.belowthefold(b,c)||a.abovethetop(b,c))},a.extend(a.expr[":"],{"below-the-fold":function(b){return a.belowthefold(b,{threshold:0})},"above-the-top":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-screen":function(b){return a.rightoffold(b,{threshold:0})},"left-of-screen":function(b){return!a.rightoffold(b,{threshold:0})},"in-viewport":function(b){return a.inviewport(b,{threshold:0})},"above-the-fold":function(b){return!a.belowthefold(b,{threshold:0})},"right-of-fold":function(b){return a.rightoffold(b,{threshold:0})},"left-of-fold":function(b){return!a.rightoffold(b,{threshold:0})}})}(jQuery,window,document);

var marscms = {
    'browser':{
        'url': document.URL,
        'domain': document.domain,
        'title': document.title,
        'language': (navigator.browserLanguage || navigator.language).toLowerCase(),
        'canvas' : function(){
            return !!document.createElement('canvas').getContext;
        }(),
        'useragent' : function(){
            var ua = navigator.userAgent;
            return {
                'mobile': !!ua.match(/AppleWebKit.*Mobile.*/),
                'ios': !!ua.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
                'android': ua.indexOf('Android') > -1 || ua.indexOf('Linux') > -1,
                'iPhone': ua.indexOf('iPhone') > -1 || ua.indexOf('Mac') > -1,
                'iPad': ua.indexOf('iPad') > -1,
                'trident': ua.indexOf('Trident') > -1,
                'presto': ua.indexOf('Presto') > -1,
                'webKit': ua.indexOf('AppleWebKit') > -1,
                'gecko': ua.indexOf('Gecko') > -1 && ua.indexOf('KHTML') == -1,
                'weixin': ua.indexOf('MicroMessenger') > -1
            };
        }()
    },
    'cms': {
        'floatdiv': function() {
            $("<link>").attr({
                rel: "stylesheet",
                type: "text/css",
            }).appendTo("head");
        },
        'tab': function() {
            $("#myTab li a").click(function(e) {
                $(this).tab('show');
            });
        },
        'collapse': function() {
            var w = document.documentElement ? document.documentElement.clientWidth : document.body.clientWidth;
            if (w > 640) {
                $(".list_type").addClass("in");
            }

        },
        'scrolltop': function() {
            var a = $(window);
            $scrollTopLink = $("a.backtop");
            a.scroll(function() {
                500 < $(this).scrollTop() ? $scrollTopLink.css("display", "block") : $scrollTopLink.css("display", "none")
            });
            $scrollTopLink.on("click", function() {
                $("html, body").animate({
                    scrollTop: 0
                }, 400);
                return !1
            })
        },
        'modal': function(url){
            $('.zanpian-modal').modal('hide');
            $(".modal-dialog .close").trigger('click');
            $('.zanpian-modal').remove();
            $('.modal-backdrop').remove();
            $.ajax({
                type: 'get',
                cache: false,
                url: url,
                timeout: 3000,
                success: function($html) {
                    $('body').append($html);
                    $('.zanpian-modal').modal('show');
                    $("body").css("padding","0px");
                    $("body").css("padding-top","60px");
                }
            })
        },
        'all': function(url){
            $('body').on("click", "#login,#user_login,#navbar_user_login", function(event){
                $('.zanpian-modal').modal('hide');
                if(!zanpian.user.islogin()){
                    event.preventDefault();
                    zanpian.user.loginform();
                    return false;
                }
            });
            $('.navbar-search').click(function(){
                $('.user-search').toggle();
                $('#nav-signed,#example-navbar-collapse').hide();
            })
            $('.navbar-navmore').click(function(){
                $('.user-search').toggle();
                $('#nav-signed,.user-search').hide();
            })
            $('body').on("click", ".more-click", function() {
                var self = $(this);
                var box = $(this).attr('data-box');
                var allNum = $(this).attr('data-count');
                var buNum = allNum - $(this).attr('data-limit');
                var sta = $(this).attr('data-sta');
                var hideItem = $('.' + box).find('li[rel="h"]');
                if (sta == undefined || sta == 0) {
                    hideItem.show(200);
                    $(this).find('span').text('收起部分' + buNum);
                    self.attr('data-sta', 1);
                } else {
                    hideItem.hide(200);
                    $(this).find('span').text('查看全部' + allNum);
                    self.attr('data-sta', 0);
                }

            });
            var prevpage = $("#pre").attr("href");
            var nextpage = $("#next").attr("href");
            $("body").keydown(function(event) {
                if (event.keyCode == 37 && prevpage != undefined) location = prevpage;
                if (event.keyCode == 39 && nextpage != undefined) location = nextpage;
            });
            $('body').on("click", "#player-shrink", function() {
                $(".player_right").toggle();
                $(".player_left").toggleClass("max");
                $(".player-shrink").toggleClass("icon-left");
            });
            $("#widget-WeChat").click(function(){
                $(this).hide();
            });
            if ($('.player_playlist').length > 0){
                marscms.player.playerlist() ;
            }
            $(window).resize(function() {
                marscms.player.playerlist() ;
            });
            $(".player-tool em").click(function() {
                $html = $(this).html();
                try {
                    if ($html == '关灯') {
                        $(this).html('开灯')
                    } else {
                        $(this).html('关灯')
                    }
                } catch (e) {}
                $(".player-open").toggle(300);
                $(".player_left").toggleClass("player-top")
                $(".player_right").toggleClass("player-top")
            });
        }
    },
    'detail': {
        'collapse': function() {
            $('body').on("click", "[data-toggle=collapse]", function() {
                $this = $(this);
                $($this.attr('data-target')).toggle();
                $($this.attr('data-default')).toggle();
                if ($this.attr('data-html')) {
                    $data_html = $this.html();
                    $this.html($this.attr('data-html'));
                    $this.attr('data-html', $data_html);
                }
                if ($this.attr('data-val')) {
                    $data_val = $this.val();
                    $this.val($this.attr('data-val'));
                    $this.attr('data-val', $data_val);
                }
            });
        },
        'playlist': function() {
            $(".player-more .dropdown-menu li").click(function() {
                $("#playTab").find('li').removeClass('active');
                var activeTab = $(this).html();
                var prevTab = $('.player-more').prev('li').html();
                $('.player-more').prev('li').addClass('active').html(activeTab);
                $(this).html(prevTab);
            });
            if ($('.player-more').length > 0) {
                $(".dropdown-menu li.active").each(function() {
                    var activeTab = $(this).html();
                    var prevTab = $('.player-more').prev('li').html();
                    $('.player-more').prev('li').addClass('active').html(activeTab);
                    $(this).html(prevTab).removeClass('active');
                });
            }
            $(".mplayer .dropdown-menu li").click(function() {
                var sclass = $(this).find('a').attr('class');
                var stext = $(this).text();
                $("#myTabDrop2 .name").text(stext);
                $("#myTabDrop2").removeClass($("#myTabDrop2").attr('class'));
                $("#myTabDrop2").addClass(sclass);
            });
            var WidthScreen = true;
            for (var i = 0; i < $(".playlist ul").length; i++) {
                series($(".playlist ul").eq(i), 20, 1);
            }
            function series(div, n1, n2) {
                var len = div.find("li").length;
                var n = WidthScreen ? n1 : n2;
                if (len > 24) {
                    for (var i = n2 + 18; i < len - ((n1 / 2) - 2) / 2; i++) {
                        div.find("li").eq(i).addClass("hided");
                    }
                    var t_m = "<li class='more open'><a target='_self' href='javascript:void(0)'>更多剧集</a></li>";
                    div.find("li").eq(n2 + 17).after(t_m);
                    var more = div.find(".more");
                    var _open = false;
                    div.css("height", "auto");
                    more.click(function() {
                        if (_open) {
                            div.find(".hided").hide();
                            $(this).html("<a target='_self' href='javascript:void(0)'>更多剧集</a>");
                            $(this).removeClass("closed");
                            $(this).addClass("open");
                            $(this).insertAfter(div.find("li").eq(n2 + 17));
                            _open = false;
                        } else {
                            div.find(".hided").show();
                            $(this).html("<a target='_self' href='javascript:void(0)'>收起剧集</a>");
                            $(this).removeClass("open");
                            $(this).addClass("closed");
                            $(this).insertAfter(div.find("li:last"));
                            _open = true;
                        }
                    })
                }
            }
        },
    },
    'player': {
        'playerlist': function() {
            var height = $(".player_left").height();
            if ($('.player_prompt').length > 0){
                var height = height-50;
            }
            $(".player_playlist").height(height - 55);
            var mheight = $(".mobile_player_left").height();
            if ($(".player_playlist").height() > mheight){
                $(".player_playlist").height(mheight - 55);
            }
        },
    },
    'language':{
        's2t':function(){
            if(feifei.browser.language=='zh-hk' || feifei.browser.language=='zh-tw'){
                $.getScript("//cdn.feifeicms.co/jquery/s2t/0.1.0/s2t.min.js", function(data, status, jqxhr) {
                    $(document.body).s2t();
                });
            }
        },
        't2s':function(){
            if(feifei.browser.language=='zh-cn'){
                $.getScript("//cdn.feifeicms.co/jquery/s2t/0.1.0/s2t.min.js", function(data, status, jqxhr) {
                    $(document.body).t2s();
                });
            }
        }
    },
    'image': {
        'lazyload': function(){
            $(".loading").lazyload({
                effect : "fadeIn",
                failurelimit: 15
            });
        },
    },
};
$(document).ready(function(){
    marscms.cms.all();
    marscms.cms.tab();
    marscms.cms.collapse();
    marscms.cms.scrolltop();
    marscms.image.lazyload();
    marscms.detail.collapse();
    marscms.detail.playlist();
});

$(function (){

    $("#searchbar1").click(function() {
        let val = $('#wd1').val();

        if (val === undefined || val===''){
            val = '*';
        }
        window.location.href='/search/'+val+'/1.html';
    });
    $("#searchbar2").click(function() {
        let val = $('#wd2').val();

        if (val === undefined || val===''){
            val = '*';
        }
        window.location.href='/search/'+val+'/1.html';
    });
})

