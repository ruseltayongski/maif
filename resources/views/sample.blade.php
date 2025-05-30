@section('css')
<style>
    @font-face{font-family:'Glyphicons Halflings';src:url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot');src:url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'),url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.woff') format('woff'),url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.ttf') format('truetype'),url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');}.glyphicon{position:relative;top:1px;display:inline-block;font-family:'Glyphicons Halflings';font-style:normal;font-weight:normal;line-height:1;-webkit-font-smoothing:antialiased;}
    .glyphicon-ok:before{content:"\e013";}
    .glyphicon-remove:before{content:"\e014";}
</style>
<style>
    /* .tooltip {
    position: absolute;
    z-index: 1030;
    display: block;
    font-size: 12px;
    line-height: 1.4;
    opacity: 0;
    filter: alpha(opacity=0);
    visibility: visible;
}
.tooltip.in {
    opacity: 0.9;
    filter: alpha(opacity=90);
}
.tooltip.top {
    padding: 5px 0;
    margin-top: -3px;
}
.tooltip.right {
    padding: 0 5px;
    margin-left: 3px;
}
.tooltip.bottom {
    padding: 5px 0;
    margin-top: 3px;
}
.tooltip.left {
    padding: 0 5px;
    margin-left: -3px;
}
.tooltip-inner {
    max-width: 200px;
    padding: 3px 8px;
    color: #fff;
    text-align: center;
    text-decoration: none;
    background-color: #000;
    border-radius: 4px;
}
.tooltip-arrow {
    position: absolute;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
}
.tooltip.top .tooltip-arrow {
    bottom: 0;
    left: 50%;
    margin-left: -5px;
    border-top-color: #000;
    border-width: 5px 5px 0;
}
.tooltip.top-left .tooltip-arrow {
    bottom: 0;
    left: 5px;
    border-top-color: #000;
    border-width: 5px 5px 0;
}
.tooltip.top-right .tooltip-arrow {
    right: 5px;
    bottom: 0;
    border-top-color: #000;
    border-width: 5px 5px 0;
}
.tooltip.right .tooltip-arrow {
    top: 50%;
    left: 0;
    margin-top: -5px;
    border-right-color: #000;
    border-width: 5px 5px 5px 0;
}
.tooltip.left .tooltip-arrow {
    top: 50%;
    right: 0;
    margin-top: -5px;
    border-left-color: #000;
    border-width: 5px 0 5px 5px;
}
.tooltip.bottom .tooltip-arrow {
    top: 0;
    left: 50%;
    margin-left: -5px;
    border-bottom-color: #000;
    border-width: 0 5px 5px;
}
.tooltip.bottom-left .tooltip-arrow {
    top: 0;
    left: 5px;
    border-bottom-color: #000;
    border-width: 0 5px 5px;
}
.tooltip.bottom-right .tooltip-arrow {
    top: 0;
    right: 5px;
    border-bottom-color: #000;
    border-width: 0 5px 5px;
} */

.popover {
    position: absolute;
    top: 0;
    left: 0;
    z-index: 9999;
    display: none;
    max-width: 276px;
    padding: 1px;
    text-align: left;
    white-space: normal;
    background-color: #fff;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 6px;
    -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    background-clip: padding-box;
    display: block !important;
}
.popover.top {
    margin-top: -10px;
}
.popover.right {
    margin-left: 10px;
}
.popover.bottom {
    margin-top: 10px;
}
.popover.left {
    margin-left: -10px;
}
.popover-title {
    padding: 8px 14px;
    margin: 0;
    font-size: 14px;
    font-weight: normal;
    line-height: 18px;
    background-color: #f7f7f7;
    border-bottom: 1px solid #ebebeb;
    border-radius: 5px 5px 0 0;
}
.popover-content {
    padding: 9px 14px;
}
.popover .arrow,
.popover .arrow:after {
    position: absolute;
    display: block;
    width: 0;
    height: 0;
    border-color: transparent;
    border-style: solid;
}
.popover .arrow {
    border-width: 11px;
}
.popover .arrow:after {
    border-width: 10px;
    content: "";
}
.popover.top .arrow {
    bottom: -11px;
    left: 50%;
    margin-left: -11px;
    border-top-color: #999;
    border-top-color: rgba(0, 0, 0, 0.25);
    border-bottom-width: 0;
}
.popover.top .arrow:after {
    bottom: 1px;
    margin-left: -10px;
    border-top-color: #fff;
    border-bottom-width: 0;
    content: " ";
}
.popover.right .arrow {
    top: 50%;
    left: -11px;
    margin-top: -11px;
    border-right-color: #999;
    border-right-color: rgba(0, 0, 0, 0.25);
    border-left-width: 0;
}
.popover.right .arrow:after {
    bottom: -10px;
    left: 1px;
    border-right-color: #fff;
    border-left-width: 0;
    content: " ";
}
.popover.bottom .arrow {
    top: -11px;
    left: 50%;
    margin-left: -11px;
    border-bottom-color: #999;
    border-bottom-color: rgba(0, 0, 0, 0.25);
    border-top-width: 0;
}
.popover.bottom .arrow:after {
    top: 1px;
    margin-left: -10px;
    border-bottom-color: #fff;
    border-top-width: 0;
    content: " ";
}
.popover.left .arrow {
    top: 50%;
    right: -11px;
    margin-top: -11px;
    border-left-color: #999;
    border-left-color: rgba(0, 0, 0, 0.25);
    border-right-width: 0;
}
.popover.left .arrow:after {
    right: 1px;
    bottom: -10px;
    border-left-color: #fff;
    border-right-width: 0;
    content: " ";
}
.fade {
    opacity: 0;
    -webkit-transition: opacity 0.15s linear;
    transition: opacity 0.15s linear;
}
.fade.in {
    opacity: 1;
}
.editable-cancel {
    background-color: orange;
    color: white;
}
</style>
<style>
    
</style>
    <!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
@endsection
@extends('layouts.app')

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
    <div>
        <span>Username:</span>
        <a href="#" id="username" data-type="number" data-placement="right" data-title="Enter username"></a>
    </div>
</div>

@endsection

@section('js')
    <script src="http://49.157.74.3/dtr/public/assets/js/jquery.min.js"></script>
    <!-- <script src="http://49.157.74.3/pis/public/assets_ace/js/bootstrap.min.js"></script> -->
    <script>
        /*!
 * Bootstrap v3.3.6 (http://getbootstrap.com)
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under the MIT license
 */
        (function (a) {
            "use strict";
            function b(b) {
                return this.each(function () {
                    var d = a(this),
                        e = d.data("bs.tooltip"),
                        f = "object" == typeof b && b;
                    (e || !/destroy|hide/.test(b)) && (e || d.data("bs.tooltip", (e = new c(this, f))), "string" == typeof b && e[b]());
                });
            }
            var c = function (a, b) {
                (this.type = null), (this.options = null), (this.enabled = null), (this.timeout = null), (this.hoverState = null), (this.$element = null), (this.inState = null), this.init("tooltip", a, b);
            };
            (c.VERSION = "3.3.6"),
                (c.TRANSITION_DURATION = 150),
                (c.DEFAULTS = {
                    animation: !0,
                    placement: "top",
                    selector: !1,
                    template: '<div class="tooltip" role="tooltip"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>',
                    trigger: "hover focus",
                    title: "",
                    delay: 0,
                    html: !1,
                    container: !1,
                    viewport: { selector: "body", padding: 0 },
                }),
                (c.prototype.init = function (b, c, d) {
                    if (
                        ((this.enabled = !0),
                        (this.type = b),
                        (this.$element = a(c)),
                        (this.options = this.getOptions(d)),
                        (this.$viewport = this.options.viewport && a(a.isFunction(this.options.viewport) ? this.options.viewport.call(this, this.$element) : this.options.viewport.selector || this.options.viewport)),
                        (this.inState = { click: !1, hover: !1, focus: !1 }),
                        this.$element[0] instanceof document.constructor && !this.options.selector)
                    )
                        throw new Error("`selector` option must be specified when initializing " + this.type + " on the window.document object!");
                    for (var e = this.options.trigger.split(" "), f = e.length; f--; ) {
                        var g = e[f];
                        if ("click" == g) this.$element.on("click." + this.type, this.options.selector, a.proxy(this.toggle, this));
                        else if ("manual" != g) {
                            var h = "hover" == g ? "mouseenter" : "focusin",
                                i = "hover" == g ? "mouseleave" : "focusout";
                            this.$element.on(h + "." + this.type, this.options.selector, a.proxy(this.enter, this)), this.$element.on(i + "." + this.type, this.options.selector, a.proxy(this.leave, this));
                        }
                    }
                    this.options.selector ? (this._options = a.extend({}, this.options, { trigger: "manual", selector: "" })) : this.fixTitle();
                }),
                (c.prototype.getDefaults = function () {
                    return c.DEFAULTS;
                }),
                (c.prototype.getOptions = function (b) {
                    return (b = a.extend({}, this.getDefaults(), this.$element.data(), b)), b.delay && "number" == typeof b.delay && (b.delay = { show: b.delay, hide: b.delay }), b;
                }),
                (c.prototype.getDelegateOptions = function () {
                    var b = {},
                        c = this.getDefaults();
                    return (
                        this._options &&
                            a.each(this._options, function (a, d) {
                                c[a] != d && (b[a] = d);
                            }),
                        b
                    );
                }),
                (c.prototype.enter = function (b) {
                    var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
                    return (
                        c || ((c = new this.constructor(b.currentTarget, this.getDelegateOptions())), a(b.currentTarget).data("bs." + this.type, c)),
                        b instanceof a.Event && (c.inState["focusin" == b.type ? "focus" : "hover"] = !0),
                        c.tip().hasClass("in") || "in" == c.hoverState
                            ? void (c.hoverState = "in")
                            : (clearTimeout(c.timeout),
                            (c.hoverState = "in"),
                            c.options.delay && c.options.delay.show
                                ? void (c.timeout = setTimeout(function () {
                                        "in" == c.hoverState && c.show();
                                    }, c.options.delay.show))
                                : c.show())
                    );
                }),
                (c.prototype.isInStateTrue = function () {
                    for (var a in this.inState) if (this.inState[a]) return !0;
                    return !1;
                }),
                (c.prototype.leave = function (b) {
                    var c = b instanceof this.constructor ? b : a(b.currentTarget).data("bs." + this.type);
                    return (
                        c || ((c = new this.constructor(b.currentTarget, this.getDelegateOptions())), a(b.currentTarget).data("bs." + this.type, c)),
                        b instanceof a.Event && (c.inState["focusout" == b.type ? "focus" : "hover"] = !1),
                        c.isInStateTrue()
                            ? void 0
                            : (clearTimeout(c.timeout),
                            (c.hoverState = "out"),
                            c.options.delay && c.options.delay.hide
                                ? void (c.timeout = setTimeout(function () {
                                        "out" == c.hoverState && c.hide();
                                    }, c.options.delay.hide))
                                : c.hide())
                    );
                }),
                (c.prototype.show = function () {
                    var b = a.Event("show.bs." + this.type);
                    if (this.hasContent() && this.enabled) {
                        this.$element.trigger(b);
                        var d = a.contains(this.$element[0].ownerDocument.documentElement, this.$element[0]);
                        if (b.isDefaultPrevented() || !d) return;
                        var e = this,
                            f = this.tip(),
                            g = this.getUID(this.type);
                        this.setContent(), f.attr("id", g), this.$element.attr("aria-describedby", g), this.options.animation && f.addClass("fade");
                        var h = "function" == typeof this.options.placement ? this.options.placement.call(this, f[0], this.$element[0]) : this.options.placement,
                            i = /\s?auto?\s?/i,
                            j = i.test(h);
                        j && (h = h.replace(i, "") || "top"),
                            f
                                .detach()
                                .css({ top: 0, left: 0, display: "block" })
                                .addClass(h)
                                .data("bs." + this.type, this),
                            this.options.container ? f.appendTo(this.options.container) : f.insertAfter(this.$element),
                            this.$element.trigger("inserted.bs." + this.type);
                        var k = this.getPosition(),
                            l = f[0].offsetWidth,
                            m = f[0].offsetHeight;
                        if (j) {
                            var n = h,
                                o = this.getPosition(this.$viewport);
                            (h = "bottom" == h && k.bottom + m > o.bottom ? "top" : "top" == h && k.top - m < o.top ? "bottom" : "right" == h && k.right + l > o.width ? "left" : "left" == h && k.left - l < o.left ? "right" : h),
                                f.removeClass(n).addClass(h);
                        }
                        var p = this.getCalculatedOffset(h, k, l, m);
                        this.applyPlacement(p, h);
                        var q = function () {
                            var a = e.hoverState;
                            e.$element.trigger("shown.bs." + e.type), (e.hoverState = null), "out" == a && e.leave(e);
                        };
                        a.support.transition && this.$tip.hasClass("fade") ? f.one("bsTransitionEnd", q).emulateTransitionEnd(c.TRANSITION_DURATION) : q();
                    }
                }),
                (c.prototype.applyPlacement = function (b, c) {
                    var d = this.tip(),
                        e = d[0].offsetWidth,
                        f = d[0].offsetHeight,
                        g = parseInt(d.css("margin-top"), 10),
                        h = parseInt(d.css("margin-left"), 10);
                    isNaN(g) && (g = 0),
                        isNaN(h) && (h = 0),
                        (b.top += g),
                        (b.left += h),
                        a.offset.setOffset(
                            d[0],
                            a.extend(
                                {
                                    using: function (a) {
                                        d.css({ top: Math.round(a.top), left: Math.round(a.left) });
                                    },
                                },
                                b
                            ),
                            0
                        ),
                        d.addClass("in");
                    var i = d[0].offsetWidth,
                        j = d[0].offsetHeight;
                    "top" == c && j != f && (b.top = b.top + f - j);
                    var k = this.getViewportAdjustedDelta(c, b, i, j);
                    k.left ? (b.left += k.left) : (b.top += k.top);
                    var l = /top|bottom/.test(c),
                        m = l ? 2 * k.left - e + i : 2 * k.top - f + j,
                        n = l ? "offsetWidth" : "offsetHeight";
                    d.offset(b), this.replaceArrow(m, d[0][n], l);
                }),
                (c.prototype.replaceArrow = function (a, b, c) {
                    this.arrow()
                        .css(c ? "left" : "top", 50 * (1 - a / b) + "%")
                        .css(c ? "top" : "left", "");
                }),
                (c.prototype.setContent = function () {
                    var a = this.tip(),
                        b = this.getTitle();
                    a.find(".tooltip-inner")[this.options.html ? "html" : "text"](b), a.removeClass("fade in top bottom left right");
                }),
                (c.prototype.hide = function (b) {
                    function d() {
                        "in" != e.hoverState && f.detach(), e.$element.removeAttr("aria-describedby").trigger("hidden.bs." + e.type), b && b();
                    }
                    var e = this,
                        f = a(this.$tip),
                        g = a.Event("hide.bs." + this.type);
                    return (
                        this.$element.trigger(g),
                        g.isDefaultPrevented() ? void 0 : (f.removeClass("in"), a.support.transition && f.hasClass("fade") ? f.one("bsTransitionEnd", d).emulateTransitionEnd(c.TRANSITION_DURATION) : d(), (this.hoverState = null), this)
                    );
                }),
                (c.prototype.fixTitle = function () {
                    var a = this.$element;
                    (a.attr("title") || "string" != typeof a.attr("data-original-title")) && a.attr("data-original-title", a.attr("title") || "").attr("title", "");
                }),
                (c.prototype.hasContent = function () {
                    return this.getTitle();
                }),
                (c.prototype.getPosition = function (b) {
                    b = b || this.$element;
                    var c = b[0],
                        d = "BODY" == c.tagName,
                        e = c.getBoundingClientRect();
                    null == e.width && (e = a.extend({}, e, { width: e.right - e.left, height: e.bottom - e.top }));
                    var f = d ? { top: 0, left: 0 } : b.offset(),
                        g = { scroll: d ? document.documentElement.scrollTop || document.body.scrollTop : b.scrollTop() },
                        h = d ? { width: a(window).width(), height: a(window).height() } : null;
                    return a.extend({}, e, g, h, f);
                }),
                (c.prototype.getCalculatedOffset = function (a, b, c, d) {
                    return "bottom" == a
                        ? { top: b.top + b.height, left: b.left + b.width / 2 - c / 2 }
                        : "top" == a
                        ? { top: b.top - d, left: b.left + b.width / 2 - c / 2 }
                        : "left" == a
                        ? { top: b.top + b.height / 2 - d / 2, left: b.left - c }
                        : { top: b.top + b.height / 2 - d / 2, left: b.left + b.width };
                }),
                (c.prototype.getViewportAdjustedDelta = function (a, b, c, d) {
                    var e = { top: 0, left: 0 };
                    if (!this.$viewport) return e;
                    var f = (this.options.viewport && this.options.viewport.padding) || 0,
                        g = this.getPosition(this.$viewport);
                    if (/right|left/.test(a)) {
                        var h = b.top - f - g.scroll,
                            i = b.top + f - g.scroll + d;
                        h < g.top ? (e.top = g.top - h) : i > g.top + g.height && (e.top = g.top + g.height - i);
                    } else {
                        var j = b.left - f,
                            k = b.left + f + c;
                        j < g.left ? (e.left = g.left - j) : k > g.right && (e.left = g.left + g.width - k);
                    }
                    return e;
                }),
                (c.prototype.getTitle = function () {
                    var a,
                        b = this.$element,
                        c = this.options;
                    return (a = b.attr("data-original-title") || ("function" == typeof c.title ? c.title.call(b[0]) : c.title));
                }),
                (c.prototype.getUID = function (a) {
                    do a += ~~(1e6 * Math.random());
                    while (document.getElementById(a));
                    return a;
                }),
                (c.prototype.tip = function () {
                    if (!this.$tip && ((this.$tip = a(this.options.template)), 1 != this.$tip.length)) throw new Error(this.type + " `template` option must consist of exactly 1 top-level element!");
                    return this.$tip;
                }),
                (c.prototype.arrow = function () {
                    return (this.$arrow = this.$arrow || this.tip().find(".tooltip-arrow"));
                }),
                (c.prototype.enable = function () {
                    this.enabled = !0;
                }),
                (c.prototype.disable = function () {
                    this.enabled = !1;
                }),
                (c.prototype.toggleEnabled = function () {
                    this.enabled = !this.enabled;
                }),
                (c.prototype.toggle = function (b) {
                    var c = this;
                    b && ((c = a(b.currentTarget).data("bs." + this.type)), c || ((c = new this.constructor(b.currentTarget, this.getDelegateOptions())), a(b.currentTarget).data("bs." + this.type, c))),
                        b ? ((c.inState.click = !c.inState.click), c.isInStateTrue() ? c.enter(c) : c.leave(c)) : c.tip().hasClass("in") ? c.leave(c) : c.enter(c);
                }),
                (c.prototype.destroy = function () {
                    var a = this;
                    clearTimeout(this.timeout),
                        this.hide(function () {
                            a.$element.off("." + a.type).removeData("bs." + a.type), a.$tip && a.$tip.detach(), (a.$tip = null), (a.$arrow = null), (a.$viewport = null);
                        });
                });
            var d = a.fn.tooltip;
            (a.fn.tooltip = b),
                (a.fn.tooltip.Constructor = c),
                (a.fn.tooltip.noConflict = function () {
                    return (a.fn.tooltip = d), this;
                });
        })(jQuery),
        +(function (a) {
            "use strict";
            function b(b) {
                return this.each(function () {
                    var d = a(this),
                        e = d.data("bs.popover"),
                        f = "object" == typeof b && b;
                    (e || !/destroy|hide/.test(b)) && (e || d.data("bs.popover", (e = new c(this, f))), "string" == typeof b && e[b]());
                });
            }
            var c = function (a, b) {
                this.init("popover", a, b);
            };
            if (!a.fn.tooltip) throw new Error("Popover requires tooltip.js");
            (c.VERSION = "3.3.6"),
                (c.DEFAULTS = a.extend({}, a.fn.tooltip.Constructor.DEFAULTS, {
                    placement: "right",
                    trigger: "click",
                    content: "",
                    template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>',
                })),
                (c.prototype = a.extend({}, a.fn.tooltip.Constructor.prototype)),
                (c.prototype.constructor = c),
                (c.prototype.getDefaults = function () {
                    return c.DEFAULTS;
                }),
                (c.prototype.setContent = function () {
                    var a = this.tip(),
                        b = this.getTitle(),
                        c = this.getContent();
                    a.find(".popover-title")[this.options.html ? "html" : "text"](b),
                        a.find(".popover-content").children().detach().end()[this.options.html ? ("string" == typeof c ? "html" : "append") : "text"](c),
                        a.removeClass("fade top bottom left right in"),
                        a.find(".popover-title").html() || a.find(".popover-title").hide();
                }),
                (c.prototype.hasContent = function () {
                    return this.getTitle() || this.getContent();
                }),
                (c.prototype.getContent = function () {
                    var a = this.$element,
                        b = this.options;
                    return a.attr("data-content") || ("function" == typeof b.content ? b.content.call(a[0]) : b.content);
                }),
                (c.prototype.arrow = function () {
                    return (this.$arrow = this.$arrow || this.tip().find(".arrow"));
                });
            var d = a.fn.popover;
            (a.fn.popover = b),
                (a.fn.popover.Constructor = c),
                (a.fn.popover.noConflict = function () {
                    return (a.fn.popover = d), this;
                });
        })(jQuery);
    </script>
    <script src="{{ asset('admin/vendors/x-editable/bootstrap-editable.min.js?v=1') }}"></script>
    <script>
        $(document).ready(function() {
            //toggle `popup` / `inline` mode
            $.fn.editable.defaults.mode = 'popup';     
            
            //make username editable
            $('#username').editable({
                success: function(response, newValue) {
                }
            });
        });          
    </script>
@endsection
