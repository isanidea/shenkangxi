/**
 * Created by hp on 2017/9/17.
 */


/*
*
* 弹框
* 自动关闭的
* */
function prompt_From_one(srt){
    layui.use("layer",function(){
        var layer = layui.layer;
        layer.open({
            content: srt//
            ,yes: function(index, layero){
                layer.close(index);
            }
            ,time:3000
        });

    });
}
/*
 *
 * 弹框
 * 自动关闭,跳转
 * */
function prompt_From_jump(srt,url){
    layui.use("layer",function(){
        var layer = layui.layer;
        layer.open({
            content: srt//
            ,yes: function(index, layero){
                layer.close(index);
                location.href = url;
            }
            ,end:function(){
                location.href = url;
            }
            ,time:3000
        });

    });
}







