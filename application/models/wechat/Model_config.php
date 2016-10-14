<?php
/**
 * 微信配置相关
 */
class Model_config extends CI_Model{

    /**
     * 微信配置
     */
    private $_wechat_configs = [
                    'gh_e057ca419378' => [
                            'original' => 'gh_e057ca419378',
                            'name' => '芸莎养生馆',
                            'appid' => 'wx5c9adbc46cb8c6a5',
                            'appsecret' => '4d66a2dda87ac6ecbde09299b54083d7',
                            'mch_id' =>	'',
                        ]
                ];
    
    /**
     * 微信账号信息
     */
    public function info($wechat_id){
        if(array_key_exists($wechat_id, $this->_wechat_configs)){
            return $this->_wechat_configs[$wechat_id];
        }
        return false;
    }
    
    /**
     * 范围公众号appid配置
     */
    public function appid(){
        return array_combine(array_column($this->_wechat_configs,'appid'),array_keys($this->_wechat_configs));
    }
	
    /**
     * 获取公众号名称
     */
    public function  wechat_name($wechat_id){
        if(array_key_exists($wechat_id, $this->_wechat_configs)){
            return $this->_wechat_configs[$wechat_id]['name'];
        }
        return false;
    }
}