<?php
define('DOMAIN_NAME', 'wx.iysspa.com');
define("TIME", time());

/* 
 * 应用项目统一基类
 */
class Base_Controller extends CI_Controller{

    // 访客唯一标识
    public $uuid;
    // 是否登录
    public $is_login = false;
    public $uid;
    public $wechat_id;
    public $opeind;
    public $unionid;
    // 来源通道
    public $channel;
    
    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
        $this->get_uuid();
        $this->get_openid();
        $this->get_wechat_id();
        $this->get_channel();
        $this->is_login();
    }
    
    /**
     * is login
     */
    public function is_login(){
        $uid = $this->input->cookie('uid');
        if( $uid ){
            $this->uid = (int) $this->encrypt->decode($uid);
            if($this->uid > 0){
                $this->is_login = true;
            }
        }
    }

    /**
     * 微信登录
     */
    public function wx_auth(){
        $wechat_id = $this->input->get('wechat_id');
        if(!$wechat_id){
            $wechat_id = $this->wechat_id ?: 'gh_e057ca419378';
        }
        $uri = 'http://'.$this->input->server('HTTP_HOST').$this->input->server('REQUEST_URI');
        $url = 'http://'.DOMAIN_NAME.'/wechat/access/forward?to='.urlencode($uri).'&wechat_id='.$wechat_id;
        header("location:".$url);
        exit();
    }
        
    /**
     * 访客唯一标识
     */
    public function get_uuid(){
        if(! $this->uuid){
            if(! ($this->uuid = $this->input->cookie('uuid'))){
                $this->uuid = uniqid();
                set_cookie('uuid',$this->uuid, 86400*30);
            }
        }
    }
    
    /**
     * 获取openid
     */
    public function get_openid(){
        $this->openid = $this->input->cookie('openid');
        if($this->openid){
            $this->openid = $this->encrypt->decode($this->openid);
        }
    }
    
    /**
     * 获取wechat_id
     */
    public function get_wechat_id(){
        $this->wechat_id = $this->input->cookie('wechat_id');
        $wechat_id = $this->input->get('wechat_id');
        if($wechat_id && $wechat_id != $this->wechat_id && ! $this->openid){
            $this->wechat_id = $wechat_id;
            set_cookie('wechat_id',$this->wechat_id, 86400*60);
        }
    }
    
    /**
     * get channel
     */
    public function get_channel(){
        $this->channel = $this->input->get('channel');
        if($this->channel){
            set_cookie('channel',$this->channel, 86400*60);
        }else{
            $this->channel = $this->input->cookie('channel');
        }
    }
    
    /**
     * 格式化Json输出，并终止程序
     */
    public function output_json($code, $msg, $data=[]){
        exit(json_encode(['code'=>$code,'msg'=>$msg,'data'=>$data]));
    }
}

