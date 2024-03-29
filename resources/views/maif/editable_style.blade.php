@section('css')
<style>
    @font-face{font-family:'Glyphicons Halflings';src:url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot');src:url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.eot?#iefix') format('embedded-opentype'),url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.woff') format('woff'),url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.ttf') format('truetype'),url('http://netdna.bootstrapcdn.com/bootstrap/3.0.0/fonts/glyphicons-halflings-regular.svg#glyphicons-halflingsregular') format('svg');}.glyphicon{position:relative;top:1px;display:inline-block;font-family:'Glyphicons Halflings';font-style:normal;font-weight:normal;line-height:1;-webkit-font-smoothing:antialiased;}
    .glyphicon-ok:before{content:"\e013";}
    .glyphicon-remove:before{content:"\e014";}
</>
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