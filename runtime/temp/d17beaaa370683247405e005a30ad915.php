<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/order/order.html";i:1522931330;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/public/base.html";i:1522831855;}*/ ?>
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
    .address_show{padding: 10px;}
    .address_show p{line-height: 22px;}
</style>
<link rel="stylesheet" href="__STATIC__/qiantai/css/css.css">

</head>
<body>



<div class="jsxx">
    <h6>结算信息</h6>
    <dl>
        <div id="address" style="display: none;">

            <?php if(is_array($address) || $address instanceof \think\Collection || $address instanceof \think\Paginator): $i = 0; $__LIST__ = $address;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?>
            <label href="javascript:;"  class="aas" style="padding: 10px;border:1px solid #eee;box-sizing:border-box;display: block;text-align:left;width: 100%;overflow: hidden;"  onclick="getid(this,'<?php echo $a['id']; ?>');" >
                <p><?php echo $a['name']; ?> (<?php echo $a['phone']; ?>)</p>
                <p><?php echo $a['details']; ?></p>
            </label>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <a href='<?php echo url("User/add_address"); ?>' style="width: 100%;display: block;margin-top:20px;border-radius:5px;background: #007AFF;color: #fff;padding: 10px 0;">添加收获地址</a>
        </div>

        <dt><a href='javascript:;' onclick="address()">选择收货地址<span></span></a></dt>
        <dd class="address_show"></dd>



        <dd class="jsxx_tp">
            <i><img src="<?php echo $data['img']; ?>"/></i>
            <div class="jsxx_zj">
                <h3><?php echo $data['pname']; ?></h3>
                <em>数量：X<a><?php echo $data['buy_num']; ?></a></em>
            </div>
            <span>￥<?php echo $data['sales_price']; ?></span>
        </dd>
        <form id="orderForm" method="post" action='<?php echo url("Order/pay"); ?>'>
            <dd><a href="#">买家留言<input placeholder="填写卖家需求" type="text" id="remark" name="remark"/></a></dd>

            <dd class="dd_2"><i>总计：￥&nbsp;<?php echo $data['buy_num']*$data['sales_price']; ?></i></dd>

            <input type="hidden" id="pay_type" name="pay_type" value="1"/>
            <input type="hidden" id="address_id" name="address_id" value=""/>
            <input type="hidden" id="goods_id" name="pid" value="<?php echo $data['id']; ?>"/>
            <input type="hidden" id="buy_sum" name="buy_sum" value="<?php echo $data['buy_num']; ?>"/>
            <input type="hidden" id="total_price" name="total_price"value="<?php echo $data['buy_num']*$data['sales_price']; ?>">
        </form>
        <a href='javascript:;' onclick="submitPay()">生成订单</a>
    </dl>
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

<script src="__STATIC__/qiantai/js/jquery.js"></script>
<script src="__STATIC__/qiantai/js/layer/mobile/layer_mobile.js"></script>
<script src="__STATIC__/qiantai/js/layer/mobile/layer.js"></script>
<script type="text/javascript">
    var t = $("#total_points").val();
    var q = $("#chongxiao").val();
    function address(){
        var content = $('#address').html();
        layer.open({
            title: ['选择收货地址','background-color:#007AFF;color:#fff;height:50px;line-height:50px;'],
            style: 'width: 100%; height: auto;background-color:#fff',
            content: content,
            yes: function(index){
            }
        })
    }

    function getid(obj,id){
        var tx = $(obj).html();
        $(".address_show").html(tx);
        $("#address_id").val(id);
        layer.closeAll();
    }


    function submitPay(){

        var address_id = $("#address_id").val();
        if( address_id == "" ){
            layer_alert("请选择地址");
            return false;
        }

        var price = $("#price").val();
        var total_price = $("#total_price").val();
        var buy_sum = $("#buy_sum").val();
        var str = '需要&nbsp;￥'+ total_price;
//        if( my_acting < acting ){
//            var  sy = acting - parseInt(my_acting);
//            var zg = parseInt(total_price) + parseInt(sy);
//            str = "需要现金"+ zg + "代金劵"+ parseInt(my_acting);
//        }else{
//            str = "需要现金"+ total_price + "代金劵"+acting;
//        }

        layer.open({
            content: str
            ,style:"background-color:#007AFF;color:#ffffff;"
            ,btn: ['线下支付', '线上支付']
            ,yes: function(index){
                //线下支付
                $("#pay_type").val(1);
                $("#orderForm").submit();
            }
            ,no:function(index){
                //线上支付
                $("#pay_type").val(2);
                layer.closeAll();
//                prompt_From_one("线上支付暂未开放");
                $("#orderForm").submit();
            }
        });

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