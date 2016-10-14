<?php
/**
 * 微信API交互调度派发
 */
class Model_dispatch extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    /**
     * 派发入口
     */
    public function reception(){
        $this->load->model('wechat/model_input','wxinput');
        $this->load->model('wechat/model_output','wxoutput');
        if($this->wxinput->is_empty()){
            $this->wxoutput->blank();
        }

        $msg_type = $this->wxinput->get('MsgType');
        if($msg_type=='event'){
            $this->load->model('wechat/model_event','wxevent');
            $this->wxevent->handle();
        }else if(in_array($msg_type, ['text','image','voice','video','shortvideo','location','link'])){
            $this->load->model('wechat/model_msg','wxmsg');
            $this->wxmsg->handle();
        }
    }
}