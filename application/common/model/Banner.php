<?php

namespace app\common\model;

use think\Db;

class Banner extends BaseModel
{
    /**
     * 获取Banner列表
     * @return array
     */
	public function getBannerList()
    {
		$data = $this
            ->field("*")
            ->where('delete_time', 0)
            ->select()
            ->toArray();
        return $data;
    }
	
    /**
     * 获取所有的Banner子项
     * @param $bid
     * @return array
     */
    public static function getBannerItemByBid($bid)
    {
        $res = Db::name('banner_item')
            ->field('*')
            ->where('banner_id', $bid)
            ->select();
		foreach ($res as $key => $v) {
            $res[$key]['image_url'] = config('setting.img_prefix').$v['image'];
        }
        return $res;
    }
}