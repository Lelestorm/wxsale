<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Show extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 商品展示页
     */
    public function index(){
        
        $this->load->view('goods/show');
    }
    
}
