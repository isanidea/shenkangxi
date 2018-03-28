<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
use think\Session;

class Admin extends adminBase
{
    public function index()
    {
		
		
        $admin = app_model("admin","admin");

        $list = $admin->getPageList();



        $this->assign("pagetotal",$this->getPageTotal($list));
        $this->assign("list",$list);
        return $this->fetch();
    }

    function add(){

        if( request()->isAjax() ){

            $data=input('post.');
            if( !isset($data["passwd"]) || empty($data["passwd"]) ){
                $retArr = [
                    "result" => 1,
                    "msg" => "请输入密码",
                ];
                $this->json_return($retArr);
            }

            $pas_salt = getRandChar(6);
            $data["passwd"] = getMd5Pas($data["passwd"],$pas_salt);
            $data["pas_salt"] = $pas_salt;

            $id = $this->insert_updata($data);
            $this->ajax_return($id);

        }

        $departmentList = app_model("admin","Department")->getAll();

        $this->assign("departmentList",$departmentList);
        $this->assign("submitUrl",url("Admin/add"));
        return $this->fetch("edit");
    }


    //修改
    function edit(){

        if( request()->isAjax() ){

            $data=input('post.');
            if( !empty($data["passwd"]) ){

                $pas_salt = getRandChar(6);
                $data["passwd"] = getMd5Pas($data["passwd"],$pas_salt);
                $data["pas_salt"] = $pas_salt;

            }else{
                unset($data["passwd"]);
            }

            $id = $this->insert_updata($data);
            $this->ajax_return($id,"edit");

        }else{

            $data = input('param.');
            if( !isset($data["id"]) || empty($data["id"]) ){
                return $this->success('非法操作',url('Admin/index'));
            }
            $Arr = Db::name("Admin")->where("id",$data["id"])->find();

            $departmentList = app_model("admin","Department")->getAll();

            $this->assign("departmentList",$departmentList);
        }

        $this->assign("Arr",$Arr);
        $this->assign("submitUrl",url("Admin/edit"));
        return $this->fetch();
    }

    //角色分配
    public function adminRole(){


        if( request()->isAjax() ){

            $data=input('post.');

            $admin_id = $data["admin_id"];
            $oldRoles = json_decode($data["oldRoles"],true);
            $newRoles = array_filter( explode(",",$data["newRoles"]) );
            $addArr = [];
            foreach($newRoles as $k=>$v){
                if( !in_array($v,$oldRoles) ){
                    $addArr[] = array(
                        "admin_id" => $admin_id,
                        "role_id" => $v,
                    );
                }
            }
            $delArr = [];
            foreach($oldRoles as $k=>$v){
                if( !in_array($v,$newRoles) ){
                    $delArr[] = $k;
                }
            }
            $adminRole = app_model("admin","adminRole");
            if( !empty($addArr) ){
                $adminRole->insertAll($addArr);
            }
            if( !empty($delArr) ){
                $adminRole->where("id","in",$delArr)->delete();
            }

            $this->json_return(array("result"=>0));

        }else{

            $map = input('param.');

            $adminList = app_model("admin","admin")->where("isAdmin = 0 and status > 0")->select();
            $adminList = collection($adminList)->toArray();
            if( isset($map["id"]) && !empty($map["id"]) ){

                $admin_id = $map["id"];
            }else{
                $admin_id = $adminList[0]["id"];
            }

            $roleList = app_model("admin","Role")->getAll();
            $roleList = collection($roleList)->toArray();

            $oldRoles = Db::name("adminRole")->where("admin_id",$admin_id)->column("role_id","id");
            foreach($roleList as $k=>$v){

                if( in_array($v["id"],$oldRoles) ){
                    $roleList[$k]["statu"] = 1;
                }else{
                    $roleList[$k]["statu"] = 0;
                }
            }

            $this->assign("admin_id",$admin_id);
            $this->assign("oldRoles",json_encode($oldRoles));
            $this->assign("roleList",$roleList);
            $this->assign("adminList",$adminList);
        }


        return $this->fetch();
    }

    //修改密码
    public function savePasswd(){

        if( request()->isAjax() ){
            $data=input('post.');
            if( !isset($data["passwd"]) || empty($data["passwd"]) ){
                $retArr = [
                    "result" => 1,
                    "msg" => "请输入密码",
                ];
                $this->json_return($retArr);
            }

            $pas_salt = getRandChar(6);
            $data["passwd"] = getMd5Pas($data["passwd"],$pas_salt);
            $data["pas_salt"] = $pas_salt;
            $data["id"] = UID;
            $id = app_model("admin",$this->nav_controller)->add_up_data($data);
            $this->ajax_return($id,"edit");
        }

        $this->assign("submitUrl",url("Admin/savePasswd"));
        return $this->fetch();
    }

    //退出
    public function quitLogin(){

        Session::delete("user_auth");
        $this->redirect('Login/login');
    }


}
