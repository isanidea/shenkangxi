<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:95:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/product_order/details.html";i:1522927485;s:90:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/layerbase.html";i:1522469719;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>主页</title>

    <link rel="stylesheet" href="__STATIC__/layui/css/layui.css" media="all">
    

    
    

<style type="text/css">
    .details{padding: 15px 10px 20px;}
    .details li{padding-top: 5px;width: 50%;float: left;}
    .details li img{height: 98px;border: 1px solid #5e5d5d}
    .details li span{display: block;float: left;width: 120px;line-height: 30px;text-align: right;}
    .details li p{display: block;float: left;line-height: 30px;margin-left: 5px}
    .details li input{display: block;float: left;width: 150px;height: 28px;line-height: 28px;border: 1px solid #90988a;}
    .details .proof{padding-top: 15px;}
    .details .proof p{font-size: 18px;line-height: 30px;text-align: center;color: red;}
    .details .proof .img{width: 400px;margin: 0px auto;}
    .details .proof .img img{display: block;width: 100%;}
    .details .but{width: 180px; margin: 0px auto;padding-top: 10px;}
</style>


</head>

<body>


<div class="details">
    <li>
        <span>订单编号：</span>
        <p><?php echo $Arr['order_no']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>订单状态：</span>
        <p style="color: #ff7d23"><?php echo $Arr['statusName']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>商品名：</span>
        <p><?php echo $Arr['product_name']; ?></p>
        <div style="clear: both"></div>
    </li>

    <li>
        <span>商品价格：</span>
        <p style="color: red"><?php echo $Arr['product_jifen']; ?>(积分)</p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>购买数量：</span>
        <p><?php echo $Arr['buy_num']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>支付金额：</span>
        <p><?php echo $Arr['total_jifen']; ?>(元)</p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>购买时间：</span>
        <p><?php echo date("y-m-d H:i",$Arr['buy_time']); ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>发货时间：</span>
        <?php if($Arr['f_time'] == 0): ?>
        <p style="color: #1E9FFF">待发货</p>
        <?php else: ?>
        <p><?php echo date("y-m-d H:i",$Arr['f_time']); ?></p>
        <?php endif; ?>
        <div style="clear: both"></div>
    </li>
    <?php if($Arr['f_time'] == 0): ?>
    <li>
        <span>快递公司：</span>
        <input type="text" id="express_name" name="express_name">
        <div style="clear: both"></div>
    </li>
    <li>
        <span>快递单号：</span>
        <input type="text" id="express_code" name="express_code">
        <div style="clear: both"></div>
    </li>
    <?php else: ?>
    <li>
        <span>快递公司：</span>
        <p><?php echo $Arr['express_name']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>快递单号：</span>
        <p><?php echo $Arr['express_code']; ?></p>
        <div style="clear: both"></div>
    </li>
    <?php endif; ?>

    <li style="width: 100%;">
        <span>收货地址：</span>
        <p>姓名：<?php echo $Arr['name']; ?>&nbsp;&nbsp;&nbsp;电话：<?php echo $Arr['phone']; ?> &nbsp;&nbsp;&nbsp; 邮编：<?php echo $Arr['postcode']; ?></p>
        <div style="clear: both"></div>
    </li>

    <li style="width: 100%;">
        <span>&nbsp;</span>
        <p>详细地址：<?php echo $Arr['details']; ?></p>
        <div style="clear: both"></div>
    </li>

    <div style="clear: both"></div>
    <div class="but">
        <?php if($Arr['status'] == 10 or $Arr['status'] == 15): ?>
        <button class="layui-btn layui-btn-normal" onclick='order_del("<?php echo $Arr['id']; ?>")'>驳回</button>
        <button class="layui-btn layui-btn-normal" onclick='order_puy("<?php echo $Arr['id']; ?>")'>确认发货</button>
        <?php endif; ?>
    </div>

</div>



<script src="__STATIC__/js/jquery-3.2.1.min.js" charset="utf-8"></script>
<script src="__STATIC__/layer/layer.js" charset="utf-8"></script>
<script src="__STATIC__/layui/layui.js"  charset="utf-8"></script>
<script src="__STATIC__/admin/js/common.js" charset="utf-8"></script>






<script type="text/javascript">

    function order_del(id){
        layer.confirm('确定为驳回吗？不可更改！', function(index){
            $.ajax({
                type: 'POST',
                url: '<?php echo url("PackageOrder/order_del"); ?>',
                dataType: 'json',
                data: {id: id,status:0},
                success: function (data) {
                    layer.close(index);
                    if( data.result != 0 ){

                        layer.open({
                            content: data.msg//
                            ,yes: function(index, layero){
                                layer.close(index);
                            }
                        });
                    }else{

                        layer.open({
                            content: data.msg//
                            ,yes: function(index, layero){
                                var tk = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.layer.close(tk);
                                layer.close(index);
                            }
                            ,cancel:function(index){
                                var tk = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.layer.close(tk);
                                layer.close(index);
                            }
                        });
                    }
                }
            });

        });
    }

    function order_puy(id){
        layer.confirm('确定发货吗？不可更改！', function(index){

            var express_code = $("#express_code").val();
            var express_name = $("#express_name").val();
            if( express_name == "" ){
                layer.close(index);
                prompt_From_one("请输入快递公司名");
                return false;
            }
            if( express_code == "" ){
                layer.close(index);
                prompt_From_one("请输入快递单号");
                return false;
            }

            $.ajax({
                type: 'POST',
                url: '<?php echo url("packageOrder/order_fh"); ?>',
                dataType: 'json',
                data: {id: id,express_code:express_code,express_name:express_name},
                success: function (data) {
                    layer.close(index);
                    if( data.result != 0 ){

                        layer.open({
                            content: data.msg//
                            ,yes: function(index, layero){
                                layer.close(index);
                            }
                        });
                    }else{

                        layer.open({
                            content: data.msg//
                            ,yes: function(index, layero){
                                var tk = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.layer.close(tk);
                                layer.close(index);
                            }
                            ,cancel:function(index){
                                var tk = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
                                parent.layer.close(tk);
                                layer.close(index);
                            }
                        });
                    }
                }
            });
        });
    }
</script>


</body>

</html>
