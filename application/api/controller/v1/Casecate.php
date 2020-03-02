<?php

namespace app\api\controller\v1;

use app\common\controller\ApiBase as BaseController;
use app\common\model\CaseCate as CaseCateModel;
use app\exception\MissException;
use think\Exception;



class Casecate extends BaseController{
	
	public function __construct()
    {
		$this->caseCateM = new CaseCateModel();
    }
	
	/**
     * 获取咨询类型
     * @return array
     * @throws \app\exception\MissException
     */
	public function getCasecate()
	{
		$casecateList = $this->caseCateM->getCasecateList();
		if(!$casecateList){
			$casecateList = [
				
			];
		}
		return json($casecateList);

	}
	
}