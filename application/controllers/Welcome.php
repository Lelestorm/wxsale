<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Base_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 首页
     */
    public function index(){
        
        $this->load->view('index');
    }
    
    /**
     * 我们
     */
    public function team(){
        
        $this->load->view('about/team');
    }
    
    /**
     * 一周年
     */
    public function oneyear(){
        
        $this->load->view('event/1year');
    }
}
