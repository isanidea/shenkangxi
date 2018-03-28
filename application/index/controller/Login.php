<?php

namespace app\index\controller;

use app\common\controller\Base;
use think\Db;
use think\Request;
use tool\Json;
use think\Session;
use tool\TransmitSms;
//use think\Cache;

class Login extends Base
{


    public function index()
    {
        return $this->fetch();
    }

    public function login()
    {
        $render_json = new Json();
        $d = input('param.');
        $user = Db::name('user')->where('username', $d['username'])->find();
        if (empty($user)) {
            $render_json->status = 1;
            $render_json->msg = "用户不存在,去请推荐人注册";
            $render_json->toJson();
        }
        if(getMd5Pas($d['password'],$user['salt']) == $user['password']){
            $array = array(
                'id'=>$user['id'],
                'username'=>$user['username'],
                'last_login_time'=>time(),
            );
            $data =Db::name('user')->update($array);
            if($data){
                Session::set('userInfo',$array);
//                Cache::store('redis')->set('userInfo',$array,3600*24*7);
            }
        }else{
            $render_json->status=2;
            $render_json->msg ="密码不正确，请重新登录";
            $render_json->toJson();
        }
        $render_json->status =0;
        $render_json->msg ="登录成功";
        $render_json->toJson();
    }

    //忘记密码
    public function forget_pas(Request $request){
        if($request->isPost()){
            $render_json = new Json();
            $map = input('post.');
            $code = Session::get('forget_code');
            if($code != $map['forget_code']){
                $render_json->status = 6;
                $render_json->msg ="验证码错误";
                $render_json->toJson();
            }
            $Arr = Db::name('user')->field('id,username')->where('username',$map['username'])->find();
            if(empty($Arr)){
                $render_json->status =7;
                $render_json-> msg = "你输入的用户还么有注册";
                $render_json->toJson();
            }
            $pas_salt = getRandChar(6);

            $data = array(
                'password' => getMd5Pas($map["password"], $pas_salt),
                'salt' => $pas_salt,
            );
            $pd = Db::name("User")->where("id",$Arr["id"])->update($data);
            if($pd){
                Session::set('userInfo',$Arr);
                $render_json->status = 0;
                $render_json->msg = "密码修改成功";
            }else{
                $render_json->status = 8;
                $render_json->msg = "操作失败";
            }
            $render_json->toJson();
        }

        $map = input('param.');
        $username = '';
        if(isset($map['username']) && empty($map['username'])){
            $username = $map['username'];
        }

        Session::delete('forget_code');
        $this->assign('username',$username);
        return $this->fetch();

    }


    public function get_forget_code(){
        $render_json = new Json();
        $map = input('post.');
        if(empty($map['username'])){
            $render_json->status = 3;
            $render_json ->msg = "请输入用户名";
            $render_json->toJson();
        }

        $Arr = Db::name('user')->field('id,phone')->where('username',$map['username'])->find();
        if(empty($Arr)){
            $render_json->status =4;
            $render_json-> msg = "你输入的用户还么有注册";
            $render_json->toJson();
        }
        $code = rand(100000,999999);
       $sms =  new TransmitSms();
       $pd = $sms ->phone_validate($Arr['phone'],$code);

       if($pd){
           Session::set('forget_code',$code);
           $render_json->status =0;
           $render_json->msg ="发送成功";
       }else{
           $render_json->status =5;
           $render_json->msg ="发送失败";
       }
       $render_json->toJson();

    }

    public function logout(){
        Session::delete('userInfo');
        $this->redirect('login/index');
    }
}
