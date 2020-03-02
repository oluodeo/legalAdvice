<?php

namespace app\admin\controller;
	
use app\common\model\NavMenus;
use app\common\model\AdminRoles;
use app\common\controller\AdminBase;
use think\facade\Session;
use think\Request;
	
class AdminRole extends AdminBase
{
	protected $model;
    protected $menuModel;
    protected $page_limit;

    public function __construct()
    {
        parent::__construct();
        $this->model = new AdminRoles();
        $this->menuModel = new NavMenus();
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
        $list = $this->model->getRolesForPage($this->page_limit, $search);
		$page = $list->render();
        return view('index',
            [
                'roles' => $list,
                'search' => $search,
                'page' => $page
            ]);
    }
	
	/**
     * 添加新角色
     * @param Request $request
     * @return \think\response\View|void
     */
    public function add(Request $request)
    {
        if ($request->isPost()) {
            $input = $request->post();
            $opRes = $this->model->addRole($input);
            return showMsg($opRes['tag'], $opRes['message']);
        } else {
            //TODO 获取所有可以分配的权限菜单
            $viewMenus = $this->menuModel->getNavMenus();
            return view('add', [
                'menus' => $viewMenus,
            ]);
        }
    }
	
	/**
	 * 修改角色信息
     * @param Request $request
     * @param $id 标识ID
     * @return \think\response\View|void
     */
    public function edit(Request $request, $id)
    {
        $roleData = $this->model->getRoleData($id);
        if ($request->isPost()) {
            $input = $request->param();
            $opRes = $this->model->editRole($id, $input);
            return showMsg($opRes['tag'], $opRes['message']);
        } else {
            //TODO 获取所有可以分配的权限菜单
            $viewMenus = $this->menuModel->getNavMenus();
            $arrMenuSelf = explode('|', $roleData['nav_menu_ids']);
            return view('edit', [
                'role' => $roleData,
                'menus' => $viewMenus,
                'menuSelf' => $arrMenuSelf,
            ]);
        }
    }
	
}