<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:87:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/product/index.html";i:1522833461;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/public/base.html";i:1522831855;}*/ ?>
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
    
    
<link rel="stylesheet" href="__STATIC__/qiantai/css/css.css">
<style type="text/css">
    .sb_2{
        color:blue;
    }
    .sb_2 span{
        color:blue;
    }
</style>

</head>
<body>


<div class="container">
    <img style="width: 100%;" src="__STATIC__/qiantai/img/header_jifen.jpg"/>
    <div class="content">
        <h5>积分商品</h5>
        <dl>
            <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <dd><a href="<?php echo url('product/details',array('id'=>$v['id'])); ?>">
                <i><img src="<?php echo $v['img']; ?>"/></i>
                <h6><?php echo $v['product_name']; ?></h6>
                <span>积分:&nbsp;<?php echo $v['sales_jifen']; ?></span>
            </a></dd>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </dl>
    </div>

</div>

<div id="footer"></div>

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

<script src="__STATIC__/qiantai/js/swiper.min.js"></script>

<script src="__STATIC__/qiantai/js/jquery.js"></script>
<script type="text/javascript" src="__STATIC__/qiantai/js/draggabilly.pkgd.min.js"></script>



<script>


    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        nextButton: '.swiper-button-next',
        prevButton: '.swiper-button-prev',
        slidesPerView: 1,
        paginationClickable: true,
        loop: true,
        autoplay: 3500,
        autoplayDisableOnInteraction: false

    });
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