<?php
/**
 * 链接服务
 */
class Conn{
    
    /**
     * 链接redis服务
     * @param $db 
     *      100：微信信息相关
     */
     public function redis($db=0) {
        $redis = new redis ();
        $result = $redis->connect ( '192.168.1.43', 6379 );
        if ($result) {
            $redis->auth ( 'AKeiT8D8dl1L3eCs' );
        } else {
            log_message ( 'error', "connect local redis error!" );
        }
        $redis->select($db);
        return $redis;
    }
}