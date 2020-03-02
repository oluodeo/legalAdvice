<?php

namespace app\api\controller\v1;

use app\common\controller\ApiBase as BaseController;
use app\common\model\User as UserModel;
use app\exception\MissException;
use think\Exception;



class User extends BaseController{
	
	public function __construct()
    {
		$this->userM = new UserModel();
    }
	
	public function getUserList()
	{
		$userList = [
			['nickname' => 'u1',
            'avatar' => config('setting.img_prefix').'avatar1.png'],
			['nickname' => 'u2',
            'avatar' => config('setting.img_prefix').'avatar2.png'],
			['nickname' => 'u3',
            'avatar' => config('setting.img_prefix').'avatar3.png'],
			['nickname' => 'u4',
            'avatar' => config('setting.img_prefix').'avatar4.png']
		];
//		$userList = $this->userM->getUserList();
//		if(!$userList){
//			throw new MissException([
//                'msg' => '请求user列表不存在',
//                'errorCode' => 40000
//            ]);
//		}
		return json($userList);

	}
}