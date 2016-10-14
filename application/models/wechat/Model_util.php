<?php
/**
 * wechat Util
 */
class Model_Util extends CI_Model{
    
    private $_redis_db = 100;

    /**
     * 获取token
     */
    public function token($wechat_id, $onlytoken=true, $cache=true){
        if(! $wechat_id){
            return '';
        }
        $token = '';
        $this->load->library('conn');
        $redis = $this->conn->redis( $this->_redis_db );
        if($cache){
            $token_key = 'wechat_token:'.$wechat_id;
            if($onlytoken){
                $token = $redis->hGet($token_key, 'access_token');
            }else{
                $token = $redis->hGetAll($token_key);
            }
            if($token){
                $redis->close();
                return $token;
            }
        }
        // 微信配置
        $this->load->model('wechat/model_config','wxconfig');
        $info = $this->wxconfig->info($wechat_id);
        if(! $info){
            log_message('Error', 'When get wechat token. Wechat info was not found:'.$wechat_id);
        }else{
            // 调取接口
            $token = $this->util->http_request('https://api.weixin.qq.com/cgi-bin/token', array('grant_type'=>'client_credential','appid'=>$info['appid'],'secret'=>$info['appsecret']));
            if(empty($token) || isset($token['errcode'])){
                log_message('Error', 'Encounter the error when getting the wechat token:'.$wechat_id.'||'.json_encode($rps));
            }else{
                $token['expires_in'] += time() - 120;
                $token['expires_in'] = (string)$token['expires_in'];
                $redis->hMset($token_key, $token);
                $redis->expireAt($token_key, $token['expires_in']);
                $redis->close();
                if($onlytoken){
                    $token = $token['access_token'];
                }
            }
        }
        $redis->close();
        return $token;
    }
    



    /**
	 * get javascript ticket from weixin api
	 * @param unknown $wechat_id
	 * @return Ambigous <根据$json, boolean, mixed>
	 */
	private function _jsapi_ticket($wechat_id)
	{
		$cache_key = 'jsticket_'.$wechat_id;
		$redis = $this->conn->redis();
		$ticket = $redis->get($cache_key);
		if(!$ticket)
		{
			$token = $this->token($wechat_id);
			$this->load->library('util');
			$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token.'&type=jsapi';
			$data = $this->util->http_request($url);

			if($data['errcode']==0)
			{
				$ticket = $data['ticket'];
				$redis->setex($cache_key,7100,$ticket);
			}
		}
		$redis->close();

		return $ticket;

	}

	/**
	 * build javascript api information
	 * @param unknown $wechat_id
	 * @return multitype:NULL
	 */
	public function jsapi_info($wechat_id='')
	{
		if(!$wechat_id)
		{
			return false;
		}
		$this->load->model('wechat/model_config');
		$config = $this->model_config->info($wechat_id);
		if(empty($config))
		{
			return false;
		}
		$time = time();
		$js_info = array('AppId'=>$config['appid']);
		$js_info['ticket'] = $this->_jsapi_ticket($wechat_id);
		$js_info['timestamp'] = $time;
		$js_info['noncestr'] = 'asdfasdaxc23';
		$request_uri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

		$js_info['sign'] = sha1('jsapi_ticket='.$js_info['ticket'].'&noncestr='.$js_info['noncestr'].'&timestamp='.$time.'&url='.$request_uri);

		return $js_info;
	}

	public function qrcode($val,$type=0,$wechat_id='',$expire=2592000)
	{

		$this->load->library('util');
		if($type==1)
		{
			$json = '{"expire_seconds": , "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$val.'}}}';
		}else if($type==2){
			$json = '{"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "'.$val.'"}}}';
		}else{
			$json = '{"expire_seconds": '.$expire.', "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$val.'}}}';
		}

		$token = $this->token($wechat_id);
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$token;
		$rps = $this->util->http_request($url,$json,'POST');
		if(isset($rps['ticket']))
		{
			$url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.$rps['ticket'];
			return $url;
		}else{
			log_message("Error", "Encountered an error when making the ticket:".json_encode($rps));
		}
		return '';
	}


	public function get_card_id($openid,$wechat_id)
	{

		$this->load->library('conn');
		$redis = $this->conn->redis();
		$expires_at = time()+86400*3 - 300;
		$cache = $redis->get('wx_bcard:'.$openid);

		if($cache)
		{
			$redis->close();
			return $cache;
		}
		$key = 'wx_upload_times'.date("Ymd");
		if($redis->get($key)>50000)
		{
			$this->load->model('personal/model_user');
			$this->load->model('personal/model_center');
			$uid = $this->model_user->get_uid_by_openid($openid);
			$info = $this->model_center->info($uid);

			if(!$info['boss_time'])
			{
				return -2;
			}
			$redis->close();
			return -1;
		}

		$redis->close();

		$this->load->library('card');
		$this->load->model('personal/model_user');

		$uid = $this->model_user->get_uid_by_openid($openid);

		if(!$uid)
		{
			return -2;
		}
		if(!$uid)
		{
			$uid = $this->model_user->reg_by_openid($openid,$wechat_id);
		}

		$bcard = $this->card->get($uid,$wechat_id);
		if($bcard["type"]==-1)
		{
			return -2;
		}


		$fileFields = array(
				'file1.png' => array(
					'type' => $bcard['type'],
					'content' => $bcard['img']
				)
		);

		$this->load->model('wechat/model_util');
		$token = $this->model_util->token($wechat_id);
		$rps = $this->_req('https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$token.'&type=image',$fileFields,array());
		$data = json_decode($rps,true);

		if(isset($data['errcode']) && $data['errcode']>0)
		{
// 			log_message('Error', "上传临时二维码错误:".$rps.'||'.var_export($fileFields,true));
		    log_message('Error', "上传临时二维码错误:".$rps);
			return '';
		}else{
			$redis = $this->conn->redis();
			$key = 'wx_upload_times'.date("Ymd");
			$redis->incr($key);
			$redis->expireAt($key, time() + 86400);
			$redis->setex('wx_bcard:'.$openid,min(86400*3 - 300,$bcard['expires_at']-time()),$data['media_id']);
			$redis->close();
			return $data['media_id'];
		}


	}



	function redpacket($openid,$wechat_id,$money){

		$this->load->model('wechat/model_config');
		$config = $this->model_config->info($wechat_id);
		$billno = "redpacket".date("YmdHis").mt_rand(10000,90000);
		$params = array(
				"mch_billno"    =>  $billno,
				"mch_id"    =>  $config['mch_id'],
				"wxappid"   =>  $config['appid'],
				"nick_name" =>  "红包",
				"send_name" =>  "健康小华佗",
				"re_openid" =>  $openid,
				"total_amount"  =>  $money*100,
				"min_value" =>  $money*100,
				"max_value" =>  $money*100,
				"total_num" =>  1,
				"wishing"   =>  "0元创业",
				"client_ip" =>  "219.239.89.60",
				"act_name"  =>  "佣金提现",
				"remark"    =>  "佣金提现",
				"logo_imgurl"   =>  "http://m.yfenqi.com/pub/images/logo.jpg",
				"nonce_str" =>  time()
		);

		ksort($params);
		$post_xml = '<xml>';
		$sign_str = '';
		foreach($params as $k=>$v)
		{
			if(empty($v))
			{
				continue;

			}
			$sign_str .= $k.'='.$v.'&';
			$post_xml .= "\t\n<".$k.'>'.$v.'</'.$k.'>';
		}
		$sign_str .= 'key=9bXuwYsCOdABUtA0qDp2YtEF7jWN85eW';
		$post_xml .= "\n<sign>".md5($sign_str).'</sign>';
		$post_xml .= "</xml>";

		$raw = $this->_wxpayreq("https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack",$post_xml,$wechat_id);
		$xml = simplexml_load_string($raw,'SimpleXMLElement',LIBXML_NOCDATA);
		$rps = json_decode(json_encode($xml),true);
		$this->logging->write_log('wx_redpacket',$post_xml.'||'.var_export($rps,true));
		return $rps;
	}

	function _wxpayreq($url,$params,$wechat_id)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');

		curl_setopt($ch,CURLOPT_SSLCERT,'/data/wwwroot/saleadmin.120.net/static/WxPayConfig/'.$wechat_id.'/'.$wechat_id.'_apiclient_cert.pem');
		curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLKEY,'/data/wwwroot/saleadmin.120.net/static/WxPayConfig/'.$wechat_id.'/'.$wechat_id.'_apiclient_key.pem');

		$content = curl_exec($ch);
		curl_close($ch);

		return $content;
	}



	private function _req($url,$fileFields,$postFields)
	{
		// form field separator
		$delimiter = '-------------' . uniqid();
		// file upload fields: name => array(type=>'mime/type',content=>'raw data')



		$data = '';

		// populate normal fields first (simpler)
		foreach ($postFields as $name => $content) {
			$data .= "--" . $delimiter . "\r\n";
			$data .= 'Content-Disposition: form-data; name="' . $name . '"';
			// note: double endline
			$data .= "\r\n\r\n";
		}
		// populate file fields
		foreach ($fileFields as $name => $file) {
			$data .= "--" . $delimiter . "\r\n";
			// "filename" attribute is not essential; server-side scripts may use it
			$data .= 'Content-Disposition: form-data; name="' . $name . '";' .
					' filename="' . $name . '"' . "\r\n";
			// this is, again, informative only; good practice to include though
			$data .= 'Content-Type: ' . $file['type'] . "\r\n";
			// this endline must be here to indicate end of headers
			$data .= "\r\n";
			// the file itself (note: there's no encoding of any kind)
			$data .= $file['content'] . "\r\n";
		}
		// last delimiter
		$data .= "--" . $delimiter . "--\r\n";

		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_POST, true);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER,TRUE);
		curl_setopt($handle, CURLOPT_HTTPHEADER , array(
		'Content-Type: multipart/form-data; boundary=' . $delimiter,
		'Content-Length: ' . strlen($data)));
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
		$content = curl_exec($handle);

		curl_close($handle);
		return $content;
	}
};