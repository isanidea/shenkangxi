<?php

namespace app\index\controller;

use app\common\controller\IndexBase;
use think\Db;
use think\Session;

class Index extends IndexBase
{
    //首页
    public function index()
    {
        $userInfo = Session::get('userInfo');
        if(empty($userInfo['id'])){
            echo 'session信息没有了';die;
        }
//        $key_1 = $userInfo['id'].'_'.'1';// 基本信息缓存
//        if(empty(Cache::store('redis')->get($key_1))){
            $user_base = Db::name('user')->where('id',$userInfo['id'])->find();
//            Cache::store('redis')->set($key_1,$user_base);
//        }
//        $key_2 = $userInfo['id'].'_'.'2';// 详细信息缓存
//        if(empty(Cache::store('redis')->get($key_2))){
            $user_details = Db::name('user_details')->where('uid',$userInfo['id'])->find();
//            Cache::store('redis')->set($key_2,$user_details);
//        }

        $promo_name = Db::name('user')->field('username')->where('id',$user_details['pid'])->find();
        if($promo_name){
            $this->assign('promo_name',$promo_name['username']);
        }else{
            $this->assign('promo_name','自己');
        }
//        echo Db::table('username')->getLastSql();
        $this->assign('user_base',$user_base);
        $this->assign('user_details',$user_details);
        return $this->fetch();
    }

}
