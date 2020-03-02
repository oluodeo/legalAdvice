<?php

namespace app\common\model;

use think\Db;
use think\Model;
use think\Session;
use app\common\validate\AdminRole;

class AdminRoles extends BaseModel
{
    protected $validate;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->validate = new AdminRole();
    }

	/**
     * 获取角色列表
     * @return mixed
     */
    public function getRoles()
    {
        $res = $this
            ->where('status', 1)
            ->select();
        return $res;
    }
	
	/**
     * 分页获取角色列表
     * @return mixed
     */
    public function getRolesForPage($limit, $search = null)
    {
        $res = $this
            ->whereLike('role_name', '%' . $search . '%')
            ->order('id')
            ->paginate($limit,false,['query'=>request()->param()]);

        return $res;
    }
	
	/**
     * 根据ID获取角色数据
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     */
    public function getRoleData($id)
    {
        $res = $this
            ->field('*')
            ->where('id', $id)
            ->find();
        return $res;
    }
	
	/**
     * 添加新角色
     * @param $input
     * @return mixed
     */
    public function addRole($input)
    {
        $role_name = isset($input['role_name']) ? $input['role_name'] : '';
        $checkSameTag = $this->chkSameRoleName($role_name);
        if ($checkSameTag) {
            $validateRes['tag'] = 0;
            $validateRes['message'] = '此角色名已被占用，请换一个！';
        } else {
            $addData = [
                'role_name' => $role_name,
                'nav_menu_ids' => $input['nav_menu_ids'] ? $input['nav_menu_ids'] : '',
                'create_time' => time(),
                'status' => intval($input['status']),
            ];
            $tokenData = ['__token__' => isset($input['__token__']) ? $input['__token__'] : '',];
            $validateRes = $this->validate($this->validate, $addData, $tokenData);
            if ($validateRes['tag']) {
                $tag = $this->insert($addData);
                $validateRes['tag'] = $tag;
                $validateRes['message'] = $tag ? '角色添加成功' : '角色添加失败';
            }
        }
        return $validateRes;
    }
	
	/**
     * 修改角色数据
     * @param $id
     * @param $input
     * @return void|static
     */
    public function editRole($id, $input)
    {
        $opTag = isset($input['tag']) ? $input['tag'] : 'edit';
        if ($opTag == 'del') {
			$saveData = [
				'status' => -1,
				'delete_time' => time(),
			];
            $tag = $this
                ->where('id', $id)
                ->update($saveData);
            $validateRes['tag'] = $tag;
            $validateRes['message'] = $tag ? '删除成功' : '删除失败！';
        } else {
            $sameTag = $this->chkSameRoleName($input['role_name'], $id);
            if ($sameTag) {
                $validateRes['tag'] = 0;
                $validateRes['message'] = '此昵称已被占用，请换一个！';
            } else {
                $saveData = [
                    'role_name' => $input['role_name'],
                    'status' => $input['status'],
                    'nav_menu_ids' => $input['nav_menu_ids'],
                ];
                $tokenData = ['__token__' => isset($input['__token__']) ? $input['__token__'] : '',];
                $validateRes = $this->validate($this->validate, $saveData, $tokenData);
                if ($validateRes['tag']) {
                    $tag = $this
                        ->where('id', $id)
                        ->update($saveData);
                    $validateRes['message'] = $tag ? '修改成功' : '修改失败';
                }
            }
        }
        return $validateRes;
    }
	
	/**
     * 判断当前数据库中是否有重名的角色名
     * @param $role_name
     * @param int $id
     * @return mixed
     */
    public function chkSameRoleName($role_name, $id = 0)
    {
        $tag = $this
            ->field('role_name')
            ->where('role_name', $role_name)
            ->where('id', '<>', $id)
            ->count();
        return $tag;
    }
}
