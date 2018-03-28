<?php

namespace app\admin\validate;
use think\Validate;
class Module extends Validate
{
    protected $rule = [
        'name'  =>  'require|min:2',
        'sort'=>'number',
    ];

    protected $message = [
        'name.require'  =>  '后台菜单名称必填',
        'name.min'  =>  '后台菜单名称不能小于两个字',
        'sort.number'  =>  '排序必须是数字',
    ];

	
}
?>