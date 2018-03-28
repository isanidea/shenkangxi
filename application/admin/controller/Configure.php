<?php
namespace app\admin\controller;

use app\admin\model\Config;
use app\common\controller\adminBase;
use think\Db;

class Configure extends adminBase
{

    public $Config;

    public function _initialize() {
        parent::_initialize();

        $this->Config = app_model("admin","Config");
    }


    public function income()
    {
        //收款银行配置
        $list = $this->Config->getList("id,value,info","income");

        $this->assign("list",$list);
        return $this->fetch();
    }


    //网站信息
    public function web_intercalate(){

        $list = $this->Config->getList("id,value,info","web");

        $this->assign("list",$list);
        return $this->fetch();
    }

    //微信
    public function weixin(){
        $list = $this->Config->getList("id,value,info","weixin");

        $this->assign("list",$list);
        return $this->fetch();
    }

    public function alipay(){

        $list = $this->Config->getList("id,value,info","alipay");

        $this->assign("list",$list);
        return $this->fetch();
    }

    //修改配置
    public function save_config(){

        if( request()->isAjax() ){

            $map = input("post.");
            $data = [];
            $type = 1;
            foreach($map as $k=>$v){
                if( strpos($k,"-") !== false ){
                    //多条
                    $type = 2;
                    $Arr = explode("-",$k);
                    $data[$Arr[0]][$Arr[1]] = $v;
                }else{
                    //单条
                    $data[$k] = $v;
                }
            }

            if( $type == 1 ){

                $this->Config->update($data);
            }else{

                $this->Config->isUpdate()->saveAll($data);
            }

            $retArr["result"] = 0;
            $retArr["msg"] = "修改成功";
            $this->json_return($retArr);
        }

    }




}
