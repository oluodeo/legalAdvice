<?php

namespace app\admin\controller;
	
use app\common\model\NavMenus;
use app\common\controller\AdminBase;
use think\facade\Session;
use think\Request;
	
class NavMenu extends AdminBase
{
	protected $menuModel;
    protected $page_limit;

    public function __construct()
    {
        parent::__construct();
        $this->menuModel = new NavMenus();
        $this->page_limit = config('setting.ADMIN_PAGE_SIZE');
    }
	
	/**
     * 菜单导航列表页
     * @param Request $request
     * @return \think\response\View
     */
    public function index(Request $request)
    {
        $search = $request->param('str_search');
        $list = $this->menuModel->getNavMenusForPage($this->page_limit, $search);
		$page = $list->render();
        return view('index',
            [
                'menus' => $list,
                'search' => $search,
                'page' => $page
            ]);
    }
	
	/**
     * 增加新导航标题 功能
     * @param Request $request
     * @return \think\response\View|void
     */
    public function add(Request $request)
    {
        $rootMenus = $this->menuModel->getNavMenus();
        if ($request->isPost()) {
            $input = $request->param();
            $opRes = $this->menuModel->addNavMenu($input);
            return showMsg($opRes['tag'], $opRes['message']);
        } else {
            return view('add', [
                'rootMenus' => $rootMenus,
            ]);
        }
    }
	
	/**
     * 编辑导航菜单数据
     * @param Request $request
     * @param $id 菜单ID
     * @return \think\response\View|void
     */
    public function edit(Request $request, $id)
    {
        $rootMenus = $this->menuModel->getNavMenus();
        if ($id == 0) $id = $request->param('id');
        $menuData = $this->menuModel->getNavMenuByID($id);
        if ($request->isPost()) {
            //TODO 修改对应的菜单
            $input = $request->post();
//			
//			$res = serialize($input);
//			return showMsg(1, $res."--".$id);
//			
            $opRes = $this->menuModel->editNavMenu($input['id'], $input);
            return showMsg($opRes['tag'], $opRes['message']);
        } else {
            return view('edit', [
                'rootMenus' => $rootMenus,
                'menuData' => $menuData
            ]);
        }
    }
	
	/**
     * 赋予权限
     * @param Request $request
     * @param $id 菜单ID
     * @return \think\response\View|void
     */
    public function auth(Request $request, $id)
    {
		if ($id == 0) $id = $request->param('id');
        $authMenus = $this->menuModel->getAuthChildNavMenus($id);
        if ($request->isPost()) {
            $input = $request->param();
			
//			$res = serialize($input);
//			return showMsg(1, $res."--".$id);
			
            $opRes = $this->menuModel->addNavMenu($input, $id);
            return showMsg($opRes['tag'], $opRes['message']);
        } else {
            return view('auth', [
                'authMenus' => $authMenus,
                'parent_id' => $id
            ]);
        }
    }
}