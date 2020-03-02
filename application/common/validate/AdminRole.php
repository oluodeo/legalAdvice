<?php
namespace app\common\validate;

use think\Validate;

class AdminRole extends Validate{
	
	protected $rule = [
        'role_name'    =>  'require|max:100',
        '__token__'    =>  'require|token',
    ];
    protected $message  =   [
        'role_name.require'  =>  '角色名不能为空',
        'role_name.max'      =>  '角色名不能超过100个字符',
        '__token__'          =>  'Token非法操作或失效',
    ];
	
	/**
     * 定义情景
     * @var array
     */
    protected $scene = [
        'default'  =>  ['role_name'],
        'token'    =>  ['__token__']
    ];
}