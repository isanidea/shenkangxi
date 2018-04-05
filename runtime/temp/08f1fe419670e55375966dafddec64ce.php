<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:96:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/recharge/order_details.html";i:1522813910;s:90:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/layerbase.html";i:1522469719;}*/ ?>
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
    .details li span{display: block;float: left;width: 120px;line-height: 25px;text-align: right;}
    .details li p{display: block;float: left;line-height: 25px;margin-left: 5px}
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
        <span>充值人ID：</span>
        <p><?php echo $Arr['uid']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>姓名：</span>
        <p><?php echo $Arr['real_name']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>账号：</span>
        <p><?php echo $Arr['username']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>金额：</span>
        <p><?php echo $Arr['money']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>状态：</span>
        <p style="color: red"><?php echo $Arr['statusName']; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>支付类型：</span>
        <p><?php echo !empty($Arr['payway']) && $Arr['payway']==1?'线下' : '线上'; ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>下单时间：</span>
        <p><?php echo date("Y-m-d H:m:s",$Arr['add_time']); ?></p>
        <div style="clear: both"></div>
    </li>
    <li>
        <span>支付时间：</span>
        <?php if($Arr['payway'] == 0): ?>
        <p>&nbsp;</p>
        <?php else: ?>
        <p><?php echo date("Y-m-d H:m:s",$Arr['pay_time']); ?></p>
        <?php endif; ?>
        <div style="clear: both"></div>
    </li>

    <div style="clear: both"></div>
    <div class="but">
        <?php if($Arr['status'] == 10 or $Arr['status'] == 15): ?>
        <button class="layui-btn layui-btn-normal" onclick='order_del("<?php echo $Arr['id']; ?>")'>驳回</button>
        <button class="layui-btn layui-btn-normal" onclick='order_puy("<?php echo $Arr['id']; ?>")'>确认付款</button>
        <?php endif; ?>
    </div>
    <div class="proof">
        <p>打款凭证</p>
        <div class="img">
            <a target="_blank" href="<?php echo $Arr['proof']; ?>">
                <img src="<?php echo $Arr['proof']; ?>">
            </a>
        </div>
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
                url: '<?php echo url("Recharge/order_del"); ?>',
                dataType: 'json',
                data: {id: id,status:5},
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
        layer.confirm('确定支付了吗？不可更改！', function(index){
            $.ajax({
                type: 'POST',
                url: '<?php echo url("Recharge/affirm_puy"); ?>',
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

</script>


</body>

</html>
