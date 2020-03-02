<?php

namespace app\admin\controller;
	
use app\common\model\NavMenus;
use app\common\model\Admins;
use think\facade\Session;
use think\Request;
	
class Index{
	protected $menuM;
    protected $adminM;
    protected $adminID;
	
	public function __construct()
    {
        $this->menuM = new NavMenus();
        $this->adminM = new Admins();
        $this->adminID = Session::get('adminID');
        if (!$this->adminID) {
            return redirect('admin/login/index');
        }
    }
	
	/**
     * 后台首页
     * @return \think\response\View
     */
    public function index()
    {
        //获取 登录的管理员有效期ID
        $menuList = $this->menuM->getNavMenusShow($this->adminID);
		
        if (!$this->adminID || !$menuList) {
            //TODO 页面跳转至登录页
            return redirect('admin/login/index');
        } else {
            $adminInfo = $this->adminM->getAdminData($this->adminID);
			
            $data = [
                'menus' => $menuList,
                'admin' => $adminInfo,
            ];
//			print_r($data);
            return view('index', $data);
        }
    }
	
	/**
     * 首页显示 可自定义呗
     * @return \think\response\View
     */
    public function home()
    {
        return view('home');
    }
	
	/**
     * 管理员个人信息
     * @param Request $request
     * @param $id
     * @return \think\response\View|void
     */
    public function admin(Request $request, $id)
    {
        if ($request->isGet()) {
            $adminData = $this->adminM->getAdminData($id);
            return view('admin', [
                'admin' => $adminData,
            ]);
        } else {
            //当前用户对个人账号的修改
            $input = $request->post();
            $opRes = $this->adminM->editCurrAdmin($id, $input, $this->adminID);
            return showMsg($opRes['tag'], $opRes['message']);
        }
    }
}