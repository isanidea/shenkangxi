<?php

namespace app\admin\validate;
use think\Validate;
class Menu extends Validate
{
    protected $rule = [
        'menu_name'  =>  'require|min:2',
        'module_id' => "number",
        'module_name' => "require",
        'sort'=>'number',
        'controller' => 'require|alpha',
        'action' => 'require',
    ];

    protected $message = [
        'menu_name.require'  =>  '后台菜单名称必填',
        'menu_name.min'  =>  '后台菜单名称不能小于两个字',
        'sort.number'  =>  '排序必须是数字',
        'controller.require' => '类名称必填',
        'controller.alpha' => '类名必须为字母',
        'action.require' => '方法名称必填',
    ];

	
}
?>