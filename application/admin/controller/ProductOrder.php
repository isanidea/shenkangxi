<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
use think\Session;

class ProductOrder extends adminBase
{

    public $statusName = [
        "5" => "驳回",
        '10'=>'待审核',
        "20" => "已完成",
    ];

    //订单列表
    public function order()
    {


        if( request()->isAjax() ){

            $map = input("param.");

            if( empty($map["status"]) ){
                $where = " status > 0 ";
            }else{
                $where = " status = ".$map["status"];
            }

            if( !empty($map["start_time"]) ){

                $where .= " AND buy_time >= ".strtotime($map["start_time"]);
            }
            if( !empty($map["end_time"]) ){
                if( empty($map["start_time"]) ){
                    $time = time() - (60*60*24*7);
                    $where .= " AND buy_time >= ".$time;
                }
                $where .= " AND buy_time <= ".strtotime($map["end_time"]);
            }

            if( !empty($map["order_on"]) ){

                $where = " order_on = '".$map["order_on"]."'";

            }


            $count = Db::name("productOrder")->where($where)->count();


            $limitForm = ( $map["page"] -1 )* $map["limit"];
            $list = Db::name("productOrder")
                ->where($where)
                ->order("id desc")
                ->limit($limitForm,$map["limit"])
                ->select();
            $data = [];
            foreach($list as $k=>$v){
                $data[$k]["id"] = $v["id"];
                $data[$k]["order_no"] = $v["order_no"];
                $data[$k]["uid"] = $v["uid"];
                $data[$k]["product_name"] = $v["product_name"];
                $data[$k]["total_jifen"] = $v["total_jifen"];
                $data[$k]["buy_num"] = $v["buy_num"];
                $data[$k]["buy_time"] = date('y-m-d H:i:s', $v["buy_time"]);
                $data[$k]["statusName"] = $this->statusName[$v["status"]];
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
            $url = '/index.php/admin/ProductOrder/order';
            $Arr = [];
            if( empty($map["status"]) ){
                $url.="?status=0";
            }else{
                $url.="?status=".$map["status"];
                $Arr["status"] = $map["status"];
            }


            if( !empty($map["start_time"]) ){
                $url.="&start_time=".$map["start_time"];
                $Arr["start_time"] = $map["start_time"];
            }
            if( !empty($map["end_time"]) ){
                $url.="&end_time=".$map["end_time"];
                $Arr["end_time"] = $map["end_time"];
            }
            if( !empty($map["order_no"]) ){
                $url.="&order_no=".$map["order_no"];
                $Arr["order_no"] = $map["order_no"];
            }

            $this->assign("Arr",$Arr);
            $this->assign("url",$url);
        }

        $this->assign("statusName",$this->statusName);
        return $this->fetch();
    }


    //订单详情
    public function details(){

        $id = input('param.id');
        if( empty($id) ){
            $this->error("缺少ID");
        }

        $Arr = Db::name("productOrder")->alias("a")
            ->join("skx_user b","a.uid = b.id","left")
            ->join("skx_address c","c.user_id = a.uid","left")
            ->field("a.*,b.nickname,c.name, c.phone, c.postcode, c.details")
            ->where("a.id",$id)
            ->find();
            /*
            'id' => int 22
              'order_no' => string 'jf152283510210000' (length=17)
              'uid' => int 10000
              'product_id' => int 1
              'product_name' => string '积分产品' (length=12)
              'product_num' => int 8
              'product_jifen' => string '0.00' (length=4)
              'buy_num' => int 0
              'buy_time' => int 0
              'payway' => int 1
              'total_jifen' => string '1600.00' (length=7)
              'add_time' => int 1522835102
              'express_code' => string '' (length=0)
              'express_name' => string '' (length=0)
              'f_time' => int 1522835102
              'status' => int 10
              'nickname' => string 'wangbo' (length=6)
              'name' => string '王波' (length=6)
              'phone' => string '15755654774' (length=11)
              'postcode' => string '246511' (length=6)
              'details' => string '安徽>马鞍山市>当涂县>4323423范德萨范德萨发 反倒是rewr' (length=72)
             */
        $Arr["details"] = str_replace(">","",$Arr["details"]);
        $Arr["statusName"] = $this->statusName[$Arr["status"]];
        /*
        
            [id] => 9
            [order_no] => sj152221011610000
            [pid] => 1
            [uid] => 10000
            [pname] => 炸药包
            [pimg] => http://skx.com/index.php/public/static/qiantai/img/rx.png
            [buy_num] => 2
            [sales_price] => 0.00
            [total_price] => 20000
            [payway] => 1
            [proof] => 
            [addres_id] => 0
            [buy_time] => 1522210116
            [status] => 10
            [nickname] => wangbo
            [name] => 王波
            [phone] => 15755654774
            [postcode] => 246511
            [details] => 安徽马鞍山市当涂县4323423范德萨范德萨发 反倒是rewr
            [statusName] => 待上传
         */
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }

    //订单发货
    public function order_fh(){

        if( request()->isAjax() ){
            $map = input("post.");
            /*
            [id] => 8
    [express_code] => dfsf
    [express_name] => fas
             */
            if( !isset($map["id"]) || !isset($map["express_code"]) || !isset($map["express_name"]) || empty($map["id"]) || empty($map["express_code"]) || empty($map["express_name"]) ){
                $retArr["result"] = 1;
                $retArr["msg"] = "数据有误";
                $this->json_return($retArr);
            }

            $Arr["express_code"] = $map["express_code"];
            $Arr["express_name"] = $map["express_name"];
            $Arr["status"] = 20;
            $Arr["pay_time"] = time();
            $Arr["f_time"] = time();

            $id = Db::name("ProductOrder")->where("id",$map["id"])->update($Arr);
            if( $id ){
                $retArr["result"] = 0;
                $retArr["msg"] = "操作成功";
            }else{
                $retArr["result"] = 1;
                $retArr["msg"] = "操作失败";
            }
            $this->json_return($retArr);
        }
    }

    public function order_del(){

        if( request()->isAjax() ){

            $map = input("post.");
            if( empty($map["id"]) ){
                $retArr = [
                    "id" => 1,
                    "msg" => "操作有误1"
                ];
                $this->json_return($retArr);
            }
             $orderArr = Db::name("productOrder")->field("total_jifen,uid,status")->where("id",$map["id"])->find();
            if( empty($orderArr) || $orderArr["status"]==5 || $orderArr["status"]== 20 ){
                $retArr = [
                    "id" => 2,
                    "msg" => "操作有误2"
                ];
                $this->json_return($retArr);
            }

            $pd = Db::name("productOrder")->where("id",$map["id"])->update(array("status"=>5));

            if( $pd ){
                Db::name("user_details")->where("uid",$orderArr["uid"])->setInc("jifen",$orderArr["total_jifen"]);
                $retArr = [
                    "id" => 0,
                    "msg" => "操作成功"
                ];
            }else{
                $retArr = [
                    "id" => 3,
                    "msg" => "操作失败3"
                ];
            }

            $this->json_return($retArr);

        }
    }


}
