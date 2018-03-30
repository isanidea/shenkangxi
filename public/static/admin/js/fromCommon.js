

/**
 * Created by hp on 2017/9/22.
 */

function saveSingleVal(id,a){
    var v = $(id).val();
    var u = $(id).attr("data-url");
    $.ajax({
        type: 'POST',
        url: u,
        dataType: 'json',
        data: {id: a,sort:v},
        success: function (data) {
            if( data.result == 1 ){
                $(id).val(v);
                prompt_From_one("错误排序值");
            }
        }
    });
}

function saveStatusVal(obj,id,s){
    var u = $(obj).attr("data-url");
    $.ajax({
        type: 'POST',
        url: u,
        dataType: 'json',
        data: {id: id,status:s},
        success: function (data) {
            if( data.result == 0 ){
                layui.use("layer",function(){
                    var layer = layui.layer;
                    layer.open({
                        content: "操作成功"//
                        ,yes: function(index, layero){
                            layer.close(index);
                            location.reload();
                        }
                        ,end:function(){
                            location.reload();
                        }
                        ,time:3000
                    });
                });
            }else{
                prompt_From_one("操作失败");
            }
        }
    });
}

function deleteFuc(id,a){

    layui.use("layer",function(){
        var layer = layui.layer;
        layer.open({
            content: "确定要删除吗？"//
            ,yes: function(index, layero){
                var u = $(id).attr("data-url");
                $.ajax({
                    type: 'POST',
                    url: u,
                    dataType: 'json',
                    data: {id: a},
                    success: function (data) {
                        layer.close(index);
                        if( data.result == 0 ){
                            layer.open({
                                content: "删除成功"//
                                ,yes: function(index, layero){
                                    layer.close(index);
                                    location.reload();
                                }
                                ,end:function(){
                                    location.reload();
                                }
                                ,time:3000
                            });
                        }else{
                            prompt_From_one("删除失败");
                        }
                    }
                });
            }
        });

    });
}
