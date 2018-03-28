<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
class Role extends adminBase
{
    public function index()
    {
        $list = app_model("admin","Role")->getAll();

        $this->assign("list",$list);
        return $this->fetch();
    }

    public function add(){

        if( request()->isAjax() ){
            $id = $this->insert_updata();
            $this->ajax_return($id);
        }
        $this->assign("submitUrl",url("Role/add"));
        return $this->fetch("edit");
    }



    //修改
    function edit(){

        if( request()->isAjax() ){

            $id = $this->insert_updata();
            $this->ajax_return($id,"edit");

        }else{

            $data = input('param.');
            if( !isset($data["id"]) || empty($data["id"]) ){
                return $this->success('非法操作',url('Role/index'));
            }
            $Arr = Db::name("Module")->where("id",$data["id"])->find();
        }
        $this->assign("submitUrl",url("Role/edit"));
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }
}
