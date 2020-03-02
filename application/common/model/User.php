<?php

namespace app\common\model;

use think\Db;

class User extends BaseModel
{
    /**
     * 获取User列表
     * @return array
     */
	public function getUserList()
    {
		$res = $this
            ->field("*")
            ->where('delete_time', 0)
            ->select()
            ->toArray();
        return $res;
    }
	
    /**
     * 根据openid获取用户信息
     * @param $openid
     * @return array
     */
    public function getByOpenid($openid)
    {
        $res = $this
            ->field('*')
            ->where('openid', $openid)
            ->find()
            ->toArray();
		
		//判断昵称和头像是否更改
//		$this->updateUserFromWX($data);
        return $res;
    }
	
	/**
     * 获取用户信息
     * @param $uid
     * @return array
     */
    public function getByUid($uid)
    {
        $res = $this
            ->field('*')
            ->where('id', $uid)
            ->find()
            ->toArray();

        return $res;
    }
	
	/**
     * 微信端添加新用户
     * @param $data
     * @return array
     */
    public function addUser($data)
    {
        $addData = [
            'openid' => $data['openid'],
			'create_time' => time(),
//			'nickname' => $data['nickname'],
//			'avatar' => $data['avatar']
        ];
		$Res = $this->insertGetId($addData);
        return $Res;
    }
	
	/**
     * 微信端修改用户信息，头像、昵称
     * @param $data
     * @return array
     */
    public function updateUserFromWX($data)
    {
        
    }
}