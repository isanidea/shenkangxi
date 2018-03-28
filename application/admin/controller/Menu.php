<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Cache;
use think\Db;
class Menu extends adminBase
{
    public function index()
    {

        $data = \think\Cache::get('wholeMenu');

        $map = input('param.');

        $moduleList = app_model("admin","Module")->getAll();
        $moduleList = collection($moduleList)->toArray();
        if( isset($map["module_id"]) && !empty($map["module_id"]) ){

            $module_id = $map["module_id"];
        }else{
            $module_id = $moduleList[0]["id"];
        }

        if( isset($map["status"]) && !empty($map["status"]) ){
            $statusArr = [$map["status"]];
            $status = $map["status"];
        }else{
            $statusArr = [5,10];
            $status = 0;
        }

        $list[] = array();
        foreach($data as $k=>$v){

            if( $v["module_id"] == $module_id ){
                if( in_array($v["status"],$statusArr) ){
                    $list[] = $v;
                }
            }
        }
        $list = array_filter($list);



        $this->assign("Arr",array("module_id"=>$module_id,"status"=>$status));
        $this->assign("moduleList",$moduleList);
        $this->assign("list",$list);
        return $this->fetch();
    }

    function add(){

        if( request()->isAjax() ){

            $data=input('post.');
            $nameArr = app_model("admin","Module")->getKeyValueArr($data["module_id"],"name");
            if( empty($nameArr) ){

                $retArr = [
                    "result" => 1,
                    "msg" => "非法数据",
                ];
                $this->dataError = "uid=".UID."|".json_encode($data);
                $this->json_return($retArr);

            }else{
                $data["module_name"] = $nameArr[0];
                $data["startTime"] = time();
                $data["admin_id"] = UID;
            }
            $id = $this->insert_updata($data);
            Cache::rm('wholeMenu');
            $this->ajax_return($id);

        }else{

            $moduleList = app_model("admin","Module")->getAll();
            $moduleList = collection($moduleList)->toArray();
        }

        $this->assign("submitUrl",url("Menu/add"));
        $this->assign("moduleList",$moduleList);
        return $this->fetch("edit");
    }



    //修改
    function edit(){

        if( request()->isAjax() ){

            $data=input('post.');
            $nameArr = app_model("admin","Module")->getKeyValueArr($data["module_id"],"name");
            if( empty($nameArr) ){

                $retArr = [
                    "result" => 1,
                    "msg" => "非法数据",
                ];
                $this->dataError = "uid=".UID."|".json_encode($data);
                $this->json_return($retArr);

            }else{
                $data["module_name"] = $nameArr[0];
                $data["startTime"] = time();
                $data["admin_id"] = UID;
            }
            $id = $this->insert_updata($data);
            Cache::rm('wholeMenu');
            $this->ajax_return($id,"edit");

        }else{

            $data = input('param.');
            if( !isset($data["id"]) || empty($data["id"]) ){
                return $this->success('非法操作',url('Menu/index'));
            }
            $Arr = Db::name("Menu")->where("id",$data["id"])->find();
            $moduleList = app_model("admin","Module")->getAll();
            $moduleList = collection($moduleList)->toArray();
        }
        $this->assign("Arr",$Arr);
        $this->assign("submitUrl",url("Menu/edit"));
        $this->assign("moduleList",$moduleList);
        return $this->fetch();
    }



}
