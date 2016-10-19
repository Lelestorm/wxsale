<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<title>商品详情</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black" name="apple-mobile-web-app-status-bar-style">
<meta name="format-detection" content="telephone=no">
<meta name="keywords" content="">
<meta name="description" content="">
<link href="/favicon.ico" rel="shortcut icon" />
<style type="text/css">
body,textarea,input,select,option {font-size:12px;color:#333;font-family:Arial,"微软雅黑",Tahoma,sans-serif;}h1,h2,h3,h4,h5,h6,input, textarea, select{font-size:100%;font-weight:normal;}body,h1,h2,h3,h4,h5,h6,blockquote,ol,ul,dl,dd,p,textarea,input,select,option,form {margin:0;}ol,ul,li,textarea,input,select,option,th,td {padding:0;}table {border-collapse:collapse;}ol,ul {list-style-type:none;}.clears:before,.clears:after {content:'';display:table;}.clears:after {clear:both;}.clears {*zoom:1;}.clear {clear:both;overflow:hidden;}a {text-decoration:none;color:#333;}a,textarea,input{outline:none}textarea {overflow:auto;resize:none;}.img img {display:block;}a img {border:none;}.z_index{position:fixed;_position:absolute;z-index:999;display:none;}label,label input{vertical-align:middle}.pr {position:relative;}.pa {position:absolute;}.fl {float:left;}.fr {float:right;}a:hover{text-decoration:none}body{word-break:break-all;word-wrap:break-word;cursor:default;}input[type="checkbox"],input[type="text"],input[type="submit"],input[type="number"],input[type="tel"],textarea,button{-webkit-border-radius:0;border-radius:0;-webkit-appearance: none;}html, body, form,fieldset, p, div,h1, h2, h3, h4, h5, h6 {-webkit-text-size-adjust:none;}.d_box{display:-moz-box;display:-webkit-box;display:box;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-flex:1;-moz-box-flex:1;box-flex:1;width:100%;}html{font-size:62.5%;}body{font-size:1.2rem;font-size:12px;width:100%;overflow-x:hidden;}i,var{font-style:normal;}.d_center{display: -webkit-box;display: -moz-box;display: box;-webkit-box-pack: center;-webkit-box-align: center;-moz-box-pack: center;-moz-box-align: center;box-pack: center;box-align: center;}.d_boxflex{-webkit-box-flex: 1;-moz-box-flex: 1;-ms-box-flex: 1;box-flex: 1;display:block;}.nowrap{white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}b,i{font-weight:normal;font-style:normal;}.vm *{vertical-align: middle;}
html,body{width:100%;height:100%;}
body{min-width: 320px;max-width: 640px;margin: 0 auto;padding-bottom: 80px;background: #F2F2F2; font-size:12px;color:#333; font-family:"Microsoft YaHei", sans-serif;}
.cf:after {content: ".";visibility: hidden;clear: both;height: 0;width: 100%;display: block;}
.color_r{color: #ff498c;}
/*top*/
.goods-top .top {background-color: #fff; padding-right: 5px; height: 44px;}
.goods-top .top img {width: 145px;float: left;margin: 15px 0 0 15px;}
.goods-top .top .order {float: right; line-height: 44px; padding: 0 8px;}
/*封面*/
.goods-cont{margin-bottom: 50px;}
.goods-cont .goods-box{background-color: #fff;}
.goods-box img{width: 100%;}
/*价格*/
.safeguard {background-color: #fff;clear: both; border-bottom: 1px solid #eee;}
.safeguard .detailDiv {padding: 0 15px;}
.detailDiv b {display: block; font-weight: bold;font-size: 16px;padding: 15px 0 5px 0;}
.detailDiv span {color: #ff498c;font-size: 18px;padding-bottom: 10px;display: block;}
.detailDiv span em {margin-left: 5px; color: #999;text-decoration: line-through;font-size: 12px;}
.detailDiv div {line-height: 26px; border-top: 1px dashed #eee;color: #888;font-size: 12px;padding: 10px 0; overflow: hidden;}
.detailDiv div font{color:#333;}
/*热门*/
.like-box {margin-top: 10px; border-top: 1px solid #e4e4e4;border-bottom: 1px solid #e4e4e4;background-color: #fff;position: relative;}
.like-header {font-size: 15px;padding: 3%;color: #000;font-weight: bold;}
.like-container {width: 100%;position: relative;overflow-y: hidden;overflow-x: scroll;padding-bottom: 1rem;}
.like-wrapper {position: relative;height: 100%;margin-right: 1rem;}
.like-wrapper .like-item {float: left;width: 98px;text-align: center;margin-left: 2rem;box-sizing: border-box;background-color: #fff;}
.like-wrapper .like-item .like-goods-pic { font-size: 0; max-width: 100%; }
.like-wrapper .like-item .like-goods-pic img{width: 78px; height: 78px;}
.like-wrapper .like-goods-name,.like-wrapper .like-goods-price{margin: 0;padding: 0;line-height: 1.4rem;color: #535353;width: 100%;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;}
.like-wrapper .like-goods-name { margin-top: .8rem; }
.like-wrapper .like-goods-price { color: #FF498C;}
/*详情*/
.detail-header {display: block;margin: 0 12px;border-top: 1px solid #ddd; margin-top: 25px;}
.detail-header em {display: block;width: 120px; text-align: center;height: 16px; font-size: 14px;line-height: 16px; background-color: #F5F5F5;margin: -9px auto 0;font-style: normal;color: #ff498c;}
.detail-column { border-bottom: 1px solid #eee; background-color: #fff;margin: 12px 0 0 0;border-top: 1px solid #eee;clear: both;overflow: hidden;}
.detail-show{box-sizing: border-box;display: block;padding: 10px 10px 5px 10px;}
.detail-show img{width: 100%;display: table-cell;}
/*底部*/
.footNav{ position: fixed;bottom:0;left:0; width: 100%; height: 46px;background-color: #fff; z-index:99;display:-webkit-box;}
.footNav .a5{ line-height: 46px;font-size:16px;color:#fff;background-color: #ff498c; width:30%; text-align: center;display:block;-webkit-box-flex:1}
.footNav .navd2{min-width: 40%;border-top: 1px solid #dcdcdc; display:-moz-box;display:-webkit-box;display:box;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-flex: 1;}
.footNav div a{border-right:1px solid #d6d6d6;padding-top:3px; height:46px; overflow:hidden;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-flex:1;-moz-box-flex:1;box-flex:1;width:100%;font-size:13px; display:block;text-align: center; }
.footNav div a:last-of-type{border: none;}
.footNav a i{background:url(http://sale.120.net/static/images/footnavIcon.png) no-repeat;background-size:20px 40px;-webkit-background-size:20px 40px;-moz-background-size:20px 40px;width: 20px; height: 20px; display: block;margin: 0 auto;}
.footNav div .a1 i{ background-position: 0 3px;}
.footNav div .a2 i{position:relative;background-position: 0 -21px;}
.footNav div .a2 em{ position: absolute;top:0;right:-9px;background-color: #f45f48;border-radius: 7px;height:12px; line-height: 12px;padding:0 3px;color:#fff;font-size:10px;}
</style>
</head>
<body>

<div class="goods-top">
    <div class="top">
        <img width="145" src="http://sale.120.net/static/css/shop/image/goodslogo.png?v1">
        <a class="order" href="javascript:;">订单中心</a>
    </div>
</div>

<div class="content">
    <div class="goods-cont">
        <div class="goods-box">
            <img src="http://static.120askimages.com/120net/ecommerce/goods/20160826/1472182801.jpg" />
        </div>
        <div class="safeguard">
            <div class="detailDiv">
                <b>拯救一片森林，从和“竹夫人”好上开始</b>
                <span>￥19.90&nbsp;&nbsp;<em>29.90</em></span>
                <span style="color:#888;font-size:12px;">规格:180g/盒<var>包邮（偏远地区除外）</var></span>
                <div>累计销量:<font>10596</font>　　累计评价:<font>1633</font></div>
            </div>
        </div>

        <section class="like-box">
            <div class="like-header">热门商品</div>
            <div class="like-container">
                <div class="like-wrapper cf" style="width:550px;">
                    <div class="like-item">
                        <div class="like-goods-pic"><img src="http://appimg.pba.cn/2014/10/21/f67306de7df30b8409e0bd4fd2bacad3.jpg" alt="PBA 红石榴精华水"></div>
                        <div class="like-goods-name">PBA 红石榴精华水</div>
                        <div class="like-goods-price">￥39.90</div>
                    </div>
                    <div class="like-item">
                        <div class="like-goods-pic"><img src="http://appimg.pba.cn/2014/10/10/02be6be6861c5e0dee647a1e8998e4e3.jpg" alt="PBA 眼部精华霜"></div>
                        <div class="like-goods-name">PBA 眼部精华霜</div>
                        <div class="like-goods-price">￥29.90</div>
                    </div>
                    <div class="like-item">
                        <div class="like-goods-pic"><img src="http://appimg.pba.cn/2015/04/08/4f27f1835b55df03f23b7d1ec14368db.jpg" alt="PBA 泡沫洁面乳"></div>
                        <div class="like-goods-name">PBA 泡沫洁面乳</div>
                        <div class="like-goods-price">￥16.90</div>
                    </div>
                    <div class="like-item">
                        <div class="like-goods-pic"><img src="http://appimg.pba.cn/2015/07/24/222a34b34adde3f76814edabb6013fb6.jpg" alt="PBA 舒缓保湿乳液"></div>
                        <div class="like-goods-name">PBA 舒缓保湿乳液</div>
                        <div class="like-goods-price">￥39.90</div>
                    </div>
                </div>
            </div>
        </section>
        
        <div class="detail-header"><em>图文详情</em></div>
        <div class="detail-column">
            <div class="detail-show"> 
                <p><img alt="01.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736710957435.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736710957435.jpg" title="14736710957435.jpg" style="display: block;"><img src="http://static.120askimages.com/120net/ecommerce/goods/20161008/14759353902046.jpg" data-original="http://static.120askimages.com/120net/ecommerce/goods/20161008/14759353902046.jpg" title="14759353902046.jpg" alt="06.jpg" style="display: block;"><img src="http://static.120askimages.com/120net/ecommerce/goods/20160928/14750506916447.jpg" data-original="http://static.120askimages.com/120net/ecommerce/goods/20160928/14750506916447.jpg" title="14750506916447.jpg" alt="02竹夫人.jpg" style="display: block;"><img alt="03.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711238467.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711238467.jpg" title="14736711238467.jpg" style="display: block;"><img alt="04.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711397931.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711397931.jpg" title="14736711397931.jpg" style="display: block;"><img alt="05.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711608345.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711608345.jpg" title="14736711608345.jpg" style="display: block;"><img alt="001.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160914/14738216677561.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160914/14738216677561.jpg" title="14738216677561.jpg" style="display: block;"><img alt="002.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160914/14738216831450.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160914/14738216831450.jpg" title="14738216831450.jpg" style="display: block;"><img alt="003.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160914/14738217003145.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160914/14738217003145.jpg" title="14738217003145.jpg" style="display: block;"><img alt="004.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160914/14738217167666.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160914/14738217167666.jpg" title="14738217167666.jpg" style="display: block;"><img alt="005.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160914/14738217342317.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160914/14738217342317.jpg" title="14738217342317.jpg" style="display: block;"><img alt="06.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711729640.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711729640.jpg" title="14736711729640.jpg" style="display: block;"><img alt="07.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711857013.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736711857013.jpg" title="14736711857013.jpg" style="display: block;"><img alt="08.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712017583.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712017583.jpg" title="14736712017583.jpg" style="display: block;"><img alt="09.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712173843.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712173843.jpg" title="14736712173843.jpg" style="display: block;"><img alt="10.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712321206.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712321206.jpg" title="14736712321206.jpg" style="display: block;"><img alt="11.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712453600.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712453600.jpg" title="14736712453600.jpg" style="display: block;"><img alt="12.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712676253.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712676253.jpg" title="14736712676253.jpg" style="display: block;"><img alt="13.jpg" src="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712855381.jpg" data-original="http://static.120askimages.com/120net/bsxw/goods/20160912/14736712855381.jpg" title="14736712855381.jpg" style="display: block;"></p>
            </div>   
        </div>
    </div>

    <div class="footNav">
        <div class="navd2">
            <a class="a1 xnkf" href="javascript:void(0)"><i></i>客服</a>
            <a class="a2" href="javascript:void(0)"><i><em>1</em></i>购物车</a>
        </div>
        
        <a class="a5 buy-Btn" href="javascript:;" style="background-color: #ccc;">加入购物车</a>
        <a class="a5" href="javascript:void(0)">立即购买</a>
    </div>
</div>

</body>
</html>