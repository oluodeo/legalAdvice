<?php

namespace app\admin\controller;
	
use app\common\model\NavMenus;
use app\common\model\Admins;
use think\facade\Session;
use think\Request;
	
class Login{
	protected $menuM;
    protected $adminM;
	
	public function __construct()
    {
        $this->menuM = new NavMenus();
        $this->adminM = new Admins();
    }
	
	/**
     * 登录页
     * @return \think\response\View
     */
    public function index()
    {
        if (Session::has('adminID')) {
            return redirect('admin/index/index');
        } else {
            return view('index');
        }
    }
	
	/**
     * ajax 进行管理员的登录操作
     * @param Request $request
     */
    public function ajaxLogin(Request $request)
    {
        if ($request->isPost()) {
            $input = $request->post();
            $tagRes = $this->adminM->adminLogin($input);
            if ($tagRes['tag']) {
                Session::set('adminID', $tagRes['tag']);
            }
            return showMsg($tagRes['tag'], $tagRes['message']);
        } else {
            return showMsg(0, 'sorry,您的请求不合法！');
        }
    }
	
	/**
     * ajax 检查登录状态
     * @param Request $request
     */
    public function ajaxCheckLoginStatus(Request $request)
    {
        if ($request->isPost()) {
            $adminID = Session::get('adminID');
            $nav_menu_id = $request->param('nav_menu_id');
            //TODO 判断当前菜单是否属于他的权限内
            $checkTag = $this->menuM->checkNavMenuMan($nav_menu_id, $adminID);
            if ($adminID && $checkTag) {
                return showMsg(1, '正在登录状态');
            } else {
                return showMsg(0, '未在登录状态');
            }
        } else {
            return showMsg(0, 'sorry,您的请求不合法！');
        }
    }
	
	/**
     * 登出账号
     * @return \think\response\Redirect
     */
    public function logout()
    {
        if (Session::has('adminID')) {
            Session::delete('adminID');
        }
        return redirect('admin/login/index');
    }
}