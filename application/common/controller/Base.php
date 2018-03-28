<?php

namespace app\common\controller;
use think\Controller;
use think\Db;

class Base extends controller
{
    public $configArr = [];
    public $vip = [
        "1" => "v0创客",
        "2" => "v1创客",
        "3" => "v2创客"
    ];

    public $m_lever =[
        '1' => '普通会员',
        '2' => '经理',
        '3' => '总监',
        '4' => '合伙人'
    ];

    public function _initialize()
    {

        //读取配置
        $this->configArr = Db::name('config')->where('status>0')->column('name,value');
        

        $this->assign("configArr",$this->configArr);
        $this->assign('vip',$this->vip);
        $this->assign('m_lever',$this->m_lever);
    }


    public function json_return($data,$files="dataError"){
        echo json_encode($data);
        exit();
    }
}
