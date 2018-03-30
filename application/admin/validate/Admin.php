<?php

namespace app\admin\validate;
use think\Validate;
class Admin extends Validate
{
    protected $rule = [
        'name'  =>  'require|min:2',
        'account'=>'require|min:4',

    ];

    protected $message = [
        'name.require'  =>  '真实姓名必填',
        'name.min'  =>  '真实姓名不能小于两个字',
        'account.require'  =>  '后台账号必填',
        'account.min'  =>  '后台账号不能小于4个字',
    ];

	
}
?>