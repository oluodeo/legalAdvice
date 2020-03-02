<?php
namespace app\common\validate;

use think\Validate;

class Admin extends Validate{
	
	protected $rule = [
        'user_name'    =>  'require|max:100',
        'role_id'      =>  'number',
        'content'      =>  'require|max:500',
        '__token__'    =>  'require|token',
    ];
    protected $message  =   [
        'user_name.require'  =>  '管理员账号不能为空',
        'user_name.max'      =>  '账号不能超过100个字符',
        'role_id'            =>  '角色不能为空',
        'content.require'    =>  '备注信息不能为空',
        'content.max'        =>  '备注信息不能超过500字符',
        '__token__'          =>  'Token非法操作或失效',
    ];
	
	/**
     * 定义情景
     * @var array
     */
    protected $scene = [
        'default'  =>  ['user_name','role_id','content'],
        'token'    =>  ['__token__'],
        'curr_admin'=>  ['user_name','content']
    ];
}