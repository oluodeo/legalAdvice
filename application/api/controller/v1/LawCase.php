<?php

namespace app\api\controller\v1;

use app\common\controller\ApiBase as BaseController;
use app\common\model\LawCase as LawCaseModel;
use app\exception\MissException;
use think\Exception;



class LawCase extends BaseController{
	
	public function __construct()
    {
		$this->lawCaseM = new LawCaseModel();
        $this->api_page_limit = config('setting.API_PAGE_SIZE');
    }
	
	/**
     * 获取案件列表（简要信息）
     * @param int $size
     * @return array
     * @throws \app\exception\MissException
     */
	public function getRecommendCaseList($size = 10)
	{
		$caseList = $this->lawCaseM->getRecommendCaseList($size);
		if(!$caseList){
			$caseList = [];
		}
		return json($caseList);

	}
	
	/**
     * 分页获取案件列表
     * @param int $page
     * @return array
     */
	public function getCaseList($page=1)
	{
		$caseList = $this->lawCaseM->getCaseListForPage($page,$this->api_page_limit);
		if($caseList->isEmpty()){
            return json([
                'current_page' => $caseList->currentPage(),
                'data' => []
            ]);
		}
		return json($caseList);

	}
	
	/**
     * 获取订单详情
     * @param $id
     * @return array
     * @throws \app\exception\ParameterException
     * @throws \app\exception\MissException
     */
    public function getCaseByID($id)
    {
        if(!$id){
			throw new ParameterException();
		}
        $caseIntro = $this->lawCaseM->getCaseById($id);
        if (!$caseIntro)
        {
            throw new MissException([
                'msg' => '请求案例不存在',
                'errorCode' => 40000
            ]);
        }
        return json($caseIntro);
    }
}