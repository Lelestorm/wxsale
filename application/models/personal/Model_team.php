<?php
/**
 * 好友关系
 */
class Model_team extends CI_Model{

   
    private $_table = 'ds_user_team';
    
    private $_redis_db = 101;
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * 获取用户关系信息
     */
    public function info($uid){
        $query = $this->db->from($this->_table)->where(['uid'=>(int)$uid])->limit(1)->get();
        $rs = $query->row_array();
        $query->free_result();
        return $rs;
    }

    /**
     * 绑定好友关系
     * @param int $uid
     * @param int $lv1_id 一级代理uid
     */
    public function bind_members($uid, $lv1_id){
        $db = $this->load->database('default',true);
        $user = $this->info($uid);
        if ( $user ) {  // 已绑定用户关系
            return -1;
        } 
        $lv1_user = $this->info($lv1_id);
        $data = array(
            'uid' => (int)$uid,
            'lv1_id' => (int)$lv1_id,  // 上级代理
            'intime' => time()
        );
        if($lv1_user){
            $data['lv2_id'] = $lv1_user['lv1_id']; // 上二层代理
            $data['lv3_id'] = $lv1_user['lv2_id']; // 上三层代理
        }
        if($db->insert($this->_table, $data)){
            if (! empty($data['lv3_id'])) {
                $this->add_team_nums('lv3', $data['lv3_id']); 
            }
            if ( ! empty($data['lv2_id']) ) {
                $this->add_team_nums('lv2', $data['lv2_id']);
            }
            $this->add_team_nums('lv1', $lv1_id);
        }   
        return true;
    }
    
    /**
     * 写入（redis）新增粉丝数
     */
    public function add_team_nums($lv, $uid){
        $redis = $this->conn->redis( $this->_redis_db );
        $redis->incr($lv . 'newNumber' . $uid);
        $redis->close();
    }
    
    /**
     * 清空（redis）新增粉丝数
     */
    public function deleteNewNums($lv, $uid){
        $redis = $this->conn->redis( $this->_redis_db );
        if ( $redis->get($lv . 'newNumber' . $uid) ) {
            $redis->del($lv . 'newNumber' . $uid);
        }
        $redis->close();
    }
}

