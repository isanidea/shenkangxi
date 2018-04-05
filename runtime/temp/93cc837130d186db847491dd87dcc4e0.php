<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:84:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/user/index.html";i:1522287772;s:85:"/Applications/MxSrvs/www/shenkangxi/public/../application/index/view/public/base.html";i:1522824451;}*/ ?>
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
    <style>
        .sb_4 {
            color: #007AFF;
        }

        .sb_4 span {
            color: #007AFF;
        }
    </style>
    
<link rel="stylesheet" href="__PUBLIC__/css/adminPage.css"  media="all">

</head>
<body>


<div class="screening">
    <form class="layui-form" action='<?php echo url("User/index"); ?>' method="get">

        <div class="layui-form-item" style="clear: none;float: left">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-inline">
                <input type="text" name="account"  autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['account'])?$Arr['account'] : ''; ?>">
            </div>
        </div>
        <div class="layui-form-item" style="clear: none;float: left">
            <label class="layui-form-label">等级</label>
            <div class="layui-input-inline">
                <input type="text" name="level"  autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['level'])?$Arr['level'] : ''; ?>">
            </div>
        </div>
        <div class="layui-form-item" style="clear: none;float: left">
            <label class="layui-form-label">总业绩</label>
            <div class="layui-input-inline">
                <input type="text" name="results"  autocomplete="off" class="layui-input" value="<?php echo !empty($Arr['results'])?$Arr['results'] : ''; ?>">
            </div>
        </div>
        <div class="layui-form-item" style="clear: none;float: left">
            <label class="layui-form-label">开始时间</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" lay-verify="start_time" value="<?php echo !empty($Arr['start_time'])?$Arr['start_time'] : ''; ?>" name="start_time" id="start_time" placeholder="yyyy-MM-dd HH:mm:ss">
            </div>
        </div>
        <div class="layui-form-item" style="clear: none;float: left">
            <label class="layui-form-label">结束时间</label>
            <div class="layui-input-inline">
                <input type="text" class="layui-input" name="end_time" value="<?php echo !empty($Arr['end_time'])?$Arr['end_time'] : ''; ?>" id="end_time" placeholder="yyyy-MM-dd HH:mm:ss">
            </div>
        </div>

        <div class="layui-form-item" style="clear: none;float: left">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit lay-filter="formDemo">确定</button>
            </div>
        </div>
        <div class="clear"></div>
    </form>
</div>

<table class="layui-table">
    <colgroup>
        <col width="60">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="200">
        <col width="100">
    </colgroup>
    <thead>
    <tr>
        <th>ID</th>
        <th>账号</th>
        <th>手机</th>
        <th>真实姓名</th>
        <th>等级</th>
        <th>直推数</th>
        <th>团队业绩</th>
        <th>已获得收益</th>
        <th>注册时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if(is_array($user) || $user instanceof \think\Collection || $user instanceof \think\Paginator): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$u): $mod = ($i % 2 );++$i;?>
    <tr>
        <td><?php echo $u['id']; ?></td>
        <td><?php echo $u['account']; ?></td>
        <td><?php echo $u['mobile']; ?></td>
        <td><?php echo $u['realname']; ?></td>
        <td><?php echo $u['level']; ?></td>
        <td><?php echo $u['zhitui']; ?></td>
        <td><?php echo $u['results']; ?></td>
        <td><?php echo $u['new_price']; ?></td>
        <td><?php echo date("Y-m-d H:i",$u['addtime']); ?></td>
        <td>
            <div class="layui-table-cell laytable-cell-1-10">
                <a class="layui-btn layui-btn-mini" href='<?php echo url("User/details",array("id"=>$u['id'])); ?>' lay-event="edit">查看</a>
                <!--<a class="layui-btn layui-btn-danger layui-btn-mini" href="__URL__/delete/id/<?php echo $u['id']; ?>">删除</a>-->
            </div>
        </td>
    </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>

</table>
<?php echo $page; ?>

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

<script src="__JS__/fromCommon.js" charset="utf-8"></script>

</body>
</html>