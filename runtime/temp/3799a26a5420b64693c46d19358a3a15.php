<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/index/index.html";i:1522934550;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/public/base.html";i:1522831855;}*/ ?>
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
    
    
</head>
<body>


<style type="text/css">
    .sb_4{
        color:blue;
    }
    .sb_4 span{
        color:blue;
    }
</style>
<div style="background: #f4f4f4;width:100vw;overflow: hidden;">
    <header>
        <i class="xf_2 sc_1"><img src="__STATIC__/qiantai/img/wo.png"/></i>
        <p class="cn">
            <span>会员编号:<?php echo $user_base['nickname']; ?></span>
            <span>会员姓名：<?php echo $user_base['real_name']; ?></span>
        </p>
    </header>

    <div class="colount">
        <div class="colount_top">
            <ul>
                <li><a ><p><?php echo $vip[$user_details['lever']]; ?>创客</p>级别</a></li>
                <li><a ><p><?php echo $m_lever[$user_details['manage_lever']]; ?></p>职务级别</a></li>

            </ul>
        </div>
        <div class="colount_nav">
            <h6 class="ic_h6">我的资产</h6>
            <ul>
                <li><a href="javascript:;" class="iconfont icon-hangqing" ><p><?php echo $user_details['jifen']; ?></p><span>积分</span></a></li>
                <li><a href="javascript:;" class="iconfont icon-shouyi" ><p><?php echo $user_details['bonus']; ?></p><span>奖金</span></a></li>
                <li><a href="javascript:;" class="iconfont icon-youhuiquan1" ><p><?php echo $user_details['cash']; ?></p><span>现金</span></a></li>
                <li><a href="tixian.html" class="iconfont icon-shouru2" ><span>提现</span></a></li>
            </ul>
            <h6 class="ic_h6">记录</h6>
            <ul>
                <li><a href="shouyi_record.html" class="iconfont icon-hangqing" ><span>使用明细</span></a></li>
                <li><a href="shopp_record.html" class="iconfont icon-wenjian" ><span>资产包购买记录</span></a></li>
                <li><a href="tixian_record.html" class="iconfont icon-xinwen" ><span>提现记录</span></a></li>
                <li><a href="<?php echo url('Order/order_list'); ?>" class="iconfont icon-xinwen" ><span>升级商城订单</span></a></li>
                <li><a href="<?php echo url('Order/product_order_list'); ?>" class="iconfont icon-xinwen" ><span>积分商城订单</span></a></li>
                <li><a href="<?php echo url('Order/goods_order_list'); ?>" class="iconfont icon-xinwen" ><span>小商城订单</span></a></li>
            </ul>
            <h6 class="ic_h6">编辑</h6>
            <ul>
                <li><a class="iconfont icon-b2" href="shdz.html"><span>修改收货地址</span></a></li>
                <li><a href="wfwb.html" class="iconfont icon-yinhangqia" ><span>银行卡绑定</span></a></li>
                <li><a href="card.html" class="iconfont icon-shezhi2" ><span>修改个人资料</span></a></li>
            </ul>
            <h6 class="ic_h6">推广</h6>
            <ul>
                <li><a href="team.html" class="iconfont icon-kehu" ><span>我的团队</span></a></li>
                <li><a href="qrcode.html" class="iconfont icon-erweima2" ><span>推广二维码</span></a></li>
                <li><a class="iconfont icon-jingjiren" href="javascript:;"><span>推荐人:<em><?php echo $promo_name; ?></em></span></a></li>
            </ul>
            <a class="out" href="<?php echo url('login/logout'); ?>">退 出 登 录</a>
        </div>
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