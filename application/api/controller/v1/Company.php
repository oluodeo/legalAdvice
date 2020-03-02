<?php

namespace app\api\controller\v1;

use app\common\controller\ApiBase as BaseController;
use app\common\model\Company as CompanyModel;
use app\exception\MissException;
use think\Exception;



class Company extends BaseController{
	
	public function __construct()
    {
		$this->companyM = new CompanyModel();
    }
	
	/**
     * 获取公司信息
     * @return array
     * @throws \app\exception\MissException
     */
	public function getCompanyIntro()
	{
		$companyIntro = $this->companyM->getCompanyIntro();
		if(!$companyIntro){
			throw new MissException([
                'msg' => '公司信息获取失败'
            ]);
		}
		return json($companyIntro);

	}
}