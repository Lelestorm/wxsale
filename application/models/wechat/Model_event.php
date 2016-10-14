<?php
/**
 * 微信事件
 */
class Model_event extends CI_Model{

    public function __construct(){}

    public function handle(){
        $event = $this->wxinput->get('Event');
        if(method_exists($this, $event)){
            call_user_func(array($this, $event));
        }else{
            $this->wxoutput->blank();
        }
    }

    /***
     * 关注事件
     */
    public function subscribe(){
        // wxuser
        $this->load->model('wechat/model_wxuser', 'wxuser');
        if( ! $this->wxuser->update($this->wxinput->openid, $this->wxinput->wechat_id) ){
            die();
        }
        // app user
        $this->load->model('personal/model_user');
        $uid = $this->model_user->get_uid_by_openid($this->wxinput->openid);
        $new = false;
        if(! $uid){
            $new = true;
            $uid = $this->model_user->reg_by_openid($this->wxinput->openid, $this->wxinput->wechat_id);
        }
        // log
        $this->logging->write_log("scan", $this->wxinput->openid."||uid:".$uid."||new:".$new);
        // 扫描带参数二维码事件
        if( stripos($this->wxinput->get('EventKey'), 'qrscene_') !== false ){
            $parent = str_replace('qrscene_', '', $this->wxinput->get('EventKey'));
            if($new){
                $this->load->model('personal/model_team');
                $code = $this->model_team->bind_members($uid, $parent);
                if( $code ){
                    // 新成员加入通知 （go）
                }else{
                    $this->logging->write_log("scan",$this->wxinput->openid."||uid:".$uid."||code错误:".$code);
                }
            }
        }
        die();
    }

    /**
     * 取消关注
     */
    public function unsubscribe(){
        $this->load->database();
        $sql = $this->db->update_string('wx_user', ['subscribe'=>0], "openid='".$this->wxinput->openid."'");
        $this->db->simple_query($sql);
        $this->logging->write_log('unsubscribe', $this->wxinput->openid.'||'.$this->wxinput->wechat_id);
        exit();
    }

    /**
     * 点击
     */
    public function click(){
        $event_key = $this->wxinput->get('EventKey');
        if($event_key=='BCARD'){
            // 二维码
        }else if($event_key=='CUSTOME' && false){
            // 客服
        }
    }

    /**
     * 上报地理位置
     */
    public function location(){
        die();
    }
}
