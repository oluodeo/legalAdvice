<?php

namespace app\common\model;

use think\Db;
use think\Model;

class LawCase extends BaseModel
{
    /**
     * 获取指定数量案例列表
     * @return array
     */
	public function getRecommendCaseList($count)
    {
		$res = $this
            ->alias('lc')
            ->field('lc.id,lc.title,cp.view,cp.picture,cp.abstract')
			->join('case_points cp', 'lc.id = cp.case_id')
            ->order('lc.list_order', 'desc')
            ->where("lc.delete_time", 0)
            ->limit(0, $count)
            ->select()
            ->toArray();
		foreach ($res as $key => $v) {
            $res[$key]['picture_url'] = config('setting.upload_prefix').$v['picture'];
			$str_n = mb_substr($v['abstract'],0,50,'utf-8');
            $res[$key]['abstract_f'] = strlen($v['abstract'])>50?($str_n.'...'):$v['abstract'];
			
        }
        return $res;
    }
	
	/**
     * 分页获取案例列表
     * @return array
     */
	public function getCaseListForPage($page=1,$size=10)
    {
		$res = $this
            ->alias('lc')
            ->field('lc.id,lc.title,cp.view,cp.picture,cp.abstract')
			->join('case_points cp', 'lc.id = cp.case_id')
            ->order('lc.list_order', 'desc')
            ->where("lc.delete_time", 0)
            ->paginate($size,true,['page'=>$page]);
					
		foreach ($res as $key => $v) {
            $res[$key]['picture_url'] = config('setting.upload_prefix').$v['picture'];
			$str_n = mb_substr($v['abstract'],0,50,'utf-8');
            $res[$key]['abstract_f'] = strlen($v['abstract'])>50?($str_n.'...'):$v['abstract'];
			
        }
		return $res;
    }
	
    /**
     * 根据id获取案例信息
     * @param $id
     * @return array
     */
    public function getCaseById($id)
    {
        $res = $this
            ->alias('lc')
            ->field('lc.id,lc.title,lc.content,lc.create_time,cp.view,cp.picture')
			->join('case_points cp', 'lc.id = cp.case_id')
            ->where('lc.id', $id)
            ->where("lc.delete_time", 0)
            ->find()
            ->toArray();
		$res['picture_url'] = config('setting.upload_prefix').$res['picture'];
		$res['create_time_f'] = date("Y-m-d H:i:s",$res['create_time']);
		
        return $res;
    }

}