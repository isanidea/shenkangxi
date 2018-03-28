<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;

class Proceeds extends adminBase
{


    public function index()
    {

        if( request()->isAjax() ){
            $map = input("param.");
            $where = "";
            if( empty($map["type"]) ){
                $where = " a.type = 5 ";
            }else{
                if( $map["type"] == 1 ){
                    $where = "a.type = 5 ";
                }elseif( $map["type"] == 2 ){

                    $where = "a.type >= 10  AND a.type <= 50 ";
                }elseif( $map["type"] == 3 ){

                    $where = "a.type >= 55  AND a.type <= 65 ";
                }elseif( $map["type"] == 4 ){

                    $where = "a.type >= 70  AND a.type <= 85 ";
                }
            }

            if(!empty($map["user_id"])){
                $where .= " AND a.user_id = ".$map["user_id"];
            }
            if( !empty($map["start_time"]) ){

                $where .= " AND a.c_time >= ".strtotime($map["start_time"]);
            }
            if( !empty($map["end_time"]) ){
                if( empty($map["start_time"]) ){
                    $time = time() - (60*60*24*7);
                    $where .= " AND a.c_time >= ".$time;
                }
                $where .= " AND a.c_time <= ".strtotime($map["end_time"]);
            }

            $count = Db::name("ProceedsLog")->alias("a")
                ->where($where)
                ->count();

            $limitForm = ( $map["page"] -1 )* $map["limit"];
            $list = Db::name("ProceedsLog")->alias("a")
                ->join("xls_user b","a.user_id = b.id","left")
                ->field("a.id, a.user_id,a.level, a.total_money, a.cash, a.integral, a.fund, a.poundage, a.scale, a.c_time, b.realname")
                ->where($where)
                ->order("a.id desc")
                ->limit($limitForm,$map["limit"])
                ->select();
            $data = [];
            foreach($list as $k=>$v){
                $data[$k]["id"] = $v["id"];
                $data[$k]["user_id"] = $v["user_id"];
                $data[$k]["nickname"] = $v["realname"];
                $data[$k]["level"] = $v["level"];
                $data[$k]["total_money"] = $v["total_money"];
                $data[$k]["cash"] = $v["cash"];
                $data[$k]["integral"] = $v["integral"];
                $data[$k]["fund"] = $v["fund"];
                $data[$k]["poundage"] = $v["poundage"];
                $data[$k]["scale"] = $v["scale"];
                $data[$k]["c_time"] = date('y-m-d H:i:s', $v["c_time"]);
            }

            $retArr = [
                "code"=>0,
                "msg" => "",
                "count" => $count,
                "data" => $data
            ];
            echo json_encode($retArr);
            exit();
        }
        $map = input('param.');
        $url = '/admin/Proceeds/index';
        $Arr = [];
        if( empty($map["type"]) ){
            $url.="?type=1";
            $Arr["type"] = 1;
        }else{
            $url.="?type=".$map["type"];
            $Arr["type"] = $map["type"];
        }
        if( !empty($map["user_id"]) ){
            $url.="&user_id=".$map["user_id"];
            $Arr["user_id"] = $map["user_id"];
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
        return $this->fetch();
    }


}
