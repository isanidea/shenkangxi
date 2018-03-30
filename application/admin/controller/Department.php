<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
class Department extends adminBase
{



    public function index()
    {
        $list = app_model("admin","Department")->getAll();

        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add(){

        if( request()->isAjax() ){
            $this->insert_updata();
            $this->json_return();
        }
        $this->assign("submitUrl",url("Department/add"));
        return $this->fetch("edit");
    }



    //修改
    function edit(){

        if( request()->isAjax() ){

            $this->insert_updata();
            $this->json_return();

        }

        $data = input('param.');
        if( !isset($data["id"]) || empty($data["id"]) ){
            return $this->success('非法操作',url('Department/index'));
        }
        $Arr = Db::name("Department")->where("id",$data["id"])->find();
        $this->assign("submitUrl",url("Department/edit"));
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }


}
