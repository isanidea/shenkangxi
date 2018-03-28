<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Cache;
use think\Db;
class Activate extends adminBase
{
    public $statusName = [
        "5" => "未支付",
        "10" => "已上传凭证",
        "15" => "已付款",
        "20" => "待发货",
        "25" => "已发货",
    ];
    //激活订单列表
    public function order(){
        if( request()->isAjax() ){
            $map = input("param.");
            if( empty($map["status"]) ){
                $where = " a.status > 0 ";
            }else{
                $where = " a.status = ".$map["status"];
            }

            if( !empty($map["start_time"]) ){

                $where .= " AND a.start_time >= ".strtotime($map["start_time"]);
            }
            if( !empty($map["end_time"]) ){
                if( empty($map["start_time"]) ){
                    $time = time() - (60*60*24*7);
                    $where .= " AND a.start_time >= ".$time;
                }
                $where .= " AND a.start_time <= ".strtotime($map["end_time"]);
            }

            if(!empty($map["order_code"])){
                $where = " a.order_code = '".$map["order_code"]."'";
            }

            $count = Db::name("activation_orders")->alias("a")
                ->where($where)
                ->count();

            $limitForm = ( $map["page"] -1 )* $map["limit"];

            $list = Db::name("activation_orders")->alias("a")
                ->join("xls_user b","a.user_id = b.id","left")
                ->field("a.id,user_id, a.order_code, a.buy_id, a.lv_name,a.use_cash, a.price, a.start_time, a.pay_type, a.integral, a.order_type, a.status, b.nickname")
                ->where($where)
                ->order("a.id desc")
                ->limit($limitForm,$map["limit"])
                ->select();

            $data = [];
            foreach($list as $k=>$v){
                $data[$k]["id"] = $v["id"];
                $data[$k]["order_code"] = $v["order_code"];
                $data[$k]["user_id"] = $v["buy_id"];
                $data[$k]["lv_name"] = $v["lv_name"];
                $data[$k]["price"] = $v["price"];
                $data[$k]["use_cash"] = $v["use_cash"];
                $data[$k]["start_time"] = date('y-m-d H:i:s', $v["start_time"]);
                $data[$k]["pay_type"] = $v["pay_type"] == 1 ? "线下" : "线上";
                $data[$k]["integral"] = $v["integral"];
                $data[$k]["order_type"] = "激活订单";
                $data[$k]["statusName"] = $this->statusName[$v["status"]];
                $data[$k]["user_id"] = $v["user_id"];
                $data[$k]["statusVal"] = $v["status"];
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
            $url = '/admin/Activate/order';
            $Arr = [];
            if( empty($map["status"]) ){
                $url.="?status=0";
            }else{
                $url.="?status=".$map["status"];
                $Arr["status"] = $map["status"];
            }
            if( !empty($map["order_code"]) ){
                $url.="&order_code=".$map["order_code"];
                $Arr["order_code"] = $map["order_code"];
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

            $Arr = Db::name("activation_orders")->field("package_id,status")->where("id",$map["id"])->find();
            if( empty($Arr) || $Arr["status"] == 15 ){
                $this->dataError = json_encode($map);
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }
            $pid = Db::name("activation_orders")->where("id",$map["id"])->update(["status"=>15,"pay_time"=>time()]);
            if( $pid ){
                //支付完成操作
                $proceeds = app_service("common","Proceeds");
                $proceeds->buy_proceeds($map["id"],"js");

                Db::name("Package")->where(array('id'=>$Arr['package_id']))->setInc('buy_sum');

                $retArr["result"] = 0;
                $retArr["msg"] = "操作成功";
            }else{
                $retArr["result"] = 3;
                $retArr["msg"] = "操作失败";
            }
            $this->json_return($retArr);
        }
    }


    //订单详情
    public function order_details(){

        $id = input('param.id');

        $Arr = Db::name("activation_orders")->alias("a")
            ->join("xls_user b","a.buy_id = b.id","left")
            ->join("xls_address c","c.id = a.address_id","left")
            ->field("a.*,b.nickname,c.name, c.mobile, c.postcode, c.details")
            ->where("a.id",$id)
            ->find();
        if( !empty($Arr["details"]) ){
            $Arr["details"] = str_replace(">","",$Arr["details"]);
        }

        $Arr["statusName"] = $this->statusName[$Arr["status"]];

        $this->assign("Arr",$Arr);
        return $this->fetch();
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

            $Arr = Db::name("activation_orders")->field("buy_id,use_cash,status")->where("id",$map["id"])->find();
            if( empty($Arr) || empty($Arr["status"]) ){
                $this->dataError = json_encode($map);
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }
            $pid = Db::name("activation_orders")->where("id",$map["id"])->update(["status"=>$status]);
            if( $pid ){
                Db::name("User")->where("id",$Arr["buy_id"])->setInc("cash",$Arr["use_cash"]);
                $retArr["result"] = 0;
                $retArr["msg"] = "操作成功";
            }else{
                $retArr["result"] = 3;
                $retArr["msg"] = "操作失败";
            }
            $this->json_return($retArr);
        }
    }


//修改发货
    public function save_status(){
        if( request()->isAjax() ){

            $data=input('post.');
            $Arr["status"] = $data["status"] ? $data["status"] : 25;

            $sum = Db::name("ActivationOrders")->where("id=".$data["id"])->update($Arr);
            if($sum){
                $retArr["result"] = 0;
            }else{
                $retArr["result"] = 4;
                $retArr["msg"] = "save_status error";
                $this->dataError = "uid=".UID."|".json_encode($retArr);
            }
            $this->json_return($retArr,"status");
        }
    }



}
