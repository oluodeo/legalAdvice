<?php

namespace app\common\controller;

use app\common\model\Admins;
use think\Db;
use think\facade\Session;
use think\Request;

class AdminBase extends Base
{
	/**
     * 初始化处理数据
     * Base constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initAuth();
    }

	/**
     * 进行权限控制
     */
    public function initAuth()
    {
        $authFlag = false;
        $hasAdminID = Session::has('adminID');
        if (!$hasAdminID) {
            $message = "You are offline,please logon again!";
        } else {
            $adminID = Session::get('adminID');
            //TODO 判断当前用户是否具有此操作权限
            $checkAuth = $this->checkAdminAuth($adminID);
            $authFlag = $checkAuth;
            $message = $checkAuth ? "权限正常" : "Sorry,You don't have permission!";
        }
        if (!$authFlag) {
            return showMsg($authFlag, $message);
        };
    }
	
	/**
     * 检查权限
     * @param int $adminID
     * @return bool
     */
    public function checkAdminAuth($adminID = 0)
    {
        $action = trim(strtolower(request()->action()));
        $request_url = trim(strtolower($_SERVER["REQUEST_URI"]));
        $authUrl = explode($action, $request_url)[0] . $action;// /admin/menu/index
        //对待检测的URL 忽略大小写
        $adminModel = new Admins();
        $checkTag = $adminModel->checkAdminAuth($adminID, $authUrl);
        return $checkTag;
    }
}