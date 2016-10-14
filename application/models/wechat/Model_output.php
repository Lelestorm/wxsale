<?php
/**
 * 微信API被动回复消息
 */
class Model_output extends CI_Model{
	
    /**
     * 终止
     */
    public function blank(){
        exit();
    }
	
    /**
     * 文本
     */
    public function text($text){
        $text = '<xml>
        <ToUserName><![CDATA['.$this->wxinput->openid.']]></ToUserName>
        <FromUserName><![CDATA['.$this->wxinput->wechat_id.']]></FromUserName>
        <CreateTime>'.time().'</CreateTime>
        <MsgType><![CDATA[text]]></MsgType>
        <Content><![CDATA['.$text.']]></Content>
        </xml>';
        die($text);
    }
	
    /**
     * 图片
     */
    public function image($media_id){
        $text = '<xml>
        <ToUserName><![CDATA['.$this->wxinput->openid.']]></ToUserName>
        <FromUserName><![CDATA['.$this->wxinput->wechat_id.']]></FromUserName>
        <CreateTime>'.time().'</CreateTime>
        <MsgType><![CDATA[image]]></MsgType>
        <Image>
        <MediaId><![CDATA['.$media_id.']]></MediaId>
        </Image>
        </xml>';
        die($text);
    }
    
    public function transfer(){
        $xml = '<xml>
        <ToUserName><![CDATA['.$this->wxinput->openid.']]></ToUserName>
        <FromUserName><![CDATA['.$this->wxinput->wechat_id.']]></FromUserName>
        <CreateTime>'.time().'</CreateTime>
        <MsgType><![CDATA[transfer_customer_service]]></MsgType>
        </xml>';
        die($xml);
    }
}