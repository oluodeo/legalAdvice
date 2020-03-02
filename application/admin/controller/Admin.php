<?php

namespace app\admin\controller;
	
use app\common\model\Admins;
use app\common\model\AdminRoles;
use app\common\controller\AdminBase;
use think\facade\Session;
use think\Request;
	
class Admin extends AdminBase
{
	protected $adminModel;
    protected $page_limit;

    public function __construct()
    {
        parent::__construct();
        $this->adminModel = new Admins();
        $this->arModel = new AdminRoles();
        $this->page_limit = config('setting.ADMIN_PAGE_SIZE');
    }
	
	/**
     * 列表页
     * @param Request $request
     * @return \think\response\View
     */
    public function index(Request $request)
    {
        $search = $request->param('str_search');
        $list = $this->adminModel->getAdminsForPage($this->page_limit, $search);
		$page = $list->render();
        return view('index',
            [
                'admins' => $list,
                'search' => $search,
                'page' => $page
            ]);
    }
	
	/**
     * 添加新管理员
     * @param Request $request
     * @return \think\response\View|void
     */
    public function add(Request $request)
    {
        $adminRoles = $this->arModel->getRoles();
        if ($request->isPost()) {
            $input = $request->post();
            $opRes = $tag = $this->adminModel->addAdmin($input);
            return showMsg($opRes['tag'], $opRes['message']);
        } else {
            return view('add', [
                'adminRoles' => $adminRoles
            ]);
        }
    }
	
	/**
     * @param Request $request
     * @param $id 标识ID
     * @return \think\response\View|void
     */
    public function edit(Request $request, $id)
    {
        $adminRoles = $this->arModel->getRoles();
        $adminData = $this->adminModel->getAdminData($id);
        if ($request->isPost()) {
            $input = $request->param();
            
            $opRes = $this->adminModel->editAdmin($id, $input);
            return showMsg($opRes['tag'], $opRes['message']);
        } else {
            return view('edit', [
                'admin' => $adminData,
                'adminRoles' => $adminRoles
            ]);
        }
    }
	
}