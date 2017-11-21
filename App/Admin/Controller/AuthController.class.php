<?php
namespace Admin\Controller;
use Think\Model;

class AuthController extends PublicController {
    /**
     * 权限添加页面
     */
    public function add(){
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
     * 添加权限处理程序
     */
    public function addAction(){
        $auth = M('Auth');
        $auth_name = I('post.auth_name');
        $auth_pid = I('post.auth_pid');
        $data['auth_name'] = $auth_name;
        $data['auth_pid'] = $auth_pid;
        if($auth_pid){
            //不是根节点,可以接收到控制器和方法,level为1
            $auth_c = I('post.auth_c');
            $auth_a = I('post.auth_a');
            $data['auth_c'] = $auth_c;
            $data['auth_a'] = $auth_a;
            $data['auth_level'] = 1;
        }else{
            //是根节点,不用填写控制器和方法,level为0
            $data['auth_level'] = 0;
        }
        $id = $auth->add($data);
        if($id){
            //修改auth_path
            $where['auth_id'] = $id;
            if($auth_pid){
                //不是根节点,auth_path为父类id-自己id
                $da['auth_path'] = $auth_pid.'-'.$id;
            }else{
                //是根节点,auth_path为自己id
                $da['auth_path'] = $id;
            }
            $affect_rows = $auth->where($where)->save($da);
            if($affect_rows){
                //插入成功,修改成功
                $this->success('权限添加成功','authList');
            }else{
                //插入成功,修改失败
                $auth->delete($id);
                $this->error('权限添加失败');
            }
        }else{
            $this->error('权限添加失败');
        }
    }
    /**
     * 权限列表页面
     */
    public function authList(){
        $model = new Model();
        $sql = "select a2.auth_id,a2.auth_name as auth_name2,a1.auth_name as auth_name1,a2.auth_c,a2.auth_a,a2.auth_path,a2.auth_level from think_auth as a1 right join think_auth as a2 on a1.auth_id=a2.auth_pid order by a2.auth_path";
        $arr = $model->query($sql);
        foreach ($arr as $k=>$v){
            $rows[$k] = $v;
            //根据level来实现分层效果
            $rows[$k]['p'] = str_repeat('----',$v['auth_level']);
        }
        $this->assign('rows',$rows);
        $this->display();
    }
}