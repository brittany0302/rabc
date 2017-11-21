<?php
namespace Admin\Controller;

class GoodsController extends PublicController {
    /**
     * 商品添加页面
     */
    public function add(){
        $this->display();
    }
    /**
     * 添加商品处理程序
     */
    public function addAction(){

    }
    /**
     * 商品列表页面
     */
    public function goodsList(){
        $this->display();
    }
}