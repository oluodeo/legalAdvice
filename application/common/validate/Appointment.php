<?php
namespace app\common\validate;

use think\Validate;

class Appointment extends Validate{
	
	protected $rule = [
        'linkman'         =>  'require',
        'mobile'         =>  'mobile',
    ];
    protected $message  =   [
        'linkman.require'  =>  '联系人名字不能为空',
        'mobile'          =>  '手机号错误',
    ];
	
}