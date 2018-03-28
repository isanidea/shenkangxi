<?php
// 应用公共文件

function p($var){
    dump($var);
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


