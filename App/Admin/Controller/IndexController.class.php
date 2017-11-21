<?php
namespace Admin\Controller;
class IndexController extends PublicController {
    public function fourZeroFour(){
        $this->display('Index/404');
    }
    public function index(){
        $this->display();
    }
    public function top(){
        $this->display();
    }
    public function bottom(){
        $this->display();
    }
    public function left(){
        $admin_id = session('admin_id');
        //查管理员名称,角色
        $row = M('Manager')->join('left join think_role as r on think_manager.mg_role_id=r.role_id')->where(['mg_id'=>$admin_id])->find();
        $this->assign('row',$row);
        if($admin_id>1){
            //不是超级管理员
            //根据管理员Id获取对应的角色,根据角色获取对应的权限,根据权限显示页面
            //获取当前管理员的权限 根节点 子节点
            //只可能拿到一条记录,所以左/右/内连接都可以,默认内连接
            $role_auth_ids = M('Manager')->join('think_role on think_manager.mg_role_id=think_role.role_id')->where(['mg_id'=>$admin_id])->getField('role_auth_ids');
            $wh['auth_id'] = array('in',$role_auth_ids);
            $arr = M('Auth')->where($wh)->select();
            foreach ($arr as $v){
                if($v['auth_pid']>0){
                    $auths[] = $v;
                }else{
                    $authp[] = $v;
                }
            }
        }else{
            //是超级管理员,拥有一切权限
            //查询所有根节点
            $authp = M('Auth')->where(['auth_pid'=>0])->select();
            //查询所有子节点
            $where['auth_pid'] = ['neq',0];
            $auths = M('Auth')->where($where)->select();
        }
        $this->assign('authp',$authp);
        $this->assign('auths',$auths);

        $this->display();
    }
    public function main(){
        $admin_id = session('admin_id');
        //查管理员名称,角色
        $row = M('Manager')->join('left join think_role as r on think_manager.mg_role_id=r.role_id')->where(['mg_id'=>$admin_id])->find();
        $this->assign('row',$row);
        $this->display();
    }
    public function swich(){
        $this->display();
    }
    //登录页面
    public function login(){
        $this->display();
    }
    //登录处理程序
    public function loginAction(){
        $mg_name = trim(I('post.mg_name'));
        $mg_pwd = I('post.mg_pwd');
        $wh = compact('mg_name','mg_pwd');
        $row = M('Manager')->where($wh)->find();
        if($row){
            //用户名,密码正确
            session('admin_id',$row['mg_id']);
            $this->success("登录成功,欢迎你,{$row['mg_name']} orz",U('Index/index'));
        }else{
            //用户名或者密码不正确
            $this->error('用户名或密码不正确,登录失败');
        }
    }
    /**
     * 退出登录处理程序
     */
    public function loginOut(){
        session('admin_id');
        redirect(U('Index/login'));
    }
}