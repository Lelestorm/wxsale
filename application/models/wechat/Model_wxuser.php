<?php
/**
 * 微信用户相关
 */
class Model_wxuser extends CI_Model{

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * 写入数据库
     */
    private function _save2db($data){
        if(!empty($data['id'])){
            $where = 'id='.$data['id'];
            $sql = $this->db->update_string('wx_user', $data, $where);
            $this->db->simple_query($sql);
        }else{
            $this->db->insert('wx_user',$data);
            $data['id'] = $this->db->insert_id();
        }
        return $data;
    }
        
    /**
     * 获取微信用户信息
     */
    public function get($openid, $wechat_id, $api=true){
        $query = $this->db->query("select * from wx_user where openid = ? and wechat_id = ? limit 1", [$openid, $wechat_id]);
        $row = $query->row_array();
        $query->free_result();
        if(! $row){
           if($api){
                return $this->update($openid, $wechat_id);
            }
            return false;
        }
        return $row;
    }
    
    /**
     * API获取微信用户信息
     */
    public function get_wxuser_api($openid, $wechat_id, $two=false){
        if(! $openid || ! $wechat_id){
            log_message('error', 'openid: '.$openid." ||wechat_id: ".$wechat_id);
            return false; 
        }
        $this->load->model('wechat/model_util','wxutil');
        if( $two ){
            $this->wxutil->token($wechat_id, true, false);
        }else{
            $token = $this->wxutil->token($wechat_id);
        }
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$token.'&openid='.$openid.'&lang=zh_CN';
        $this->load->library('util');
        $rps = $this->util->http_request($url);
        if(empty($rps)){
            log_message('Error', "获取用户信息失败:".$openid.'|| wechat_id：'.$wechat_id.'||'.$url);
        }else if(isset($rps['errcode']) && $rps['errcode']>0){
            // token 过期
            if(! $two && $rps['errcode']==40001){
                log_message('Error', "get_wxuser_api-----clear token");
                return $this->get_wxuser_api($openid, $wechat_id, true);
            }
            log_message('Error', "获取用户信息失败:".$openid.'|| wechat_id：'.$wechat_id.'||'.json_encode($rps));
        }else{
            if(! isset($rps['unionid'])){
                $rps['unionid'] = '';
            }
            return $rps;
        }
        return false;
    }

    /**
     * 更新微信用户信息
     */
    public function update($openid, $wechat_id){
        $info = $this->get_wxuser_api($openid, $wechat_id);
        if(! $info){
            return false;
        }
        $data = [
                    'wechat_id' => $wechat_id,
                    'openid' => $openid,
                    'nickname' => $info['nickname'],
                    'sex' => $info['sex'],
                    'city' => $info['city'],
                    'province' => $info['province'],
                    'headimgurl' => $info['headimgurl'],
                    'subscribe_time' => $info['subscribe_time'],
                    'uptime' => time(),
                    'unionid' => $info['unionid'],
                    'subscribe' => 1
                ];
        // 获取数据库微信用户信息
        $row = $this->get($openid, $wechat_id, false);
        if(!empty($row['id'])){
            $data['id'] = $row['id'];
        }else{
            $data['id'] = 0;
        }
        // 保存
        $wxuser = $this->_save2db($data);
        if($wxuser['id']){
            $this->load->model('personal/model_user');
            $uid = $this->model_user->get_uid_by_openid($openid);
            if($uid>0){
                $this->db->simple_query("update ds_user set headimg='{$data['headimgurl']}',nickname='{$data['nickname']}' where uid={$uid} limit 1");
            }
        }
        return $wxuser;
    }

    /**
     * 网页授权：拉取用户信息(需scope为 snsapi_userinfo)
     */
    public function get_oauth2_api($openid, $access_token){
        $info = $this->util->http_request('https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN');
        if(empty($info['openid'])){
            return false;
        }else{
            if(! isset($info['unionid'])){
                $info['unionid'] = '';
            }
            return $info;
        }
    }
    
    /**
     * 网页授权：(更新微信用户信息)
     */
    public function save_oauth2_wxuser($info){
        if($info['nickname']===NULL){
            return false;
        }
        $data = [
                'wechat_id' => $info['wechat_id'],
                'openid' => $info['openid'],
                'nickname' => $info['nickname'],
                'sex' => $info['sex'],
                'city' => $info['city'],
                'province' => $info['province'],
                'headimgurl' => $info['headimgurl'],
                'subscribe_time' => time(),
                'unionid' => '',
                'subscribe' => 1
            ];
        if(isset($info['unionid'])){
            $data['unionid'] = $info['unionid'];
        }
        return $this->_save2db($data);
    }
    
    /**
     * 是否关注公众号
     */
    public function is_sub($openid,$wechat_id){
        $info = $this->get($openid, $wechat_id);
        if($info && $info['subscribe']==1){
            return true;
        }
        return false;
    }
}