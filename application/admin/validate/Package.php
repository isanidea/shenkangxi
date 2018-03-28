<?php

namespace app\admin\validate;
use think\Validate;
class Package extends Validate
{
    protected $rule = [
        'level'  =>  'require',
        'price' => "number",
        'name' => "require",
        'sort'=>'number',
    ];

    protected $message = [
        'level.require'  =>  '套餐等级必填',
        'price.number'  =>  '价格必须是数字',
        'sort.number'  =>  '排序必须是数字',
        'name.require' => '产品名称必填',
    ];

	
}
?>