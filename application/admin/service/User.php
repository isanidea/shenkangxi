<?php
namespace app\admin\service;
use think\Db;
//后台用户数据
class User{
	
	function is_login(){
		$user = session('user_auth');
	    if (empty($user)) {
	        return 0;
	    } else {
	        return $user;
	    }
	}
	
	function user_info($key,$uid=UID){
		if($this->is_login()){
			
			$user=Db::name("admin")->where('admin_id',$uid)->find();
			
			return $user[$key];
			
		}
	}

	function logout(){
		session('user_auth',null);
	}
}
?>