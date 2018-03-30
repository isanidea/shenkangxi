<?php

namespace app\admin\validate;
use think\Validate;
class Role extends Validate
{
    protected $rule = [
        'name'  =>  'require|min:1',
        'sort'=>'number',
    ];

    protected $message = [
        'name.require'  =>  '后台菜单名称必填',
        'name.min'  =>  '后台菜单名称不能小于1个字',
        'ort.number'  =>  '排序必须是数字',
    ];

	
}
?>