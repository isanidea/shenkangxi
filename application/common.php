<?php
// 应用公共文件
require_once 'helper.php';

function p($data){
    if(is_bool($data)){
        $show_data = $data ? 'ture': 'false';
    }elseif(is_null($data)){
        $show_data = 'null';
    }else{
        $show_data = print_r($data,true);
    }
    echo $show_data;

}

//日志
/**
 * @param $str
 */
function tplog($str)
{
    $log_path = RUNTIME_PATH.'log'.DS;
    if (!file_exists($log_path)){
        mkdir($log_path, 0777, true);
    }
    $path = $log_path. DS . date('Ymd',time()).'.log';
    $str = '['.date('Y-m-d H:i:s').'] '.(string)$str . "\r\n\r\n";
    file_put_contents($path, $str, FILE_APPEND);
}


/**
 * 判断是否是微信浏览器访问
 * @return boolean [description]
 */
function is_weixin(){
    if ( strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') !== false ) {
        return true;
    }
    return false;
}

//盐值生成6位数的随机值
function getRandChar($maxNum){
    $authnum = '';
    $ychar="0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z";
    $list=explode(",",$ychar);
    for($i=0;$i<$maxNum;$i++){
        $randnum=rand(0,61); // 10+26;
        $authnum.=$list[$randnum];
    }
    return $authnum;
}

function getMd5Pas($pwd,$salt){
    //1 封装密码
    $pwd1 = md5($pwd);
    //封装密码加盐值
    $pwd2 = md5($pwd1.$salt);
    $pwd3 = md5($pwd2."jkn*/");
    return $pwd3;
}

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装）
 * @return mixed
 */
function get_client_ip($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


