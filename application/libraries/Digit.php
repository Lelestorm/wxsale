<?php
/**
 * 加密
 */
class Digit{

    private $len_mask = 'd6a78fe94c352b1';
    
    /*  $spool是这么生成的，如果数位不够用，
         可以继续向$spool中添加键值对，但是不要修改之前的键值对，
        不然就无法解密了
        $res = array_merge(range('a','z'),range(0,9));
        $spool = array();
        for($i=0;$i<16;$i++){
        shuffle($res);
        array_push($spool,substr(implode('',$res),0,10));
        }
        $spool = var_export($spool,true);print $spool;exit;
        #   位数标记码是这么生成的，千万不要修改
        $len_mask = array_merge(range(1,9),range('a','f'));
        shuffle($len_mask);
        print implode('',$len_mask);exit;
        */
    public $spool = array (
                0 => 'm047gl8foj',
                1 => 'wg3h0ca2nl',
                2 => 'j6oyw8kclh',
                3 => 'tods62c4fi',
                4 => 'c9f5aeb62v',
                5 => 'kim7pltyaw',
                6 => 'pkneclgasz',
                7 => '3kf46cxi2h',
                8 => 'qo83ezx524',
                9 => 'ivbondxc47',
                10 => 's8pw43ukhf',
                11 => '09xzmjru63',
                12 => 'wbyn6hai3d',
                13 => 'q7v9264bjl',
                14 => 'gh6jxkdwbt',
                15 => 'kpo0zt1h6a',
            );

    /**
     * 加密
     * @param string $str
     * @return string
     */
    public function encode($str = ''){
        
        $str = $str.'';
        if(empty($str)){
            return '';
        }
        $total_len = 16;
        $len = strlen($str);
        if($len+1>$total_len){
            return '';
        }
        $tmp = '';
        for($i=0;$i<$len;$i++){
            $tmp .= $this->spool[$i][$str[$i]];
        }
        $last_char = $str[$i-1];
        for($i;$i<$total_len-1;$i++){
            $tmp .= $this->spool[$last_char][$i%10];
        }
        return $tmp.$this->len_mask[$len-1];
    }
	
    /**
     * 解密
     * @param unknown_type $str
     * @return string|Ambigous <string, number>
     */
    public function decode($str = ''){
        $str = $str.'';
        if(empty($str)){ return ''; }
        $total_len = 16;
        $len = strlen($str);
        if($len!=$total_len){ return ''; }
        $tmp = '';
        $count = strpos($this->len_mask,substr($str,15,1))+1;
        for($i=0;$i<$count;$i++){
            $tmp .= strpos($this->spool[$i],$str[$i]);
        }
        return $tmp;
    }
}