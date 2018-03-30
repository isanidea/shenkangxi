<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/module/edit.html";i:1506075493;s:90:"/Applications/MxSrvs/www/shenkangxi/public/../application/admin/view/public/layerbase.html";i:1522310898;}*/ ?>
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




<div style="width: 500px;height: 150px; padding-top: 30px">
    <div id="from" class="layui-form" data-url="<?php echo $submitUrl; ?>" >
        <input type="hidden" name="id" value="<?php echo !empty($Arr['id'])?$Arr['id'] : ''; ?>">
        <div class="layui-form-item">
            <label class="layui-form-label">模块名</label>
            <div class="layui-input-inline">
                <input type="text" name="name" lay-verify="required" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['name'])?$Arr['name'] : ''; ?>">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">排序</label>
            <div class="layui-input-inline">
                <input type="text" name="sort"  lay-verify="sort" autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['sort'])?$Arr['sort'] : ''; ?>">
            </div>
            <div class="layui-form-mid layui-word-aux">请输入1-99</div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            </div>
        </div>
    </div>
</div>




<script src="__STATIC__/js/jquery-3.2.1.min.js" charset="utf-8"></script>
<!--<script src="__ADMIN__/layer/layer.js" charset="utf-8"></script>-->
<script src="__STATIC__/layui/layui.js"  charset="utf-8"></script>
<script src="__STATIC__/admin/js/common.js" charset="utf-8"></script>





<script type="text/javascript">
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form;
        var layer = layui.layer;

        //自定义验证规则
        form.verify({
            sort: function(value){
                if( value == "" || 0 > parseInt(value) || parseInt(value) > 99 ){
                    return '请输入排序1到99数字';
                }
            }
        });

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
