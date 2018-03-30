<?php
namespace app\admin\controller;

use app\common\controller\Base;
use think\Db;
class Login extends Base
{

    function login(){

//        $pws = "123456";
//        $stal = getRandChar(6);
//        echo $stal."=";
//        echo getMd5Pas($pws,$stal);
//        exit();

        $user = app_service("admin","user");
        if( request()->isPost() ){

            $data=input('post.');
            if(empty($data['account'])){
                $this->error('用户名不能为空！');
            }elseif(empty($data['passwd'])){
                $this->error('密码不能为空！');
            }
            $user_info=Db::name('admin')->where("account", $data['account'])->find();


            //用户存在且可用
            if( $user_info && $user_info['status']==10 ){

                //验证密码
                if( getMd5Pas( $data['passwd'],$user_info["pas_salt"] ) == $user_info["passwd"]){

                    $auth = array(
                        "uid" => $user_info["id"],
                        "username" => $user_info["name"],
                        "isAdmin" => $user_info["isAdmin"],
                    );
                    session("user_auth",$auth);

                    $data = array();
                    $where['id']	=	$user_info['id'];
                    $data['last_login_time']	=	time();
                    $data['last_login_ip']	=	get_client_ip();
                    Db::name('admin')->where($where)->update($data);

                    $this->redirect('Index/index');
                }else{
                    return  $this->error('密码错误！');
                }
            }else{
                return  $this->error('用户不存在或被禁用！');
            }
        }else {

            if($user->is_login()){
                $this->redirect('Index/index');
            }else{
                return $this->fetch('public/login');
            }
        }
    }

}
