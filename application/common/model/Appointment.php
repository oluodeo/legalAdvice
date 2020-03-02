<?php

namespace app\common\model;

use think\Db;
use think\Model;
use app\common\validate\Appointment;

class Appointment extends BaseModel
{
	
	protected $validate;
	
	public function __construct($data = [])
    {
        parent::__construct($data);
        $this->validate = new Appointment();
    }
	
    /**
     * 添加用户预约
     * @param $uid
     * @param $input
     * @return int|void
     */
    public function addAppointment($uid,$input)
    {
		$addData = [
            'uid' => $uid,
			'cate_id'=>isset($input['casecate']) ? $input['casecate'] : '',
			'linkman'=>isset($input['linkman']) ? $input['linkman'] : '',
			'mobile'=>isset($input['mobile']) ? $input['mobile'] : '',
			'apptime'=>isset($input['apptime']) ? $input['apptime'] : '',
            'content' => isset($input['content']) ? $input['content'] : '',
            'create_time' => time(),
		];
		
		$validateRes = $this->validateApi($this->validate, $addData);
        if ($validateRes['tag']) {
            $tag = $this->insert($addData);
            $validateRes['tag'] = $tag;
            $validateRes['message'] = $tag ? '预约提交成功' : '预约提交失败';
        }
		
        return $validateRes;
    }

	/**
     * 分页获取用户预约列表
     * @param $uid
     * @param $page
     * @param $size
     * @return array
     */
	public function getAppointmentListForPage($uid,$page=1,$size=10)
    {
		$res = $this
            ->field('*')
            ->order('id', 'desc')
            ->paginate($size,true,['page'=>$page]);
					
		foreach ($res as $key => $v) {
            $res[$key]['apptime'] = explode(' ',$v['apptime']);
            $res[$key]['create_time_f'] = date('Y-m-d H:i:s',$v['create_time']);
			
        }
		return $res;
    }
	
	/**
     * 取消用户预约
     * @param $input
     * @return array
     */
	public function cancelAppointment($input)
    {
		$saveData = [
			'cancel_reason'=>isset($input['reason']) ? $input['reason'] : '',
            'update_time' => time(),
            'status' => 2,
		];
		$tag = $this
			->where('id', $input['id'])
			->update($saveData);
		$res['tag'] = $tag;
		$res['message'] = $tag ? '取消成功' : '取消失败';
		return $res;
    }
}