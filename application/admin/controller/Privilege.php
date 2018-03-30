<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
class Privilege extends adminBase
{
    public function index()
    {

        $data = \think\Cache::get('wholeMenu');

        $map = input('param.');

        $roleList = app_model("admin","Role")->getAll();
        $roleList = collection($roleList)->toArray();
        if( isset($map["role_id"]) && !empty($map["role_id"]) ){

            $role_id = $map["role_id"];
        }else{
            $role_id = $roleList[0]["id"];
        }

        $menuArr = Db::name("privilege")->where("role_id",$role_id)->column("menu_id","id");
        $list[] = array();
        foreach($data as $k=>$v){

            if( $v["module_id"] != 1 ){
                $list[$v["module_id"]]["name"] = $v["module_name"];
                $list[$v["module_id"]]["list"][] = array(
                    "name" => $v["menu_name"],
                    "role_id" => $v["id"],
                    "status" => in_array($v["id"],$menuArr) ? 1 : 0
                );
            }
        }
        $list = array_filter($list);

        $this->assign("oldPrivilege",json_encode($menuArr));
        $this->assign("role_id",$role_id);
        $this->assign("roleList",$roleList);
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function edit(){

        if( request()->isPost() ){

            $data=input('post.');

            $role_id = $data["role_id"];
            $oldPrivilege = json_decode($data["oldPrivilege"],true);
            $newPrivilege = array_filter( explode(",",$data["newPrivilege"]) );
            $addArr = [];
            foreach($newPrivilege as $k=>$v){
                if( !in_array($v,$oldPrivilege) ){
                    $addArr[] = array(
                        "role_id" => $role_id,
                        "menu_id" => $v,
                    );
                }
            }
            $delArr = [];
            foreach($oldPrivilege as $k=>$v){
                if( !in_array($v,$newPrivilege) ){
                    $delArr[] = $k;
                }
            }
            $privilege = app_model("admin","Privilege");
            if( !empty($addArr) ){
                $privilege->insertAll($addArr);
            }
            if( !empty($delArr) ){
                $privilege->where("id","in",$delArr)->delete();
            }

            $this->json_return();
        }

    }

}
