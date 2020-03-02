<?php

namespace app\api\controller\v1;

use app\common\controller\ApiBase as BaseController;
use app\common\model\Appointment as AppointmentModel;
use app\common\model\User as UserModel;
use app\common\service\Token as TokenService;
use app\exception\SubmitException;
use app\exception\UserException;
use app\exception\SuccessMessage;
use think\Exception;
use think\Request;



class Appointment extends BaseController{
	
	public function __construct()
    {
		$this->appointmentM = new AppointmentModel();
		$this->userM = new UserModel();
        $this->api_page_limit = config('setting.API_PAGE_SIZE');
    }
	
	/**
     * 在线预约
     */
    public function makeAppointment(Request $request)
    {
        $uid = TokenService::getCurrentUid();
        $user = $this->userM->getByUid($uid);
        if(!$user){
            throw new UserException();
        }
//		$data = input('post.');
		$input = $request->param();
		$opRes = $this->appointmentM->addAppointment($uid,$input);
        if(!$opRes['tag']){
			throw new SubmitException([
               'msg' => $opRes['message']
            ]);
		}
		return json(new SuccessMessage(),201);
    }
	
	/**
     * 分页获取用户预约列表
     * @param int $page
     * @return array
     */
	public function getAppointmentList($page=1)
	{
		$uid = TokenService::getCurrentUid();
        $user = $this->userM->getByUid($uid);
        if(!$user){
            throw new UserException();
        }
		$appointmentList = $this->appointmentM->getAppointmentListForPage($uid,$page,$this->api_page_limit);
		if($appointmentList->isEmpty()){
            return json([
                'current_page' => $appointmentList->currentPage(),
                'data' => []
            ]);
		}
		return json($appointmentList);

	}
	
	/**
     * 取消用户预约
     */
    public function cancelAppointment(Request $request)
    {
		$input = $request->param();
		$opRes = $this->appointmentM->cancelAppointment($input);
        if(!$opRes['tag']){
			throw new SubmitException([
               'msg' => $opRes['message']
            ]);
		}
		return json(new SuccessMessage(),201);
    }
	
}