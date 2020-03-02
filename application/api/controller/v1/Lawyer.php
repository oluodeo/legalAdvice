<?php

namespace app\api\controller\v1;

use app\common\controller\ApiBase as BaseController;
use app\common\model\Lawyer as LawyerModel;
use app\exception\MissException;
use think\Exception;



class Lawyer extends BaseController{
	
	public function __construct()
    {
		$this->lawyerM = new LawyerModel();
    }
	
	/**
     * 获取律师信息
     * @return array
     * @throws \app\exception\MissException
     */
	public function getLawyerDetails()
	{
		$lawyerDetails = $this->lawyerM->getLawyerDetails();
		if(!$lawyerDetails){
			throw new MissException([
                'msg' => '律师信息获取失败',
                'errorCode' => 50000
            ]);
		}
		return json($lawyerDetails);

	}
}