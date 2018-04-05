<?php
namespace app\admin\controller;
use app\common\controller\adminBase;
use think\Db;
use think\Session;
use \think\Request;

class User extends adminBase
{
	public function index(){

        $map = input("param.");

        $where["a.status"] = ["gt",0];
        $Arr = [];
        if(!empty($map["real_name"])){
            $where["a.real_name"] = $map["real_name"];
            $Arr["real_name"] = $map["real_name"];
        }
        if(!empty($map["username"])){
            $where["a.username"] = $map["username"];
            $Arr["username"] = $map["usernamek"];
        }
        if( isset($map["lever"]) && $map["lever"] != "" ){
            $where["a.lever"] = $map["lever"];
            $Arr["lever"] = $map["lever"];
        }
        $list = app_model("Admin","User")->get_pageList($where);
        $this->assign("pagetotal",$this->getPageTotal($list));
		$this->assign('list',$list);
        $this->assign('Arr',$Arr);
		return $this->fetch();
	}

    //会员详情
    public function details(){

        $id = input('param.id');
        if( empty($id) ){
            $this->error("错误数据");
        }
        $Arr = app_model("Index","User")->getuserInfo($id);
        $this->assign('Arr',$Arr);
        return $this->fetch();
    }


    //拨币
    public function allocate(){

        $typeArr = [
            "cash" => "现金卷",
            "bonus" => "奖金卷",
            "double_benefit" => "复利卷",
            "acting" => "代金卷",
            "shopping" => "消费卷",
            "register" => "注册卷",
        ];

        if( request()->isAjax() ){

            $map = input("post.");
            if( !$this->data_verify($map,"id,type,money") ){
                $retArr = [
                    "result" => 1,
                    "msg" => "非法数据",
                ];
                $this->json_return($retArr);
            }
            $logArr = [
                "user_id" => $map["id"],
                "money" => $map["money"],
                "type" => $map["type"],
                "c_time" => time(),
                "admin_id" => UID
            ];
            $pd = Db::name("AllocateLog")->insert($logArr,false,true);
            if( $pd ){

                Db::name("userinfo")->where("user_id",$map["id"])->setInc($map["type"],$map["money"]);
                $retArr = [
                    "result" => 0,
                    "msg" => "拨币成功",
                ];
            }else{
                $retArr = [
                    "result" => 1,
                    "msg" => "拨币失败",
                ];
            }
            $this->json_return($retArr);
        }

        $id = input('param.id');
        if( empty($id) ){
            $this->error("缺少ID");
        }

        $Arr = Db::name("user")->field("id,account,real_name")->where("id",$id)->find();

        $this->assign("typeArr",$typeArr);
        $this->assign("Arr",$Arr);
        $this->assign("submitUrl",url("User/allocate"));
        return $this->fetch();
    }

	//编辑
    public function edit(){
        if( request()->isAjax() ){
            $map = input("post.");

            $pdArr = Db::name("User")->where("id",$map["id"])->find();

            $Arr = [
                "real_name" => $map["real_name"],
                "id_card" => $map["id_card"],
            ];
            Db::name("User")->where("id",$map["id"])->update($Arr);
            $data = [
                "lever" => $map["lever"],
                "manage_lever" => $map["manage_lv"],
            ];
            Db::name("User_details")->where("uid",$map["id"])->update($data);
            $this->json_return(["result" => 0,"msg" => "编辑成功"]);
        }
        $uid = input("param.id");
        if( empty($uid) ){
            $this->error("缺少ID");
        }

        $Arr = app_model("index","User")->getuserInfo($uid,"a.id,a.real_name,a.id_card,b.lever,b.manage_lever");

        $this->assign("submitUrl",url("User/edit"));
        $this->assign("levelName",$this->vip);
        $this->assign("manageName",$this->m_lever);
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }

    function user_del(){

        if( request()->isAjax() ){

            $uid = input("post.id");
            if( empty($uid) ){
                $this->json_return(["result" => 1,"msg" => "数据有误"]);
            }
            $pd = Db::name("userinfo")->where("pid",$uid)->count();
            if( !empty($pd) ){
                $this->json_return(["result" => 1,"msg" => "此账号不能删除"]);
            }
            Db::name("user")->where("id",$uid)->delete();
            Db::name("userinfo")->where("user_id",$uid)->delete();
            $this->json_return(["result" => 0,"msg" => "删除成功"]);
        }
    }












}
