<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends Base_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('goods/Model_goods');
    }

    /**
     * 店铺首页
     */
    public function index(){
        
        $list = $this->Model_goods->lists([], 0, 5);
        $this->load->view('shop/show', ['list'=>$list]);
    }

    /**
     * 分类
     */
    public function category(){
        
        $this->load->view('shop/category');
    }


}
