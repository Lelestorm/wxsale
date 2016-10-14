<?php
/**
 * 微信消息
 */
class Model_msg extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $MsgType = $this->wxinput->get('MsgType');
        if(method_exists($this, $MsgType)){
            call_user_func(array($this, $MsgType));
        }else{
            $this->wxoutput->transfer();
        }
    }

    /**
     * 文本消息
     */
    public function text(){
        $content = $this->wxinput->get('Content');
        if($content=='clear'){
            // 清楚缓存
        }else if($content=='wechat_id'){
            $this->wxoutput->text($this->wxinput->wechat_id);
        }else if($content=='openid'){
            $this->wxoutput->text($this->wxinput->openid);
        }else if($content=='uid'){
            $this->load->model('personal/model_user');
            $uid = $this->model_user->get_uid_by_openid($this->wxinput->openid);
            $this->wxoutput->text("Your account uid is ".$uid);
        }else{
            $this->load->model('wechat/model_wxuser');
            $info = $this->model_wxuser->get($this->wxinput->openid,$this->wxinput->wechat_id);
            $this->wxoutput->text("亲爱 ".$info['nickname']."：终于等到你，做完美女人。");
        }
    }

    /**
     * 语音
     */
    public function voice(){
        die('success');
    }
    
    /**
     * 视频
     */
    public function video(){
        die('success');
    }
    
    /**
     * 小视频
     */
    public function shortvideo(){
        die('success');
    }
    
    /**
     * 地理位置
     */
    public function location(){
        die('success');
    }
    
    /**
     * 链接消息
     */
    public function link(){
        die('success');
    }
}