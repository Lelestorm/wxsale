<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>养生小店</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/favicon.ico" rel="shortcut icon" />
    <link rel="stylesheet" href="/static/css/swiper.min.css">
</head>
<style type="text/css">
    body,textarea,input,select,option {font-size:12px;color:#333;font-family:Arial,"微软雅黑",Tahoma,sans-serif;}h1,h2,h3,h4,h5,h6,input, textarea, select{font-size:100%;font-weight:normal;}body,h1,h2,h3,h4,h5,h6,blockquote,ol,ul,dl,dd,p,textarea,input,select,option,form {margin:0;}ol,ul,li,textarea,input,select,option,th,td {padding:0;}table {border-collapse:collapse;}ol,ul {list-style-type:none;}.clears:before,.clears:after {content:'';display:table;}.clears:after {clear:both;}.clears {*zoom:1;}.clear {clear:both;overflow:hidden;}a {text-decoration:none;color:#333;}a,textarea,input{outline:none}textarea {overflow:auto;resize:none;}.img img {display:block;}a img {border:none;}.z_index{position:fixed;_position:absolute;z-index:999;display:none;}label,label input{vertical-align:middle}.pr {position:relative;}.pa {position:absolute;}.fl {float:left;}.fr {float:right;}a:hover{text-decoration:none}body{word-break:break-all;word-wrap:break-word;cursor:default;}input[type="checkbox"],input[type="text"],input[type="submit"],input[type="number"],input[type="tel"],textarea,button{-webkit-border-radius:0;border-radius:0;-webkit-appearance: none;}html, body, form,fieldset, p, div,h1, h2, h3, h4, h5, h6 {-webkit-text-size-adjust:none;}.d_box{display:-moz-box;display:-webkit-box;display:box;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-flex:1;-moz-box-flex:1;box-flex:1;width:100%;}html{font-size:62.5%;}body{font-size:1.2rem;font-size:12px;width:100%;overflow-x:hidden;}i,var{font-style:normal;}.d_center{display: -webkit-box;display: -moz-box;display: box;-webkit-box-pack: center;-webkit-box-align: center;-moz-box-pack: center;-moz-box-align: center;box-pack: center;box-align: center;}.d_boxflex{-webkit-box-flex: 1;-moz-box-flex: 1;-ms-box-flex: 1;box-flex: 1;display:block;}.nowrap{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}b,i{font-weight:normal;font-style:normal;}.vm *{vertical-align: middle;}
    html,body{width:100%;height:100%;}
    body{min-width: 320px;max-width: 640px;margin: 0 auto;padding-bottom: 80px;background: #F2F2F2; font-size:100%;color:#333; font-family:"Microsoft YaHei", sans-serif;}
    .color_r{color: #ff498c;}
    /*search*/
    .topSearch{padding:8px 10px;background-color:#f5f5f5; clear:both;}
    .topSearch input[type="search"]{background:url(/static/images/searchIcon.png) no-repeat;background-size:16px 16px;-webkit-background-size:16px 16px;-moz-background-size:16px 16px;width:100%;padding:6px 6px 8px 29px; background-position:7px 8px;height:34px;background-color:#fff;border:1px solid #ddd;font-size:13px;border-radius:3px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-appearance: none;}
    /*swiper loop*/
    .swiper-container{max-width: 640px;}
    .swiper-container img{width: 100%; max-height: 240px;}
    
    .foodsClassify {display: -webkit-box;height: 58px;background-color: #fff;}
    .foodsClassify a {display: block;-webkit-box-flex: 1;text-align: center; font-size: 11px; color: #666;}
    .foodsClassify a i {display: block;width: 26px;height: 20px;background: url(/static/images/icon_techan.png) no-repeat;background-size: 100px 100px;-webkit-background-size: 100px 100px;margin: 12px auto 0;}
    .foodsClassify a i.i1{background-position:0 2px;}
    .foodsClassify a i.i2{background-position:-33px 0;}
    .foodsClassify a i.i3{background-position:-70px 1px;}
    .foodsClassify a i.i4{background-position:0 -27px;}
    .foodsClassify a span{display:block;line-height:11px;padding-top:5px;}
    
    .foodsList{margin:0 10px;}
    .foodsList div {display: block;padding: 0;border: none;margin: 0;background-color: #fff;}
    .foodsList div img {display: block; width: 100%;}
    .foodsList div b {display: block;font-size: 16px; line-height: 16px;padding: 17px 0 0 15px;}
    .foodsList div span {display: block;font-size: 12px;line-height: 16px;}
    .foodsList div p {position: absolute;padding: 0;display: block;line-height: 24px;width: 120px;right: 10px; bottom: 16px;z-index: 2;}
    .foodsList .create_group {margin-bottom: 10px; padding: 0 0 8px 0; position: relative; }
    .conver_box {position: relative;width: 100%;display: block;height: auto;overflow: hidden;}
    .conver_box .conver_inner {padding-bottom: 50%;width: 100%;}
    .conver_box .conver_inner img {position: absolute;top: 0px;left: 0px;opacity:1;}
    .foodsList div .liri {padding-right: 90px; display: block;}
    .foodsList div .liri b {text-overflow: ellipsis;white-space: nowrap;overflow: hidden;padding: 19px 0 0 5px;color: #000;}
    .foodsList div .liri span {text-overflow: ellipsis;white-space: nowrap;overflow: hidden; color: #969696;padding: 10px 12px 12px 5px;}
    .foodsList div p strong {display: block;text-align: right;font-size: 16px;color: #FD4688;line-height: 27px;}
    .foodsList div p em {display: block;float: right;font-style: normal;border: 1px solid #FD4688;border-left: none;border-radius: 0 4px 4px 0;padding: 0 10px;background-color: #FD4688;;color: #fff;}
    body{min-width: 320px;max-width: 640px;margin: 0 auto;padding-bottom: 80px;background: #F2F2F2; font-size:100%;color:#333; font-family:"Microsoft YaHei", sans-serif;}
    
    /*content*/
    .content{ padding-bottom: 65px; margin: 0 0;}
    .content .banner, .banner img{width: 100%;}
    .banner{background: #fff; color: #8a6d3b; height: 53px; font-size: 15px; margin-bottom: 2px;}
    .banner p{font-weight: bold;height: 53px; line-height: 53px; padding-left: 11px;}
    .banner p small{font-size: 12px; margin-left: 8px;}

    .goods-list{padding: 0px; background: #fff;overflow: hidden;}
    .goods-list li{padding: 4% 3%;border-bottom: 1px solid #E9E9E9;}
    .cf{zoom:1;}
    .goods-list li .goods-box{width: 30%;display: inline-block;vertical-align: middle;position: relative;}
    .goods-list li .goods-box a{display: inline-block;}
    .goods-list li a img{width: 100%;border: none;}
    .product-icon{ position: absolute;left: 0;top: 0;width: 40%;}
    .goods-list .text{display: inline-block;margin-left: 3%;width: 65%;vertical-align: middle;position: relative;}
    .goods-list .text p{display: inline-block;width: 76%;}
    .goods-name{font-size: 14px;margin-bottom: 2%;color: #000;}
    .goods-tag{font-size: 13px;margin-top: 5px;margin-bottom: 2%;color: #969696;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;}
    .goods-price{font-size: 13px;color: #585858;}
    .goods-price span{color: #FD4688;}
    .goods-list .text .joincart {position: absolute;right: 3%;width: 13%;bottom: -10%;}

    .bottom-menu{position: fixed;bottom: 0px;left: 0px;right: 0px;border-top: 1px solid #e2e2e2;border-bottom: 1px solid #e2e2e2;background-color: #fff;max-width: 750px;min-width: 320px; margin: 0 auto;}
    .bottom-menu ul li{float: left;width: 25%;}
    .bottom-menu ul li a{display: block;color: #535353;text-decoration: none;text-align: center;font-size: 12px;}
    .bottom-menu ul li a img{height: 30px; width: 30px!important; margin: 5px auto -4px;}
</style>
<body>

<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="/static/images/face-001.jpeg"></div>
        <div class="swiper-slide"><img src="/static/images/face-002.jpg"></div>
        <div class="swiper-slide"><img src="/static/images/face-003.jpeg"></div>
    </div>
    <div class="swiper-pagination"></div>
</div>

<div class="foodsClassify">
    <a href="classify?category=nut"><i class="i1"></i><span>西域干果</span></a>
    <a href="classify?category=cereals"><i class="i2"></i><span>五谷代餐</span></a>
    <a href="classify?category=specialty"><i class="i3"></i><span>村味特产</span></a>
    <a href="classify?category=snacks"><i class="i4"></i><span>健康零食</span></a>
</div>
    
<div class="topSearch">
    <form action="/goods/shop">
        <input type="search" name="keyword" id="seript" placeholder="请输入您要搜索的商品名称" />
    </form>
</div>
    
<div class="content-body">
    <!--div style="background-color:#fff; padding-top: 10px;">
        <div class="foodsList" id="group-goods-list">
            <a href="javascript:;">
                <div class="create_group" gid="218">
                    <div class="conver_box">
                        <div class="conver_inner">
                            <img src="" />
                        </div>
                    </div>
                    <div class="liri">
                        <b>这是一个值得买的好商品</b>
                        <span>特别适合婴幼儿使用。无任何添加，安全放心。</span>
                    </div>
                    <p><strong>￥79.00</strong><em>去抢购</em></p>
                </div>
            </a>
        </div>
    </div-->

    <div class="content">
        <!--div class="banner">
            <p>人气商品<small class="small">HOT PRODUCT</small></p>
        </div-->

        <div class="goods-list-box">
            <ul class="goods-list">
                <li class="cf">
                    <div class="goods-box">
                        <a href="javascript:;">
                            <img src="http://appimg.pba.cn/2016/06/17/5c0ad2b022e9b34be3209867b9e1d0c5.jpg!240.240">
                        </a>
                        <img class="product-icon" src="/static/images/new-icon.png">
                    </div>
                    <div class="text">
                        <p class="goods-name"> 气垫BB</p>
                        <p class="goods-tag">水润清透 打造空气感裸妆</p>
                        <p class="goods-price">专享价：<span>￥79.90</span></p>
                        <a class="joincart join" href="/goods/show">
                            <img src="/static/images/shopcart-light.png">
                        </a>
                    </div>
                </li>      
                <li class="cf">
                    <div class="goods-box">
                        <a href="javascript:;">
                            <img src="http://appimg.pba.cn/2015/01/04/56e20195fba618fc4d21e7c6335e56a2.jpg!240.240">
                        </a>
                        <img class="product-icon" src="/static/images/spread-icon.png">
                    </div>
                    <div class="text">
                        <p class="goods-name">水嫩舒缓眼膜贴</p>
                        <p class="goods-tag">淡化细纹、眼袋、黑眼圈</p>
                        <p class="goods-price">专享价：<span>￥3.90</span></p>
                        <a class="joincart" href="javascript:;">
                            <img src="/static/images/shopcart-unlight.png">
                        </a>
                    </div>
                </li>
                <li class="cf">
                    <div class="goods-box">
                        <a href="javascript:;">
                            <img src="http://appimg.pba.cn/2015/04/30/dfed89b4123fcf380f7720d9dd6659c8.jpg!240.240">
                        </a>
                    </div>
                    <div class="text">
                        <p class="goods-name"> 矿物散粉 12g</p>
                        <p class="goods-tag">超控油 不脱妆的秘密</p>
                        <p class="goods-price">专享价：<span>￥49.90</span></p>
                        <a class="joincart" href="javascript:;">
                            <img src="/static/images/shopcart-light.png">
                        </a> 
                    </div>
                </li>
                <li class="cf">
                    <div class="goods-box">
                        <a href="javascript:;">
                            <img src="http://appimg.pba.cn/2016/03/04/292464d2849bb58fb9aca40f6ecbf663.jpg!240.240">
                        </a>
                        <img class="product-icon" src="/static/images/hot-icon.png">
                    </div>
                    <div class="text">
                        <p class="goods-name"> 玻尿酸补水面膜贴礼盒</p>
                        <p class="goods-tag">补水圣品 满足肌肤渴望</p>
                        <p class="goods-price">专享价：<span>￥84.00</span></p>
                        <a class="joincart" href="javascript:void(0)">
                            <img src="/static/images/shopcart-light.png">
                        </a>
                    </div>
                </li>                  
            </ul>
        </div>
    </div>
</div>

<div class="bottom-menu">
    <ul>
        <li>
            <a href="/goods/shop">
                <img src="/static/images/icon_home_active.png" alt="首页">
                <p class="color_r">首页</p>
            </a>
        </li>
        <li>
            <a href="javascript:;">
                <img src="/static/images/icon_category.png" alt="分类">
                <p>分类</p>
            </a>
        </li>
        <li>
            <a href="JavaScript:;">
                <img src="/static/images/icon_cart.png" alt="购物车">
                <p>购物车</p>
            </a>
        </li>
        <li>
            <a href="JavaScript:;">
                <img src="/static/images/icon_my.png" alt="我的">
                <p>我的</p> 
            </a>
        </li>
    </ul>
</div>
</body>
<script src="/static/js/swiper.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: 3000,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        grabCursor: true,
        parallax:true,
        autoplayDisableOnInteraction: false
    });
    </script>
</html>
