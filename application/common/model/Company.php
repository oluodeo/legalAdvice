<?php

namespace app\common\model;

use think\Db;
use think\Model;

class Company extends BaseModel
{
    /**
     * 获取公司信息
     * @return array
     */
    public function getCompanyIntro()
    {
        $res = $this
            ->field('*')
            ->find()
            ->toArray();
		$res['logo_url'] = config('setting.upload_prefix').$res['logo'];
		
        return $res;
    }

}