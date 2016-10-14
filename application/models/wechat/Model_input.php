<?php
/**
 * 微信API数据接收
 */
class Model_input extends CI_Model{
    
    public $wechat_id = '';
    public $openid = '';
    
    private $data = [];
    
    public function __construct(){
        parent::__construct();
        $this->_set_data();
    }
    
    /**
     * 获取数据
     */
    private function _set_data(){
        $stream = file_get_contents("php://input");
        if(!$stream){
            return false;
        }

        $xml = simplexml_load_string($stream,'SimpleXMLElement',LIBXML_NOCDATA);
        $data = json_decode(json_encode($xml),true);
        $this->data =  $data;
        $this->wechat_id = $this->data['ToUserName'];
        $this->openid = $this->data['FromUserName'];
        
        if(! in_array($this->get('Event'), array('TEMPLATESENDJOBFINISH', 'LOCATION', 'VIEW'))){
            $this->logging->write_log("weixin",$stream);
        }
    }
    
    /**
     * 获取参数值
     */
    public function get($key){
        if(!empty($this->data[$key])){
            return $this->data[$key];
        }else{
            return '';
        }
    }

    public function data(){
        return $this->data;
    }

    /**
     * 是否空值
     */
    public function is_empty(){
        return empty($this->data);
    }
}