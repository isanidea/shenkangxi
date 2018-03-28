/**
 * 提示框
 * @param  {[type]} msg     [description]
 * @param  {[type]} thetime [description]
 * @return {[type]}         [description]
 */
function msg (msg,time,icon) {
    layer.msg(msg, {
      time: time, 
      icon: icon,
      end: arguments[2] ? arguments[2] : null
    });
}



/**
 * tips层，元素边缘提示框
 * [tips description]
 * @return {[type]} [description]
 * type: 1上 2右 3下 4左
 */
function tips(obj,txt,type,color){
    layer.tips(txt, obj, {tips: [type, color]});
}

/**
 * 加载层
 * @return {[type]} [description]
 */
function loads () {
    var index = layer.load(0); //0代表加载的风格，支持0-2
}

/**
 * 跳转
 * @param  {[type]} url [description]
 * @return {[type]}     [description]
 */
function go (url) {
    window.location.href = url;
}

/**
 * iframe层
 * @param  {[type]} url   iframe的url
 * @param  {[type]} title iframe的标题
 * @return {[type]}       [description]
 */
function iframe(url,title,w,h){
    layer.open({
      type: 2,
      title: title,
      shadeClose: true,
      shade: 0.8,
      area: [w, h],
      content: url, //iframe的url
      /*end:function(){
        window.location.reload();
      }*/
    });
}

/**
 * 提交刷新
 * @param  {[type]} url       [description]
 * @param  {[type]} post_data [description]
 * @return {[type]}           [description]
 */
function reload (url, post_data) {
    loads();
    $.post(url,post_data,function(data){
        layer.closeAll();
        if (data.status == "1") {
            layer.msg(data.info, {
              time: 1500, 
              icon: 1,
              end: function(){
                // window.location.reload();
                window.location.href = data.url;
              }
            });

        } else if (data.status == "0") {
            layer.msg(data.info, {
              time: 1500, 
              icon: 2,
              end: function(){
                // window.location.reload();
                window.location.href = data.url;
              }
            });
        }
    });
}


/**
 * 询问跳转
 * @param  {[type]} url       [description]
 * @param  {[type]} post_data [description]
 * @return {[type]}           [description]
 */
function url (url, post_data) {
    layer.open({
        style: 'width: auto; height: auto;',
        content: '确定要执行该操作吗?',
        btn: ['确认','取消'],
        yes: function(index){
            reload(url, post_data);
        }
    })
}


function ask(){
    layer.confirm('确定购买？', {
      btn: ['确定','取消'] //按钮
    }, function(){
      //确定执行的操作;
      window.location.href = "http://www.baidu.com";
    }, 
    function(){
      //取消动作
    });
}




/**
 * 发送
 * 给必填项加类名not_null
 * @param  {[type]} url [description]
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
function send (url, obj) {
    var flag = 1;
    $(obj+" .not_null").each(function() {
        if($(this).val().length<1){
            $(this).stop()
            .css({'position':'relative','border':'solid 1px #f00'})
            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
            .animate({ left: "0px" }, 100);
            flag = 2;
        }
    });
    if(flag==2){
        return false;
    }
    var data = $(obj).serialize();
    ajax_1(url, data);
}


function ajax_1 (url, post_data) {
    var success = arguments[2] ? arguments[2] : null;
    var error = arguments[3] ? arguments[3] : null;
    loads();
    $.post(url, post_data, function (data) {
        layer.closeAll();
        if (data.status == "1") {

            if (isnoempty(data.info) == true) {
                // msg(data.info, 3000, 1, function() {
                //     (success && typeof (success) == "function") && success(data);
                //     if (isnoempty(data.url) == true)
                //         location.href = data.url;
                // });
                tip_tz(data.url,data.info);
            } else {
                (success && typeof (success) == "function") && success(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        } else if (data.status == "0") {
            if (isnoempty(data.info) == true) {
                // msg(data.info, 3000, 2, function() {
                //     (error && typeof (error) == "function") && error(data);
                //     if (isnoempty(data.url) == true)
                //         location.href = data.url;
                // });
                msg(data.info);
                // tip_tz_1(data.url,data.info);
            } else {
                (error && typeof (error) == "function") && error(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        }
    }, 'json')
}



//提交表单并刷新
function send_1 (url, obj) {
    var flag = 1;
    $(obj+" .not_null").each(function() {
        if($(this).val().length<1){
            $(this).stop()
            .css({'position':'relative','border':'solid 1px #f00'})
            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
            .animate({ left: "-10px" }, 100).animate({ left: "10px" }, 100)
            .animate({ left: "0px" }, 100);
            flag = 2;
        }
    });
    if(flag==2){
        return false;
    }
    var data = $(obj).serialize();
    reload(url, data);
}


/**
 * 底部提示
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
function bottom_notice (obj) {
    //页面层
    layer.open({
        type: 1,
        content: obj,
        anim: 'up',
        style: 'position:fixed; bottom:0; left:0; width: 100%; height: auto; overflow: hidden; padding:10px 0; border:none;'
    });
}

/**
 * 异步
 * @param  {[type]} url       [description]
 * @param  {[type]} post_data [description]
 * @return {[type]}           [description]
 */
function ajax (url, post_data) {
    var success = arguments[2] ? arguments[2] : null;
    var error = arguments[3] ? arguments[3] : null;
    loads();
    $.post(url, post_data, function (data) {
        layer.closeAll();
        if (data.status == "1") {

            if (isnoempty(data.info) == true) {
                // msg(data.info, 3000, 1, function() {
                //     (success && typeof (success) == "function") && success(data);
                //     if (isnoempty(data.url) == true)
                //         location.href = data.url;
                // });
                tip_tz(data.url,data.info);
            } else {
                (success && typeof (success) == "function") && success(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        } else if (data.status == "0") {
            if (isnoempty(data.info) == true) {
                // msg(data.info, 3000, 2, function() {
                //     (error && typeof (error) == "function") && error(data);
                //     if (isnoempty(data.url) == true)
                //         location.href = data.url;
                // });
                tip_tz_1(data.url,data.info);
            } else {
                (error && typeof (error) == "function") && error(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        }
    }, 'json')
}


//ajax 成功返回 并执行跳转操作
function tip_tz(url,info){
    layer.msg(info, {
      icon: 1,
      time: 2000 //2秒关闭（如果不配置，默认是3秒）
    }, function(){
      window.location.href = url;
    });
}

//ajax 成功返回(返回失败) 并执行跳转操作
function tip_tz_1(url,info){
    layer.msg(info, {
      icon: 2,
      time: 2000 //2秒关闭（如果不配置，默认是3秒）
    }, function(){
      window.location.href = url;
    });
}



/**
 * 判断是否为空
 * @param {type} val
 * @returns {Boolean}
 */
function isnoempty(val) {
     if(typeof(val) == 'undefined'){
        return false;
    }
    if (val != '' && val != null && val != undefined)
        return true;
    else
        return false;
}

/**
 * 列表页修改单字段
 */
function modify(obj){
    var old_data = '';
    var flag = 1;
    $(obj).click(function(){
        if(flag==1){
            var html = '';
            var url = $(this).data('url');
            var id = $(this).attr('id');
            old_data = $(this).html();
            html +='<form id="productno">';
            html +='<input type="text" id="modity" style="width:auto;height:20px;margin:0;padding:0" value="'+old_data+'"/>';
            html +='</form>'
            $(this).html(html);
            $('#modity').focus();
            flag = 0;
        }
    });
    $('.mdlb').on('blur', '#modity', function(event) {
        var data = $('#modity').val();
        if(data === old_data){
            $(this).parent().parent().html(data);
            flag = 1;
            return false;
        }
        var url  = $(this).parent().parent().data('url');
        var id   = $(this).parent().parent().attr('id');
        $(this).parent().parent().html(data);
        $.post(url,{id:id,productno:data,type:1},function(json){
            if(json.status==1){
                tips('#'+id,json.info,2,'#78BA32');
                $('#'+id).html(json.url);
            }else{
                tips('#'+id,json.info,2,'#FF0000');
                $('#'+id).html(old_data);
            }
        });
        flag = 1;
    });
}
