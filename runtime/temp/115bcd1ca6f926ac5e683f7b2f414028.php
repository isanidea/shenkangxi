<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:83:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/user/edit.html";i:1522658784;s:90:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/layerbase.html";i:1522469719;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>主页</title>

    <link rel="stylesheet" href="__STATIC__/layui/css/layui.css" media="all">
    

    
    

    
</head>

<body>




<div style="width: 500px;height: 450px; padding-top: 30px">
    <div id="from" class="layui-form" data-url="<?php echo $submitUrl; ?>" >
        <input type="hidden" name="id" value="<?php echo !empty($Arr['id'])?$Arr['id'] : ''; ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">姓名</label>
            <div class="layui-input-inline">
                <input type="text" name="real_name" lay-verify="required" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['real_name'])?$Arr['real_name'] : ''; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">身份证号</label>
            <div class="layui-input-inline">
                <input type="text" name="id_card" lay-verify="required" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['id_card'])?$Arr['id_card'] : ''; ?>">
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">消费等级</label>
            <div class="layui-input-inline">
                <select name="lever" lay-verify="required">
                    <option value="0">--请选择--</option>
                    <?php if(is_array($levelName) || $levelName instanceof \think\Collection || $levelName instanceof \think\Paginator): if( count($levelName)==0 ) : echo "" ;else: foreach($levelName as $k=>$v): ?>
                        <option value="<?php echo $k; ?>" <?php echo !empty($Arr['level']) && $Arr['level']==$k?'selected' : ''; ?> ><?php echo $v; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">销售等级</label>
            <div class="layui-input-inline">
                <select name="manage_lv" lay-verify="required">
                    <option value="0">--请选择--</option>
                    <?php if(is_array($manageName) || $manageName instanceof \think\Collection || $manageName instanceof \think\Paginator): if( count($manageName)==0 ) : echo "" ;else: foreach($manageName as $k=>$v): ?>
                    <option value="<?php echo $k; ?>" <?php echo !empty($Arr['manage_lv']) && $Arr['manage_lv']==$k?'selected' : ''; ?> ><?php echo $v; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </div>
</div>




<script src="__STATIC__/js/jquery-3.2.1.min.js" charset="utf-8"></script>
<script src="__STATIC__/layer/layer.js" charset="utf-8"></script>
<script src="__STATIC__/layui/layui.js"  charset="utf-8"></script>
<script src="__STATIC__/admin/js/common.js" charset="utf-8"></script>





<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form;
        var layer = layui.layer;


        //监听提交
        form.on('submit(formDemo)', function(data){
            var url = $("#from").attr("data-url");
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: data.field,
                success: function (da) {
                    if( da.result == 0 ){
                        layer.open({
                            content: da.msg//
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

            return false;
        });

    });

</script>

</body>

</html>
