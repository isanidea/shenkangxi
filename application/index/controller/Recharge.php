<?php
namespace app\index\controller;

use app\common\controller\Base;
use app\common\controller\IndexBase;
use app\common\service\TransmitSms;
use think\Db;
use think\Session;


class Recharge extends  IndexBase
{


    public function index(){

        $this->titleName = "充值";
        return $this->fetch();
    }


    public function pay_order(){
        if( request()->isPost() ){

            $map = input("post.");
            if( !$this->data_verify($map,"money,pay_type") ){
                $this->error("操作错误");
            }

            $code = generateOrderCode("cz",$this->userInfo["id"]);
            $Arr = array(
                "order_code" => $code,
                "user_id" => $this->userInfo["id"],
                "money" => $map["money"],
                "pay_type" => $map["pay_type"],
                "c_time" => time(),
                "status" => 10,
            );
            $id = Db::name("Recharge")->insert($Arr,false,true);
            if( $id ){
                if( $map["pay_type"] == 1 ){
                    //线下支付
                    $this->redirect('Recharge/proof',array("id"=>$id));
                }else{
                    //线上支付

                }
            }else{
                $this->error("订单创建失败");
            }
        }
    }

    public function proof(){
        $map = input("param.");
        if( empty($map["id"])){
            $this->error("错误数据");
        }
        $price = Db::name("Recharge")->where("id",$map["id"])->value("money");

        //收款人信息
        $Arr = $this->configArr;

        $Arr["price"] = $price;
        $Arr["id"] = $map["id"];
        $this->titleName = "线下支付";
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }

    //支付凭证
    public function up_proof(){

        if( request()->isPost() ){
            $map = input("post.");
            $file = request()->file('file');
            if($file){
                $info = $file->move(ROOT_PATH . '../public' . DS . 'Uploader/Package/proof');
                if($info){
                    $imgUrl = '/Uploader/Package/proof/'.$info->getSaveName();
                    Db::name("Recharge")->where("id",$map["id"])->update(array("proof"=>$imgUrl,"status"=>15));
                    $this->redirect('Recharge/order_list');
                }else{
                    $this->error("上传支付凭证失败");
                }
            }
        }
    }

    //订单列表
    public function order_list(){
        $list = Db::name("Recharge")->where(array("status"=>["gt","0"],"user_id"=>$this->userInfo["id"]))->select();

        $this->assign("list",$list);
        $this->titleName = "充值记录";
        return $this->fetch();
    }
    //查看凭证
    public function examine(){

        $map = input("param.");
        if( empty($map["id"]) ){
            $this->error("错误数据");
        }
        $proof = Db::name("Recharge")->where("id",$map["id"])->value("proof");
        $this->assign("imgUrl",$proof);
        $this->titleName = "查看支付凭证";
        return $this->fetch();
    }

}
