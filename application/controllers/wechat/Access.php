<?php
/* 
 * 微信接入相关
 */
class Access extends Base_Controller{
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 生成跳转链接
     */
    private function _jump_url($url,$wechat_id){
        return 'http://'.DOMAIN_NAME.'/wechat/access/forward?to='.urlencode($url).'&wechat_id='.$wechat_id;
    }
    
    /**
     * 微信服务接入认证
     */
    private function _check_signature(){
        $signature = $this->input->get("signature");
        $timestamp = $this->input->get("timestamp");
        $nonce = $this->input->get("nonce");

        $token = 'sale120net';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        return sha1( $tmpStr ) == $signature;
    }
        
    /**
     * 微信交互入口
     */
    public function gateway(){
        if($this->input->get('echostr')){   // 验证服务器
            if($this->_check_signature()){
                echo $this->input->get('echostr');
            }
        }else{      // 微信交互
            $this->load->model('wechat/model_dispatch');
            $this->model_dispatch->reception();
        }
    }
    
    /**
     * 微信访问入口（网页授权）
     * to：要跳转的目标页面
     * wechat_id：微信号原始id
     * code：用户同意授权，获取code
     */
    public function forward(){
        $to = $this->input->get('to');
        $code = $this->input->get('code');
        $wechat_id = $this->input->get('wechat_id');
        
        // 已登录，跳转目标页面 || 登录
        if($this->input->cookie('openid') && $this->input->cookie('wechat_id')==$wechat_id && true){
            header("location:".$to); exit();
        }
        
        // 获取微信号信息
        $this->load->model('wechat/model_config','wxconfig');
        $wxinfo = $this->wxconfig->info($wechat_id);
        if(! $wxinfo){
            show_error('wechat_id参数错误');
        }
        
        if(! $code){  // 用户授权，获取code
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.$wxinfo['appid'].'&redirect_uri='.urlencode('http://'.DOMAIN_NAME.'/wechat/access/forward?to='.urlencode($to).'&wechat_id='.$wechat_id).'&response_type=code&scope=snsapi_userinfo&state='.time().'#wechat_redirect';
            header("location:".$url); exit();
        }else{
             // 通过code换取网页授权access_token
            $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.$wxinfo['appid'].'&secret='.$wxinfo['appsecret'].'&code='.$code.'&grant_type=authorization_code';
            $auth = $this->util->http_request($url);
            if(isset($auth['openid'])){
                $this->load->model('wechat/model_wxuser');
                // 是否已注册过微信用户信息
                $info = $this->model_wxuser->get($auth['openid'], $wechat_id, false);
                if(! $info){
                    // 接口获取微信用户信息
                    $info = $this->model_wxuser->get_oauth2_api($auth['openid'], $auth['access_token']);
                    if($info){
                        // 保存微信用户信息
                        $info['wechat_id'] = $wechat_id;
                        $this->model_userinfo->save_oauth2_wxuser($info);
                    }  else {
                        show_error('授权失败');exit();
                    }
                }
                // 获取微信用户对应的系统用户
                $this->load->model('personal/model_user','model_user');
                $uid = $this->model_user->get_uid_by_openid($info['openid']);
                // 不存在系统用户，则注册
                if(! $uid){
                    $uid = $this->model_user->reg_by_openid($info['openid'],$wechat_id);
                    // 来源通道
                    $parent_id = $this->digit->decode($this->input->cookie('channel'));
                    $this->logging->write_log("scan",$info['openid']."||uid:".$uid."||pid:".$parent_id);
                    if($parent_id && $parent_id != $uid){
                        // 三级分销
                        $this->load->model('personal/model_team');
                        $code = $this->model_team->bind_members($uid,$parent_id);
                        if($code){
                            // 新成员加入通知 （go）
                        }
                    }
                }
                
                $this->load->library('encrypt');
                $this->input->set_cookie('wechat_id', $wechat_id, 365*86400);
                $this->input->set_cookie('openid', $this->encrypt->encode($info['openid']), 365*86400);
                $this->input->set_cookie('uid', $this->encrypt->encode($uid), 365*86400);
                set_cookie('channel', '', -1);
                header("location:".$to);
            }else{
                log_message('Error', "encountered an error when getting the openid:".$wechat_id.'||'.json_encode($auth));
                show_error("授权自动登陆失败",500);
            }
        }
    }

    /**
     * 获取token
     */
    public function token(){
        
    }
    
    /**
     * 生成微信菜单
     */
    public function menu(){
        $wechat_id = $this->input->get('wechat_id');
        $menu = [
                    [
                        'name' => '健康小店',
                        'type' => 'view',
                        'url' => $this->_jump_url('http://wx.iysspa.com/shop/show', $wechat_id),
                        'sub_button' => [],
                    ],
                    [
                        'name' => '预约',
                        'type' => 'view',
                        'url' => $this->_jump_url('http://wx.iysspa.com/welcome/team', $wechat_id),
                        'sub_button' => [],
                    ],
                    [
                        'name' => '活动',
                        'sub_button' => [
                                [
                                    'type' => 'view',
                                    'name' => '周年庆典',
                                    'url' => $this->_jump_url('http://wx.iysspa.com/welcome/oneyear', $wechat_id)
                                ],
                            ]
                    ],
                ];
        $json_str = json_encode(array('button'=>$menu),JSON_UNESCAPED_UNICODE);
        $this->load->model('wechat/model_util');
        $token = $this->model_util->token($wechat_id);
        $this->load->library('util');
        $rps = $this->util->http_request('https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$token,$json_str,'POST');
        echo '<pre/>';
        echo $json_str;
        echo '<hr>';
        print_r($rps);
        exit();
    }
    
    /**
     * 获取openid
     */
    public function openid(){
        
    }
    
}

