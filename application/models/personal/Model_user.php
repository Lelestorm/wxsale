<?php
/**
 * 系统用户相关
 */
class Model_user extends CI_Model{

    // 注册送金额
    const REGISTER_BONUS = 0;
    
    // redis db
    const REDIS_DB = 1;

    // 微信用户与系统用户关联
    const UNIONID = 'openid';
    
    public function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default',true);
    }
    
    /**
     * 通过openid 注册
     */
    public function reg_by_openid($openid, $wechat_id){

        $this->load->model('wechat/model_wxuser','wxuserinfo');
        $info = $this->wxuserinfo->get($openid,$wechat_id);
        if(empty($info)){
            log_message("Error","获取微信资料失败:".$openid);
            return false;
        }
        
        $data = [
                    'nickname' => $info['nickname'],
                    'headimg' => $info['headimgurl'],
                    'intime' => time(),
                    'balance' => self::REGISTER_BONUS,
                ];
        
        $this->db->trans_start();
        $this->db->insert('ds_user', $data);
        $uid = $this->db->insert_id();
        if(!$uid){
            log_message("Error", "Reg -- reg_by_openid -- fail：info--".var_export($info,true));
            return false;
        }
        $unionid = $info[self::UNIONID];
        $this->db->insert('wx_connect', ['unionid'=>$unionid,'uid'=>$uid]);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE){
            log_message('Error', '注册事务回滚:'.$uid.'||'.$openid);
            return false;
        }

        $redis = $this->conn->redis( self::REDIS_DB );
        $redis->setex('openid_uid_'.$openid, 86400*30, $uid);
        $redis->close();
        return $uid;
    }
    
    /**
     * 更新用户信息
     */
    public function update($uid, $data){
        return $this->db->update('ds_user', $data, ['uid'=>$uid]);
    }
    
    /**
     * 获取用户信息
     */
    public function info($uid,$cache=true){
        $redis = $this->conn->redis( self::REDIS_DB );
        if($cache){
            $info = $redis->get('ds_user:'.$uid);
            if($info){
                $redis->close();
                return json_decode($info,true);
            }
        }
        $info = $this->db->query("select * from ds_user where uid='{$uid}' limit 1")->row_array();
        if($info){
            $redis = $this->conn->redis( self::REDIS_DB );
            $redis->setex('ds_user:'.$uid, 86400*3, json_encode($info));
            $redis->close();
        }
        return $info;
    }
    
    /**
     * 根据openid获取用户uid
     */
    public function get_uid_by_openid($openid){
        $redis = $this->conn->redis( self::REDIS_DB );
        $uid = $redis->get('openid_uid_'.$openid);
        if(! $uid){
            $query = $this->db->query("select b.uid from wx_user as a inner join wx_connect as b on a.".self::UNIONID."=b.unionid where a.openid = ? limit 1", [$openid]);
            $row = $query->row_array();
            $query->free_result();
            if(!empty($row)){
                $redis->setex('openid_uid_'.$openid, 86400*10, $row['uid']);
                $uid = $row['uid'];
            }
        }
        $redis->close();
        return $uid;
    }
}