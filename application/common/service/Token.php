<?php

namespace app\common\service;

use app\exception\ForbiddenException;
use app\exception\ParameterException;
use app\exception\TokenException;
use think\facade\Cache;
use think\Exception;
use think\Facade\Request;

class Token
{

    // 生成令牌
    public static function generateToken()
    {
        $randChar = getRandChar(32);//32为随机字符串
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $tokenSalt = config('setting.token_salt');//提高保密性的盐
        return md5($randChar . $timestamp . $tokenSalt);
    }
	
	public static function getCurrentTokenVar($key)
    {
        $token =Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars)
        {
            throw new TokenException();
        }
        else {
            if(!is_array($vars))
            {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key, $vars)) {
                return $vars[$key];
            }
            else{
                throw new Exception('尝试获取的Token变量并不存在');
            }
        }
    }

    /**
     * 从缓存中获取当前用户指定身份标识
     * @param array $keys
     * @return array result
     * @throws \app\lib\exception\TokenException
     */
    public static function getCurrentIdentity($keys)
    {
        $token = Request::instance()
            ->header('token');
        $identities = Cache::get($token);
        //cache 助手函数有bug
//        $identities = cache($token);
        if (!$identities)
        {
            throw new TokenException();
        }
        else
        {
            $identities = json_decode($identities, true);
            $result = [];
            foreach ($keys as $key)
            {
                if (array_key_exists($key, $identities))
                {
                    $result[$key] = $identities[$key];
                }
            }
            return $result;
        }
    }


    /**
     * 检查操作UID是否合法
     * @param $checkedUID
     * @return bool
     * @throws Exception
     * @throws ParameterException
     */
    public static function isValidOperate($checkedUID)
    {
        if(!$checkedUID){
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }
        $currentOperateUID = self::getCurrentTokenVar('uid');
        if($currentOperateUID == $checkedUID){
            return true;
        }
        return false;
    }

    public static function verifyToken($token)
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }
	
	/**
     * 获取全局UID
     *
     */
    public static function getCurrentUid()
    {
        return self::getCurrentTokenVar('uid');
    }
}