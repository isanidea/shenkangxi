<?php
namespace app\admin\controller;

use app\admin\model\Config;
use app\common\controller\adminBase;
use Think\Cache;
use think\Db;

class Brokerage extends adminBase
{

    public function _initialize() {
        parent::_initialize();

        $this->Config = app_model("admin","Brokerage");
    }

    /*
        'id' => int 1
      'name' => string '注册积分' (length=12)
      'key' => string 'reg_1' (length=5)
      'value' => string '5' (length=1)
      'type' => string 'reg' (length=3)
     */
    public function index(){
        $all_config = Db::name('Brokerage')->select();
        if(!empty($all_config)){
            $this->assign("all_config",$all_config);
           return  $this->fetch();
        }else{
            $this->error('配置错误');
        }
    }

    //修改
    public function edit(){
        if(request()->ispost()){
             $param = input('param.');
             $update = Db::name('Brokerage')->where('id',$param['id'])->update(array('value'=>$param['value']));
             if($update){
                $this->redirect("brokerage/index");
             }else{
                $this->error('错误');
             }
        }else{
            $id = input('param.id');
            $config_info = Db::name('Brokerage')->where('id',$id)->find();
            $this->assign('config_info',$config_info);
            return $this->fetch();
        }
    }




}
