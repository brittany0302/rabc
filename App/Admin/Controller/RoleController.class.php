<?php
namespace Admin\Controller;

class RoleController extends PublicController {
    /**
     * 添加角色页面
     */
    public function add(){
        $this->display();
    }
    /**
     * 添加角色处理程序
     */
    public function addAction(){
        $role = M('Role');
        $data['role_name'] = I('post.role_name');
        $id = $role->add($data);
        if($id){
            //页面跳转
            $this->success('角色添加成功','roleList');
            //重定向
            //$this->redirect('roleList', '', 5, '角色添加成功...');
        }else{
            $this->error('角色添加失败');
        }
    }
    /**
     * 角色列表页面
     */
    public function roleList(){
        $role = M('Role');
        $rows = $role->order('role_id desc')->select();
        $this->assign('rows',$rows);
        $this->display();
    }
    /**
     * 为角色分配权限
     */
    public function roleAuth(){
        $role = M('Role');
        $role_id = I('get.role_id');
        $where['role_id'] = $role_id;
        //通过角色id获取角色的所有权限id的字符串
        $role_auth_ids = $role->where($where)->getField('role_auth_ids');
        $row_auth_ids_arr = explode(',',$role_auth_ids);
        $this->assign('row_auth_ids_arr',$row_auth_ids_arr);//在模板中判断权限id是否在这个数组中,在的话就勾选上
        //通过角色id获取角色名称
        $role_name = $role->where($where)->getField('role_name');
        $this->assign('role_name',$role_name);
        //读取权限表的所有权限
        $auth = M('Auth');
        $arr = $auth->order('auth_path')->select();
        foreach ($arr as $k=>$v){
            $rows[$k] = $v;
            //根据level来实现分层效果
            $rows[$k]['p'] = str_repeat('----',$v['auth_level']);
        }
        $this->assign('rows',$rows);
        $this->display();
    }
    /**
     * 分配权限处理程序
     */
    public function editAuth(){
        $role = M('Role');
        $ch = I('post.ch');//接收到所有勾选的权限id组成的数组
        $role_id = I('post.role_id');//接收隐藏域传过来的角色id
        $str = '';
        foreach ($ch as $v){
            //根据权限id查询权限表的记录,取出auth_c和auth_a
            $arr = M('Auth')->find($v);
            //过滤掉没有auth_c和auth_a的数据
            if(!empty($arr['auth_c']) && !empty($arr['auth_a'])){
                $str .= $arr['auth_c'].'-'.$arr['auth_a'].',';
            }
        }
        $role_auth_ac = $str;//将此角色的所有权限的控制器和方法合并成字符串
        $role_auth_ids = implode(',',$ch);//将此角色的所有权限Id数组合并成字符串
        $data['role_auth_ids'] = $role_auth_ids;
        $data['role_auth_ac'] = $role_auth_ac;
        $where['role_id'] = $role_id;
        $affect = $role->where($where)->save($data);
        if($affect){
            //$this->success('权限编辑成功','roleList');
            $this->success('权限编辑成功',U('roleList'));
        }else{
            $this->error('权限编辑失败');
        }
    }
}