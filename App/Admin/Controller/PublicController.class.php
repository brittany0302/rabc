<?php
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller{
    public function __construct()
    {
        //先实现父类的构造方法
        parent::__construct();
        //只要不是登录页面和登录处理程序,进入后台的所有页面都要判断是否登录
        if(ACTION_NAME != 'login' && ACTION_NAME != 'loginAction'){
            //判断用户是否登录
            if(!session('admin_id')){
                redirect(U('Index/login'));
            }
        }
        //获取当前的控制器和方法名,判断是否在权限内
        $admin_id = session('admin_id');
        if($admin_id>1){
            //非超级管理员
            $role_auth_ac = M('Manager')->join('think_role on think_manager.mg_role_id=think_role.role_id')->where(['mg_id'=>$admin_id])->getField('role_auth_ac');
            $temp = explode(',',$role_auth_ac);
            $temp[] = 'Index-fourZeroFour';
            $temp[] = 'Index-index';
            $temp[] = 'Index-top';
            $temp[] = 'Index-left';
            $temp[] = 'Index-main';
            $temp[] = 'Index-swich';
            $temp[] = 'Index-bottom';
            $temp[] = 'Index-login';
            $temp[] = 'Index-loginAction';
            $temp[] = 'Index-loginOut';
            $ca = CONTROLLER_NAME.'-'.ACTION_NAME;
            if(!in_array($ca,$temp)){
                redirect(U('Index/fourZeroFour'));
            }
        }
    }

}