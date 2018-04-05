<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:91:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/order/goods_proof.html";i:1522244502;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/public/base.html";i:1522831855;}*/ ?>
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


<div class="tixian">
    <h1 class="h1">线下支付</h1>
    <input type="number" placeholder="卡号：<?php echo $Arr['income_code']; ?>" disabled="disabled" />
    <input type="text" placeholder="银行开户行：<?php echo $Arr['income_type']; ?>" disabled="disabled" />
    <input type="text" placeholder="收款人姓名：<?php echo $Arr['income_name']; ?>" disabled="disabled" />
    <input type="text" placeholder="打款金额：<?php echo $Arr['price']; ?>" disabled="disabled" />
    <p style="width: 80%;margin: auto;">上传打款凭据</p>
    <form id="proofForm" method="post" class="layui-form" action='<?php echo url("Order/goods_up_proof"); ?>' enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $Arr['id']; ?>">
        <input style="margin-top:0px;" type="file" id="file" name="file"  class="element">
        <input type="button" onclick="submitFuc()" value="提交" />
    </form>
    <p>温馨提示：打款后上传凭据，然后提交，客服会在工作日内进行处理。</p>
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

<script src="__INDEX__/js/layer/mobile/layer_mobile.js"></script>
<script src="__INDEX__/js/layer/mobile/layer.js"></script>
<script type="text/javascript">
    function submitFuc(){
        var v = $("#file").val();
        if( v == "" ){
            layer.open({
                content: '请选择支付凭证'
                ,style: 'color:#ffffff;border:none;'
                ,time: 2 //2秒后自动关闭
            });
            return false;
        }else{
            $("#proofForm").submit();
        }
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