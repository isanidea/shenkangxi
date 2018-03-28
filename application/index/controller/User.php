<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use app\index\model\Address;
use think\Db;

class User extends IndexBase
{
    public function index()
    {
        return $this->fetch();
    }


    public function add_address()
    {
        $this->titleName = "添加地址";

        $jumpUrl = $_SERVER['HTTP_REFERER'];

        if (request()->isPost()) {

            $data = input("post.");
            if (empty($data["province"]) || empty($data["city"]) || empty($data["town"])) {

                $this->error("请选择地址");
            }

            $Arr["details"] = $data["province"] . ">" . $data["city"] . ">" . $data["town"] . ">" . $data["details"];
            $Arr["id"] = $data["id"];
            $Arr["user_id"] = $this->userInfo["id"];
            $Arr["name"] = $data["name"];
            $Arr["phone"] = $data["phone"];
            $Arr["postcode"] = $data["postcode"];//邮编
            $address = new Address();
            $id = $address->add_up_data($Arr);
            if ($id) {
                if (isset($data["jumpUrl"]) && !empty($data["jumpUrl"])) {
                    $url = $data['jumpUrl'];
                    Header("Location: $url");
                    exit();
                }
                $this->redirect('User/address_list');
            } else {
                $this->error("编辑地址失败");
            }
        } else {

            $aid = input("param.aid");
            if (!empty($aid)) {

                $this->titleName = "修改地址";

                $Arr = Db::name("address")->where("id", $aid)->find();
                if (empty($Arr)) {
                    $this->redirect('User/address_list');
                }
                $ress = explode(">", $Arr["details"]);
                $ress = array_filter($ress);
                $Arr["province"] = $ress[0];
                $Arr["city"] = $ress[1];
                $Arr["town"] = $ress[2];
                $Arr["details"] = $ress[3];

                $this->assign("Arr", $Arr);
            }
        }
        $this->assign("jumpUrl", $jumpUrl);
        return $this->fetch();
    }

    //地址列表
    public function address_list(){

        $list = Db::name("Address")->where(array("status"=>["gt","0"],"user_id"=>$this->userInfo["id"]))->select();
        foreach($list as $k=>$v){
            $list[$k]["details"] = str_replace(">","",$v["details"]);
        }
        $this->assign("list",$list);
        $this->titleName = "收货地址";
        return $this->fetch();
    }

    //地址列表
    public function del_address(){

        if( request()->isAjax() ){
            $render_json = new Json();
            $id = input("post.id");
            if( empty($id) ){
                $render_json->status = 1;
                $render_json->msg = "删除地址失败";
                $retArr = [
                    "result" => 1,
                    "msg" => "删除地址失败",
                ];
                $this->dataError = "uid=".$this->userInfo["id"]."|".json_encode($id);
                $this->json_return($retArr);
            }
            $pid = Db::name("Address")->where("id",$id)->update(array("status"=>0));
            if( $pid ){
                $retArr = [
                    "result" => 0,
                    "msg" => "删除成功",
                ];
            }else{
                $retArr = [
                    "result" => 0,
                    "msg" => "删除失败",
                ];
                $this->dataError = "uid=".$this->userInfo["id"]."|".json_encode($id);
            }
            $this->json_return($retArr);
        }

    }

}