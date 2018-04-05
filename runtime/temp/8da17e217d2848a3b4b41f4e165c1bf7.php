<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:98:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/order/product_order_list.html";i:1522918821;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/public/base.html";i:1522831855;}*/ ?>
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
    
    

<style type="text/css">
    .record ul li h2 i{font-style: normal;color: #ff2d17}
    .order-bt{line-height: 25px;height: 25px;padding-top: 5px}
    .order-bt a{float: left;margin-right: 20px;display: block;line-height: 25px;width: 60px; text-align: center;background-color: #1E9FFF;color: #fff; border-radius: 5px;}
    li a{width: 100px;display: block;float: right;position: relative;text-align: center;background: #008FE0;color: #fff;border-radius: 5px;padding: 5px 0;clear: both}
</style>


</head>
<body>



<div class="record">
    <h1 class="h1">购买商品记录</h1>
    <ul>
        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?>
        <li>
            <p>商品：<u><?php echo $d['product_name']; ?></u>
                <?php if($d['status']==5): ?><span style="color:#FFBF05;">驳回</span>
                <?php elseif($d['status'] == 10): ?><span style="color:#FF1400;">待审核</span>
                <?php elseif($d['status'] == 20): ?><span style="color:#FF1400;">已完结</span>
                <?php endif; ?></p>
             <p>数量：<?php echo $d['buy_num']; ?></p>   
            <p>积分:<?php echo $d['total_jifen']; ?></p>
            <span><?php echo date("Y-m-d H:m:s",$d['add_time']); ?></span>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>

    </ul>
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