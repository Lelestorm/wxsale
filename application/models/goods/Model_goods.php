<?php
/**
 * 商品
 */
class Model_goods extends CI_Model{
    
    const TABLE = 'ds_goods';
    // redis db
    const REDIS_DB = 2;
    
    public function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    /**
     * info
     */
    public function info($id){
        return $this->db->from(self::TABLE)->where(['id'=>$id])->limit(1)->get()->row_array();
    }
    
    /**
     * list
     */
    public function lists($where, $offset=0, $limit=5, $select='*'){
        $this->db->select($select)->from(self::TABLE);
        if(! empty($where)){
            $this->db->where($where);
        }
        return $this->db->limit($limit, $offset)->get()->result_array();
    }
    
    /**
     * count
     */
    public function count($where){
        $this->db->select("count(*) as num")->from(self::TABLE);
        if(! empty($where)){
            $this->db->where($where);
        }
        if( ($row = $this->db->limit(1)->get()->row()) ){
            return $row->num;
        }
        return 0;
    }
}
