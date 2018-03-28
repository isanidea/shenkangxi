<?php

namespace app\index\controller;

use app\common\controller\Base;
use think\Db;
use think\Session;
use tool\Json;
use tool\TransmitSms;

class Register extends Base
{

    public function index()
    {
        $pid = input('param.pid');
        if (!empty($pid)) {
            $this->assign('pid', $pid);
            return $this->fetch();
        } else {
            echo "此连接没有推荐人";
        }
    }

    public function zao(){
        $pas_salt = getRandChar(6);
        $a =getMd5Pas('889912',$pas_salt);
        dump($pas_salt);
        dump($a);
      echo  time();
    }

    public function register()
    {
        $render_json = new Json();
        $d = $this->request->post();
        $verify_code_ = Session::get('verify_code');
        if ($d['verify_code'] != $verify_code_) {
            $render_json->status = 1;
            $render_json->msg = "验证码不匹配";
            $render_json->toJson();
        }
        //推荐人是否存在
        $pdArr = Db::name("User")->where('id', $d['pid'])->find();
        if (empty($pdArr)) {
            $render_json->status = 2;
            $render_json->msg = "此推荐人不存在";
            $render_json->toJson();
        }

        $pas_salt = getRandChar(6);
        $data = array(
            'password'=> getMd5Pas($d['password'],$pas_salt),
            'nickname' => 'XLS_'.mt_rand(1,99999999),
            'salt' => $pas_salt,
            'username'=> $d['username'],
            'phone' => $d['phone'],
            'real_name'=>$d['real_name'],
            'id_card'=>$d['id_card'],
            'zijin_pwd'=>$d['zijin_pwd'],
            'img'=>'/static/qiantai/img/wo.png',
            'add_time'=>time()
        );
        $result_1 = Db::name('user')->where('username',$d['username'])->find();
        if(!empty($result_1)){
            $render_json->status=4;
            $render_json->msg ="已经注册";
            $render_json->toJson();
        }
        $uid = Db::name('user')->insert($data,false,true);
        if(empty($uid)){
             $render_json->status=5;
             $render_json->msg ="注册失败";
            $render_json->toJson();
        }
        $data_2 =array(
        'id'=>$uid,
        'username'=>$d['username'],
        'manage_lever'=>1,
        'lever'=>1,
        'pid'=>$d['pid'],
         'jifen'=>5,
    );
        $result_2 = Db::name('userDetails')->insert($data_2,false,true);
        if(empty($result_2)){
            $render_json->status=6;
            $render_json->msg="用户详细表注册失败";
            $render_json->toJson();
        }
        //其推荐人id加积分
       $jifen = Db::name('userDetails')->field('jifen')->where('id',$d['pid'])->find();
        $jifen_arr = array(
            'jifen'=>$jifen+3,
        );
        //更改推荐人积分+3
      $result_3 =  Db::name('userDetails')->where('id',$d['pid'])->update($jifen_arr);
      if(empty($result_3)){
            $render_json->status =7;
            $render_json->msg = "积分修改不成功";
            $render_json->toJson();
      }

        $userInfo = array(
            "id" => $uid,
            "username" => $d['username'],
        );
        Session::set('userInfo',$userInfo);
        $render_json->status=0;
        $render_json->msg="注册成功";
        $render_json->toJson();
    }


    /**
     *
     */
    public function reg_code()
    {
        $render_json = new Json();
//        $phone = $request->param('phone', '');
        $phone = $this->request->param('phone','');
        $code = rand(100000, 999999);
        if (empty($phone)) {
            tplog("phone:[$phone]");
        }
        $sms = new TransmitSms();
        $pd = $sms->phone_validate($phone, $code);
        if ($pd) {
            Session::set('verify_code', $code);
        } else {
            $render_json->status = 1;
            $render_json->msg = "手机验证码发送失败";
        }
        $render_json->status = 0;
        $render_json->msg = "手机验证码发送成功";
        $render_json->toJson();
    }
}
