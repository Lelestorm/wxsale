<?php
class Util{
    /**
     * 通过curl方式获取远程的数据
     * @param string $url @notice--查询字符串--请求远程地址 GET方式请求的数据必须把相关数据封装成数组
     * @param array  $params 请求时所需要的参数
     * @param string $method 请求的方法
     * @return 根据$json array string
     */
    function http_request($url, $params=array(), $method='GET', $json=TRUE, $timeout=6){
        $ch = curl_init();
        $method = strtoupper($method);
        if($method == 'GET'){
            if(!empty($params)){
                $url .= '?'.http_build_query($params,'','&');
            }
            curl_setopt($ch, CURLOPT_URL, $url);
        }else if($method == 'POST'){
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($ch, CURLOPT_SSLVERSION, 1);

        $content = curl_exec($ch);
        $info = curl_getinfo($ch);
        if(!empty($info) && ! $info['http_code']){
            log_message('Error', $url.'||'.$method.'||'.var_export($params,true).'||'.var_export($info,true).'||'.curl_error($ch).'||'.curl_errno($ch).'||'.$_SERVER['REQUEST_URI']);
        }
        curl_close($ch);
        if($json){
            return json_decode($content, true);
        }else{
            return $content;
        }
    }
}