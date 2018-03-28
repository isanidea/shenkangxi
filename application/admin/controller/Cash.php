<?php
namespace app\admin\controller;

use app\common\controller\Base;
use app\common\controller\adminBase;
use app\common\service\TransmitSms;
use think\Db;
use think\Paginator;


class Cash extends  adminBase
{

    public function index(){

        $map = input("param.");

        if( empty($map["status"]) ){
            $where = " a.status >= 0 ";
        }else{
            $where = " a.status = ".$map["status"];
        }

        if(!empty($map["card_num"])){
            $where .= " AND b.card_num = ".$map["card_num"];
        }
        if( !empty($map["start_time"]) ){

            $where .= " AND a.cash_time >= ".strtotime($map["start_time"]);
        }
        if( !empty($map["end_time"]) ){
            if( empty($map["start_time"]) ){
                $time = time() - (60*60*24*7);
                $where .= " AND a.cash_time >= ".$time;
            }
            $where .= " AND a.cash_time <= ".strtotime($map["end_time"]);
        }

        $data = Db::name("cash_record")
        ->alias("a")
        ->join("xls_bank_card b","a.bank_card_id = b.id")
        ->field("b.*,a.id,a.status,a.money,a.cash_time,a.pay_time")
        ->where($where)
        ->paginate();
//        ->select();
        $page = $data->render();

        $this->assign('page', $page);
        $this->assign("data",$data);
        return $this->fetch();
    }



    public function edit(){

        if( request()->isAjax() ){

            $da = input('post.');
            if( empty($da["id"]) ){
                $retArr = [
                    "result" => 1,
                    "msg" => "非法数据",
                ];
                $this->dataError = "uid=".UID."|".json_encode($da);
                $this->json_return($retArr);
            }
            $data = array(
                'pay_time' => time(),
                'status' => $da['status']
            );

            $result = Db::name('cash_record')->where("id",$da['id'])->update($data);

            if($result){

                if( $da['status'] == 5 ){
                    //驳回
                    $Arr = Db::name('cash_record')->field("money,user_id")->where("id",$da['id'])->find();
                    Db::name("User")->where("id",$Arr["user_id"])->setInc("cash",$Arr["money"]);
                }
                $arr = [
                    'result' => 0,
                    'msg' => '操作成功',
                ];
            }else{
                $arr = [
                    'result' => 1004,
                    'msg' => '操作失败',
                ];
            }
            $this->json_return($arr);
        }
    }



    public function setting(){
        if( request()->isAjax()){
            $data = input('post.');
            $result = Db::name('double')->where('id',$data['id'])->update($data);
            if($result){
                $arr = [
                    'result' => 0,
                    'msg' => '设置成功',
                ];
            }else{
                $arr = [
                    'result' => 1004,
                    'msg' => '设置失败',
                ];
            }
            $this->json_return($arr);
        }

        $list = Db::name('double')->find();
        $this->assign('list',$list);
        return $this->fetch();
    }






}
