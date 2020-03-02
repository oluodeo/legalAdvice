<?php

namespace app\api\controller\v1;

use app\common\service\UserToken;
use app\common\service\Token as TokenService;
use app\exception\ParameterException;

/**
 * 获取令牌，相当于登录
 */
class Token
{
    /**
     * 用户获取令牌（登陆）
     * @url /token
     * @POST code
     * @note 虽然查询应该使用get，但为了稍微增强安全性，所以使用POST
     */
    public function getToken($code='')
    {
        if(!$code){
			throw new ParameterException([
                'code不允许为空'
            ]);
		}
        $wx = new UserToken($code);
        $token = $wx->get();
		$res = [
            'token' => $token
        ];
        return json($res);
		
    }
	
	public function verifyToken($token='')
    {
        if(!$token){
            throw new ParameterException([
                'token不允许为空'
            ]);
        }
        $valid = TokenService::verifyToken($token);
		$res = [
            'isValid' => $valid
        ];
        return json($res);
    }
	
}