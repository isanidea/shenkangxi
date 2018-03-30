<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Cache;
use think\Db;
class Module extends adminBase
{



    public function index()
    {
        $list = app_model("admin","Module")->getAll();

        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add(){

        if( request()->isAjax() ){
            $this->insert_updata();

            Cache::rm('wholeMenu');
            $this->json_return();
        }
        $this->assign("submitUrl",url("Module/add"));
        return $this->fetch("edit");
    }



    //修改
    function edit(){

        if( request()->isAjax() ){

            $this->insert_updata();

            Cache::rm('wholeMenu');
            $this->json_return();

        }

        $data = input('param.');
        if( !isset($data["id"]) || empty($data["id"]) ){
            return $this->success('非法操作',url('Module/index'));
        }
        $Arr = Db::name("Module")->where("id",$data["id"])->find();

        $this->assign("submitUrl",url("Module/edit"));
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }


}
