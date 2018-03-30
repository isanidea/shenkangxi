<?php

namespace app\common\controller;
use think\Controller;
use think\Db;

class Base extends controller
{
    public $dataError;
    public $controller;
    public $action;
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
        $this->controller = request()->controller();
        $this->action = request()->action();

        $this->assign("configArr",$this->configArr);
        $this->assign('vip',$this->vip);
        $this->assign('m_lever',$this->m_lever);
    }


    public function json_return($result=0,$msg="操作成功",$fileName="dataError"){

        if( !empty($this->dataError) ){
            $str = $this->controller."|".$this->action."|".$fileName."=".$this->dataError;
            // create_api_log($str,$fileName);
        }
        $retArr = [
            "result" => $result,
            "msg" => $msg
        ];
        echo json_encode($retArr);
        exit();
    }
}
