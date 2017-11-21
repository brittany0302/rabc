<?php
namespace Admin\Controller;

class UsersController extends PublicController {
    /**
     * 会员添加页面
     */
    public function add(){
        $this->display();
    }
    /**
     * 添加会员处理程序
     */
    public function addAction(){

    }
    /**
     * 会员列表页面
     */
    public function goodsList(){
        $this->display();
    }
}