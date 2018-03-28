<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
use think\Session;
use \think\Request;

class Brokerage extends adminBase
{
    public $Brokerage;

    public function _initialize() {
        parent::_initialize();

        $this->Brokerage = app_model("admin","Brokerage");
    }

    public function index(){

//        $Arr = Db::name("User")->where("id=37")->find();
//        unset($Arr["id"]);
//        for($i=0;$i<10;++$i){
//            $Arr["account"] = $Arr["account"] +$i +100;
//            Db::name("User")->insert($Arr);
//        }
//
//        $proceeds = app_service("common","Proceeds");
//        $proceeds->buy_proceeds("24","gw");

        exit();
    }

    //直推奖励
    public function direct(){

        $Arr = $this->Brokerage->getList("id,val","direct",false);

        $this->assign("Arr",$Arr);
        return $this->fetch();
    }

    //分享
    public function share(){

        $list = $this->Brokerage->getList("id,key,val,one_requirement,two_requirement","share");
        foreach($list as $k=>$v){
            $list[$k]["keyNmae"] = $this->_number_large($v["key"]);
        }
        $this->assign("list",$list);
        return $this->fetch();
    }

    //管理奖励
    public function supervise(){

        $list = $this->Brokerage->getList("id,key,val,one_requirement,two_requirement","supervise");
        foreach($list as $k=>$v){
            $list[$k]["keyNmae"] = $this->_number_large($v["key"]);
        }
        $this->assign("list",$list);
        return $this->fetch();
    }


    //平级奖励
   public function pyji(){
         $list = $this->Brokerage->getList("id,key,val","pyji");
        foreach($list as $k=>$v){
            $list[$k]["keyNmae"] = $this->_number_large($v["key"]);
        }
        $this->assign("list",$list);
        return $this->fetch();
    }

    //收益分配
    public function profit(){
        $list = $this->Brokerage->getList("id,key,val","profit");
        foreach($list as $k=>$v){
            $list[$k]["keyNmae"] = $this->_profit_name($v["key"]);
        }
        $this->assign("list",$list);
        return $this->fetch();
    }

    //股东分红
    public function stockholder(){

        if( request()->isAjax() ){

            $data = input("post.");

            if( !isset($data["countPrice"]) || empty($data["countPrice"]) ){
                $retArr["result"] = 1;
                $retArr["msg"] = "请选择分红金额";
                $this->json_return($retArr);
            }

            $proceeds = app_service("common","Proceeds");
            $proceeds->stockholder_bonus($data["countPrice"]);

            $retArr["result"] = 0;
            $retArr["msg"] = "股东分红成功";
            $this->json_return($retArr);
        }

        $Arr = $this->Brokerage->getList("id,val","stockholder",false);
        //总业绩
        $pwhere = " status = 15";
        if( request()->isGet() ){

            $map = input('get.');
            if( !empty($map["start_time"]) ){
                $Arr["start_time"] = $map["start_time"];
                $pwhere .= " AND start_time >= ".strtotime($map["start_time"]);
            }
            if( !empty($map["end_time"]) ){
                $Arr["end_time"] = $map["end_time"];
                if( empty($map["start_time"]) ){
                    $time = time() - (60*60*24*30);
                    $Arr["end_time"] = date("Y-m-d H:m:s",$time);
                    $pwhere .= " AND start_time >= ".$time;
                }
                $pwhere .= " AND start_time <= ".strtotime($map["end_time"]);
            }
        }
        $countPrice[0] = Db::name("PackageOrder")->where($pwhere)->sum("price");
        $countPrice[1] = Db::name("ActivationOrders")->where($pwhere)->sum("price");
        $Arr["countPrice"] = $countPrice[0] + $countPrice[1];

        //股东人数
        $list = Db::name("User")->field("id,mobile,realname,level,addtime,zhitui,results")->where(array("star_level"=>4,"status"=>["gt","0"]))->select();
        $Arr["count"] = count($list);

        $this->assign("list",$list);
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }

    //编辑
    public function edit(){

        if( request()->isAjax() ){
            $map = input("post.");
            $data = [];
            $type = 1;
            foreach($map as $k=>$v){
                if( strpos($k,"-") !== false ){
                    //多条
                    $type = 2;
                    $Arr = explode("-",$k);
                    $data[$Arr[0]][$Arr[1]] = $v;
                }else{
                    //单条
                    $data[$k] = $v;
                }
            }

            if( $type == 1 ){

                $this->Brokerage->update($data);
            }else{

                $this->Brokerage->isUpdate()->saveAll($data);
            }

            $retArr["result"] = 0;
            $retArr["msg"] = "编辑成功";
            $this->json_return($retArr);

        }

    }


    //
    private function _number_large($num){
        $newNum = "一";
        switch ($num)
        {
            case 1:
                $newNum = "一";
                break;
            case 2:
                $newNum = "二";
                break;
            case 3:
                $newNum = "三";
                break;
            case 4:
                $newNum = "四";
                break;
            case 5:
                $newNum = "五";
                break;
            case 6:
                $newNum = "六";
                break;
            case 7:
                $newNum = "七";
                break;
            case 8:
                $newNum = "八";
                break;
            case 9:
                $newNum = "九";
                break;
        }
        return $newNum;
    }
    private function _profit_name($str){

        switch ($str)
        {
            case "cash":
                $newNum = "提现";
                break;
            case "integral":
                $newNum = "重消";
                break;
            case "fund":
                $newNum = "基金";
                break;
            case "poundage":
                $newNum = "手续费";
                break;
        }
        return $newNum;
    }



}