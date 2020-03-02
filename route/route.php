<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * 前台页面
 */
Route::get('/','index/index');

/**
 * API
 */
//Token，为了参数安全选择POST传参
Route::post('api/:version/token/user', 'api/:version.Token/getToken');
Route::post('api/:version/token/verify', 'api/:version.Token/verifyToken');

/**
 * 首页
 */
//导航栏轮播图
Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');
//用户
Route::get('api/:version/users', 'api/:version.User/getUserList');
//推荐案例
Route::get('api/:version/cases/recommend', 'api/:version.LawCase/getRecommendCaseList');

//获取公司信息
Route::get('api/:version/company', 'api/:version.Company/getCompanyIntro');

//获取律师信息
Route::get('api/:version/lawyer', 'api/:version.Lawyer/getLawyerDetails');

//获取咨询类型
Route::get('api/:version/casecate', 'api/:version.Casecate/getCasecate');

//案例列表
Route::get('api/:version/cases/list', 'api/:version.LawCase/getCaseList');
//案例介绍
Route::get('api/:version/cases/:id', 'api/:version.LawCase/getCaseByID');

//在线预约
Route::post('api/:version/appointment', 'api/:version.Appointment/makeAppointment');
//预约列表
Route::get('api/:version/appointment/list', 'api/:version.Appointment/getAppointmentList');
//取消预约
Route::get('api/:version/appointment/cancel', 'api/:version.Appointment/cancelAppointment');

/**
 * 后台页面
 */

//工具类
Route::post('util/upload/img_file','util/upload/img_file');

//登录
Route::get('admin/login/index','admin/Login/index');
Route::any('admin/login/logout','admin/Login/logout');
Route::post('admin/login/ajaxLogin','admin/Login/ajaxLogin');
Route::post('admin/login/ajaxCheckLoginStatus','admin/Login/ajaxCheckLoginStatus');

//后台首页
Route::get('admins','admin/Index/index');
Route::get('admin/index/index','admin/Index/index');
Route::get('admin/index/home','admin/Index/home');
Route::any('admin/index/admin/:id','admin/Index/admin');

//菜单管理
Route::get('admin/menu/index','admin/NavMenu/index');
Route::any('admin/menu/add','admin/NavMenu/add');
Route::any('admin/menu/edit','admin/NavMenu/edit');
Route::any('admin/menu/auth','admin/NavMenu/auth');

//人员管理
Route::get('admin/admin/index','admin/Admin/index');
Route::any('admin/admin/add','admin/Admin/add');
Route::any('admin/admin/edit','admin/Admin/edit');

//角色管理
Route::get('admin/role/index','admin/AdminRole/index');
Route::any('admin/role/add','admin/AdminRole/add');
Route::any('admin/role/edit','admin/AdminRole/edit');

