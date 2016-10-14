<?php
/**
 * 发送客服消息
 */
class Model_send extends CI_Model{

    public function __construct(){
        parent::__construct();
    }

    /**
     * 发送文本消息
     */
    public function text($text,$openid,$wechat_id,$kf=''){
        $data = array(
                        "touser" => $openid,
                        "msgtype" => "text",
                        "text" => [
                                "content" => $text
                            ]
                    );
        if($kf){
            $data['customservice'] = array('kf_account'=>$kf);
        }
        return $this->util->http_request("http://192.168.1.42:8816/send?wechat_id=".$wechat_id,array('body'=>json_encode($data,JSON_UNESCAPED_UNICODE)),'POST',false);
    }

    /**
     * 发送图片
     */
    public function image($media_id,$openid,$wechat_id){
        $data = array(
                    "touser" => $openid,
                    "msgtype" => "image",
                    "image" => [
                                "media_id" => $media_id
                            ]
                );
        return $this->util->http_request("http://192.168.1.42:8816/send?wechat_id=".$wechat_id,array('body'=>json_encode($data,JSON_UNESCAPED_UNICODE)),'POST',false);
    }

    /**
     * 发送图文（文章）
     */
    public function news($article,$openid,$wechat_id){
        $data = array(
                "touser" => $openid,
                "msgtype" => "news",
                "news" => [
                        "articles" => $article
                    ]
            );
        return $this->util->http_request("http://192.168.1.42:8816/send?wechat_id=".$wechat_id,array('body'=>json_encode($data,JSON_UNESCAPED_UNICODE)),'POST',false);
    }
    
    /**
     * 异步任务
     */
    public function async_task($name,$data){
        $task = array(
                'name' => $name,
                'data' => $data
            );
        return $this->http_request('http://192.168.1.43:8826/asyncTask',$task,'POST',false);
    }
}