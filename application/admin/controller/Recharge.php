<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Cache;
use think\Db;
class Recharge extends adminBase
{

    public $statusName = [
        "5" => "驳回",
        "10" => "待上传",
        "15" => "已上传",
        "20" => "已完成",
    ];


    //套餐订单列表
    public function index(){
        if( request()->isAjax() ){

            $map = input("param.");

            if( empty($map["status"]) ){
                $where = " a.status > 0 ";
            }else{
                $where = " a.status = ".$map["status"];
            }

            if( !empty($map["start_time"]) ){

                $where .= " AND a.add_time >= ".strtotime($map["start_time"]);
            }

            if( !empty($map["end_time"]) ){
                if( empty($map["start_time"]) ){
                    $time = time() - (60*60*24*7);
                    $where .= " AND a.add_time >= ".$time;
                }
                $where .= " AND a.add_time <= ".strtotime($map["end_time"]);
            }

            if( !empty($map["username"]) ){

                $where .= " AND b.username = '".$map["username"]."'";
            }


            $count = Db::name("Recharge")->alias("a")
                    ->join('user b',"b.id = a.uid","LEFT")
                    ->where($where)
                    ->count();

            $limitForm = ( $map["page"] -1 )* $map["limit"];
            $list = Db::name("Recharge")->alias("a")
                ->join("user b"," b.id = a.uid","LEFT")
                ->field("a.*,b.username,b.real_name")
                ->where($where)
                ->order("a.id desc")
                ->limit($limitForm,$map["limit"])
                ->select();
            $data = [];
            foreach($list as $k=>$v){
                $data[$k]["id"] = $v["id"];
                $data[$k]["order_no"] = $v["order_no"];
                $data[$k]["uid"] = $v["uid"];
                $data[$k]["money"] = $v["money"];
                $data[$k]["add_time"] = date('y-m-d H:i:s', $v["add_time"]);
                $data[$k]["payway"] = $v["payway"] == 1 ? "线下" : "线上";
                $data[$k]["statusName"] = $this->statusName[$v["status"]];
                $data[$k]["username"] = $v["username"];
                $data[$k]["real_name"] = $v["real_name"];
            }

            $retArr = [
                "code"=>0,
                "msg" => "",
                "count" => $count,
                "data" => $data
            ];
            echo json_encode($retArr);
            exit();
        }else{
            $map = input('param.');
            $url = '/index.php/admin/Recharge/index';
            $Arr = [];
            if( empty($map["status"]) ){
                $url.="?status=0";
            }else{
                $url.="?status=".$map["status"];
                $Arr["status"] = $map["status"];
            }
            if( !empty($map["username"]) ){
                $url.="&username=".$map["username"];
                $Arr["username"] = $map["username"];
            }

            if( !empty($map["start_time"]) ){
                $url.="&start_time=".$map["start_time"];
                $Arr["start_time"] = $map["start_time"];
            }
            if( !empty($map["end_time"]) ){
                $url.="&end_time=".$map["end_time"];
                $Arr["end_time"] = $map["end_time"];
            }

            $this->assign("Arr",$Arr);
            $this->assign("url",$url);
        }
        $this->assign("statusName",$this->statusName);
        return $this->fetch();
    }

    //订单详情
    public function order_details(){

        $id = input('param.id');

        $Arr = Db::name("Recharge")->alias("a")
            ->join("user b","a.uid = b.id","left")
            ->field("a.*,b.nickname,b.username,b.real_name")
            ->where("a.id",$id)
            ->find();
        $Arr["statusName"] = $this->statusName[$Arr["status"]];

        $this->assign("Arr",$Arr);
        return $this->fetch();
    }

    //确认支付
    public function affirm_puy(){

        if( request()->isAjax() ) {

            $map = input("post.");
            if( !isset($map["id"]) && empty($map["id"])  ){

                $this->dataError = json_encode($map);
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }

            $Arr = Db::name("Recharge")->field("user_id,money,status")->where("id",$map["id"])->find();
            if( empty($Arr) ||  $Arr["status"] == 20  ){
                $this->dataError = json_encode($map);
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }
            $pid = Db::name("Recharge")->where("id",$map["id"])->update(["status"=>20,"pay_time"=>time()]);
            if( $pid ){

                Db::name("userinfo")->where("user_id",$Arr["user_id"])->setInc("cash",$Arr["money"]);
                $retArr["result"] = 0;
                $retArr["msg"] = "操作成功";
            }else{
                $retArr["result"] = 3;
                $retArr["msg"] = "操作失败";
            }
            $this->json_return($retArr);
        }
    }

    //订单删除
    public function order_del(){

        if( request()->isAjax() ) {

            $map = input("post.");
            if( !isset($map["id"]) && empty($map["id"])  ){

                $this->dataError = json_encode($map);
            }
            if( !isset($map["status"]) ){

                $this->dataError = json_encode($map);
            }else{
                $status = $map["status"];
            }
            if( !empty($this->dataError) ){
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }

            $Arr = Db::name("Recharge")->field("status")->where("id",$map["id"])->find();
            if( empty($Arr) || empty($Arr["status"]) ){
                $this->dataError = json_encode($map);
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }
            $pid = Db::name("Recharge")->where("id",$map["id"])->update(["status"=>$status]);
            if( $pid ){
                $retArr["result"] = 0;
                $retArr["msg"] = "操作成功";
            }else{
                $retArr["result"] = 3;
                $retArr["msg"] = "操作失败";
            }
            $this->json_return($retArr);
        }
    }


}
