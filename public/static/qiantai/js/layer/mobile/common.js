/**
 *
 */
function layer_alert(str){
    layer.open({
        content:str,
        style:'color:rgb(100,100,100);border:none;',
        time:2
    });
}
/**
 *
 */
function layer_alert_jump(str,url){
    layer.open({
        content:str,
        style:'color:#fff;border:none;',
        time:2,
        end:function () {
           location.href = url;
        }
    });

}

