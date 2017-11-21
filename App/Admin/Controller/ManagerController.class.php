<?php
namespace Admin\Controller;

class ManagerController extends PublicController{
    //管理员添加页面
    public function add(){
        //获取角色列表
        $rows = M('Role')->field('role_id,role_name')->select();
        $this->assign('rows',$rows);
        $this->display();
    }
    //管理员添加处理程序
    public function addAction(){
        $manager = M('Manager');
        $mg_name = I('post.mg_name');
        $mg_pwd = I('post.mg_pwd');
        $mg_time = time();
        $mg_role_id = I('post.mg_role_id');
        //compact():将变量合并成数组,变量名为数组的键,变量值为数组的值  需保证变量名和键名一致
        $data = compact('mg_name','mg_pwd','mg_time','mg_role_id');
        $id = $manager->add($data);
        if($id){
            $this->success('管理员添加成功',U('managerList'));
        }else{
            $this->error('管理员添加失败');
        }
    }
    //管理员列表页
    public function managerList(){
        $manager = M('Manager');
        $rows = $manager->field('think_manager.*,think_role.role_name')->join('left join think_role on think_manager.mg_role_id = think_role.role_id')->order('think_manager.mg_id desc')->select();
        $this->assign('rows',$rows);
        $this->display();
    }
}