<?php

namespace app\common\model;

use think\Db;
use think\Model;

class CaseCate extends BaseModel
{
   /**
     * 获取案件类型
     * @return array
     */
	public function getCasecateList()
    {
		$data = $this
            ->field("id,cate_name")
            ->where('delete_time', 0)
            ->select()
            ->toArray();
        return $data;
    }

}