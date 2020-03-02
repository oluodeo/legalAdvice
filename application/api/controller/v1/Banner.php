<?php

namespace app\api\controller\v1;

use app\common\controller\ApiBase as BaseController;
use app\common\model\Banner as BannerModel;
use app\exception\MissException;
use app\exception\ParameterException;
use think\Exception;



class Banner extends BaseController{
	
	public function getBanner($id)
	{
		if(!$id){
			throw new ParameterException([
                'msg' => '参数错误'
            ]);
		}
		$banner = BannerModel::getBannerItemByBid($id);
		if(!$banner){
			throw new MissException([
                'msg' => '请求banner不存在',
                'errorCode' => 40000
            ]);
		}
		return json($banner);
//		return $banner;

	}
}