/**
 * 提示框
 * @param  {[type]} msg     [description]
 * @param  {[type]} thetime [description]
 * @return {[type]}         [description]
 */
function msg (msg, thetime) {
	layer.open({
		time: thetime ? thetime : 3000,
		style: 'width: auto; height: auto;background-color:#ccc',
		content: msg,
		end: arguments[2] ? arguments[2] : null
	})
}

/**
 * 提示框
 * @param  {[type]} msg     [description]
 * @param  {[type]} thetime [description]
 * @return {[type]}         [description]
 */
function msg_h (msg, thetime) {
    layer.open({
        time: thetime ? thetime : 3,
        style: 'width: 20vw; height: 30vh;padding-top:15vh;background-color:#ccc',
        content: '<div style="width:50vw;margin-left:-22vw;transform: rotate(-90deg);font-size:5vw">'+msg+'</div>',
        end: arguments[2] ? arguments[2] : null
    })
}

function tips(data){
    layer.open({
    content: data
    ,skin: 'msg'
    ,time: 2 //2秒后自动关闭
  });
}

/**
 * 加载层
 * @return {[type]} [description]
 */
function loads () {
	layer.open({
		type: 2,
		shadeClose: false
	})
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
 * 询问跳转
 * @param  {[type]} url       [description]
 * @param  {[type]} post_data [description]
 * @return {[type]}           [description]
 */
function url (url, post_data,title) {
    title = title?title:'确定要执行该操作吗?';
	layer.open({
		style: 'width: auto; height: auto;',
		content: title,
		btn: ['确认','取消'],
		yes: function(index){
			ajax(url, post_data);
		}
	})
}

function url_no_tips (url, post_data,title) {
    title = title?title:'确定要执行该操作吗?';
    layer.open({
        style: 'width: auto; height: auto;',
        content: title,
        btn: ['确认','取消'],
        yes: function(index){
            ajax_no_tips(url, post_data);
        }
    })
}



// 验证手机号
function isPhoneNo(phone) {
   var pattern = /^1[34578]\d{9}$/;
   return pattern.test(phone);
}



/**
 * 询问
 * @param  {[type]} url       [description]
 * @param  {[type]} post_data [description]
 * @return {[type]}           [description]
 */
function confirm_submit (msg,url,data) {
    layer.open({
        style: 'width: auto; height: auto;',
        content: msg,
        btn: ['确认','取消'],
        yes: function(){
            ajax(url, data);
        }
    })
}


/**
 * 发送
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
	ajax(url, data);
}

/**
 * 发送返回刷新
 * @param  {[type]} url [description]
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
function reload (url, obj) {
    alert(555);return false;
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
    var success = arguments[2] ? arguments[2] : null;
    var error = arguments[3] ? arguments[3] : null;
    loads();
    $.post(url, data, function (data) {
        layer.closeAll();
        if (data.status == "1") {
            msg(data.info, 2);
            window.location.reload();
        } else if (data.status == "0") {
            msg(data.info, 3);
            // window.location.reload();
        }
    }, 'json')
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
                layer.open({
                    time: 4,
                    style: 'width: auto; height: auto;background-color:#ccc',
                    content: data.info,
                    end: function(e){
                        loads();
                        location.href = data.url;
                    }
                })
            } else {
                (success && typeof (success) == "function") && success(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        } else if (data.status == "0") {
            if (isnoempty(data.info) == true) {
                layer.open({
                    time: 4,
                    style: 'width: auto; height: auto;background-color:#ccc',
                    content: data.info,
                    end: function(e){
                        loads();
                        location.href = data.url;
                    }
                })
            } else {
                (error && typeof (error) == "function") && error(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        }
	}, 'json')
}


function ajax_no_tips (url, post_data) {
    var success = arguments[2] ? arguments[2] : null;
    var error = arguments[3] ? arguments[3] : null;
    loads();
    $.post(url, post_data, function (data) {
        layer.closeAll();
        if (data.status == "1") {
            if (isnoempty(data.info) == true) {
                // layer.open({
                //     time: 2,
                //     style: 'width: auto; height: auto;background-color:#ccc',
                //     content: data.info,
                //     end: function(e){
                        loads();
                        location.href = data.url;
                //     }
                // })
            } else {
                (success && typeof (success) == "function") && success(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        } else if (data.status == "0") {
            if (isnoempty(data.info) == true) {
                // layer.open({
                    // time: 4,
                    // style: 'width: auto; height: auto;background-color:#ccc',
                    // content: data.info,
                    // end: function(e){
                        loads();
                        location.href = data.url;
                    // }
                // })
            } else {
                (error && typeof (error) == "function") && error(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        }
    }, 'json')
}


function ajax_h (url, post_data) {
    var success = arguments[2] ? arguments[2] : null;
    var error = arguments[3] ? arguments[3] : null;
    loads();
    $.post(url, post_data, function (data) {
        layer.closeAll();
        if (data.status == "1") {
            if (isnoempty(data.info) == true) {
                msg_h(data.info, 2, function() {
                    (success && typeof (success) == "function") && success(data);
                    if (isnoempty(data.url) == true)
                        location.href = data.url;
                });
            } else {
                (success && typeof (success) == "function") && success(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        } else if (data.status == "0") {
            if (isnoempty(data.info) == true) {
                msg_h(data.info, 4, function() {
                    (error && typeof (error) == "function") && error(data);
                    if (isnoempty(data.url) == true)
                        location.href = data.url;
                });
            } else {
                (error && typeof (error) == "function") && error(data);
                if (isnoempty(data.url) == true)
                    location.href = data.url;
            }
        }
    }, 'json')
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