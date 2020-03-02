<?php

namespace app\common\model;

use think\Db;
use think\Model;

class Lawyer extends BaseModel
{
    /**
     * 获取律师信息
     * @return array
     */
    public function getLawyerDetails()
    {
        $res = $this
            ->field('*')
            ->find()
            ->toArray();
		$res['image_url'] = config('setting.upload_prefix').$res['image'];
		
        return $res;
    }

}