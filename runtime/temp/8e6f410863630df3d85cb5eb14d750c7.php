<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:87:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/goods/details.html";i:1522828454;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/public/base.html";i:1522831855;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title><?php echo $titleName; ?></title>
    <link rel="stylesheet" href="__STATIC__/qiantai/css/style.css"/>
    <link rel="stylesheet" href="__STATIC__/qiantai/css/font.css"/>
    <script type="text/javascript" src="__STATIC__/qiantai/js/gVerify.js"></script>
    <script type="text/javascript" src="__STATIC__/qiantai/js/jquery-1.11.3.min.js"></script>
    <script src="__STATIC__/qiantai/js/layer/mobile/layer_mobile.js"></script>
    <script src="__STATIC__/qiantai/js/layer/mobile/layer.js"></script>
    <script src="__STATIC__/qiantai/js/layer/mobile/common.js"></script>
    
    
<link rel="stylesheet" type="text/css" href="__STATIC__/qiantai/css/css.css">

</head>
<body>


<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="<?php echo $data['img']; ?>"/></div>
    </div>
</div>
<div class="xxy_content">
    <h6><?php echo $data['goods_name']; ?></h6>
    <span>积分：<?php echo $data['sales_price']; ?></span>
    <dl>
        <dd>销量：50件</dd>
    </dl>
    <div class="ljjf">
        <a href="javascript:;">立即购买</a>
    </div>
</div>
<div class="xxy_xx">
    <h6>产品详情</h6>
    <span><?php echo $data['details']; ?></span>
</div>
<div class="zf">
    <div class="zf_z">
        <i><img src="<?php echo $data['img']; ?>"/></i>
        <div class="zf_right">
            <span>￥:<?php echo $data['sales_price']; ?></span>
        </div>
        <form id="orderForm" action='<?php echo url("Order/goods_order"); ?>' method="post">
            <div class="slgm">
                <span>购买数量</span>
                <input class="addBtn add" type="button" value="+"/>
                <input class="join-money" name="count" type="number" value="1">
                <input class="addBtn min" type="button" value="-"/>
            </div>
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        </form>
        <a href='javascript:;' style="position:relative;" onclick="submitOrderFuc()">提交</a>
    </div>
</div>

    <div style="height: 50px;"></div>
    <div class="bottom_nav" style="z-index: 999999;">
        <dl>
            <!--<dd><button class="iconfont icon-xiangzuo1" onclick="javascript:window.history.back(-1);"><span>返回上一级</span></button></dd>-->
            <dd><a href="<?php echo url('index/package/index'); ?>" class="iconfont icon-jiaoyi sb_1"><span>升级区</span></a></dd>
            <dd><a href="<?php echo url('index/product/index'); ?>" class="iconfont icon-qiandaizi sb_2"><span>积分商城</span></a></dd>
            <dd><a href="<?php echo url('index/goods/index'); ?>" class="iconfont icon-dianpufill sb_3"><span>小商城</span></a></dd>
            <dd><a href="<?php echo url('index/index/index'); ?>" class="iconfont icon-wodefill sb_4"><span>个人中心</span></a></dd>
        </dl>
    </div>

<script>
    var t = $(".join-money");
    var m = $(".allMoney").text();
    var mm = $(".allMoney");
    var tmax = $("#stock").val();

    $(function () {
        $(".add").click(function () {
            var v = parseInt(t.val());
            if (v + 1 > parseInt(tmax)) {
                t.val(tmax);
                return false;
            } else {
                t.val(parseInt(t.val()) + 1); //点击加号输入框数值加1
            }
        });
        $(".min").click(function () {
            t.val(parseInt(t.val()) - 1); //点击减号输入框数值减1
            if (t.val() <= 0) {
                t.val(parseInt(t.val()) + 1); //最小值为1
            }
        });
    });
    $(document).ready(function(){
        $(".ljjf").click(function(){
            $(".zf").animate({top:'0px'})
        });
        $(".gb").click(function(){
            $(".zf").animate({top:'100vh'})
        });
    });

    function submitOrderFuc() {
        $("#orderForm").submit();
    }

</script>

</body>
<script>
    // $(function(){
    //     $("dl dd").click(function(){
    //        var index = $(this).index();
           
    //        $('dl dd>a').eq(index).addClass('sb_4').parent().siblings().removeClass('sb_4');
    //     });
    // });
</script>
</html>