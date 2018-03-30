<?php

namespace app\admin\validate;
use think\Validate;
class Department extends Validate
{
    protected $rule = [
        'name'  =>  'require|min:2',
    ];

    protected $message = [
        'name.require'  =>  '后台菜单名称必填',
        'name.min'  =>  '后台菜单名称不能小于两个字',
    ];

	
}
?>