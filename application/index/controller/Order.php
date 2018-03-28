<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use tool\TransmitSms;
use think\Db;
use think\Session;
use app\common\service\Proceeds;


class Order extends  IndexBase
{
    /**
     * [index description]测试用
     * @return [type] [description]
     */
    public function index(){
        $Proceeds = new Proceeds();
        $Proceeds->zhitui_jifen(1);

    }

    /**
     * [order description]
     * @return [type] [description]
     */
    public function order(){
        if( request()->isPost() ){
            $map = input('post.');
            $data = Db::name('package')->where('id',$map['pid'])->find();
            $address = Db::name("address")->where('user_id',$this->userInfo["id"])->select();
            foreach($address as $k=>$v){
                $address[$k]["details"] = str_replace(">"," ",$v["details"]);
            }
//            $acting = Db::name("userinfo")->where("user_id",$this->userInfo["id"])->value("acting");
            $this->titleName = "订单确认";
            $data["buy_num"] = $map["count"];
//            $this->assign("acting",$acting);
            $this->assign("address",$address);
            $this->assign('data',$data);
            return $this->fetch();
        }else{
            $this->error("订单错误");
        }
    }

    public function proof(){
        $map = input("param.");
        if( empty($map["id"])){
            $this->error("错误数据");
        }
        $price = Db::name("PackageOrder")->where("id",$map["id"])->value("total_price");

        //收款人信息
        $Arr = $this->configArr;

        $Arr["price"] = $price;
        $Arr["id"] = $map["id"];
        $this->titleName = "线下支付";
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }
    /*
     * 长传凭证提交处
     */
    public function up_proof(){
        if( request()->isPost()){
            $map = input('post.');
           $file =  $this->request->file('file');
           if($file){
               $info = $file ->move(ROOT_PATH.'../public'.DS.'Uploader/Shopping/proof');
               if($info){
                   $imgUrl = '/Uploader/Shopping/proof/'.$info->getSaveName();
                   Db::name("PackageOrder")->where("id",$map["id"])->update(array("proof"=>$imgUrl,"status"=>15));
                   $this->redirect('Order/order_list');
               }else{
                   $this->error("上传支付凭证失败");
               }
           }
        }
    }

    /*
     * 支付
     */
    public function pay(){
        if( request()->isPost() ) {
            $data = input('post.');

            if( !isset($data["pid"]) || empty($data['pid']) || !isset($data["address_id"]) || empty($data["address_id"]) || !isset($data["buy_sum"]) || empty($data["buy_sum"]) ){
                $this->error('数据有误');
            }

            $package = Db::name("package")->field("id,pname,sales_price,img")->where(array("id"=>$data["pid"],"status"=>10))->find();

            if( empty($package) ){
                $this->error('商品不存在');
            }

//            $userInfo = Db::name("user_details")->field("cash,jifen")->where("uid",$this->userInfo["id"])->find();

            $total_price = $package["sales_price"] * $data["buy_sum"];
//            if( $total_price >  $userInfo["cash"]  ){
//                $this->error('账户现金和奖金不够,请充值');
//            }
//            if( $total_price > $userInfo["integral"] ){
//                $integral = $userInfo["integral"];
//                $money = $total_price - $userInfo["integral"];
//            }else{
//                $integral = $total_price;
//                $money = "0.00";
//            }
//            $profit = $total_price - ($package['cost_price'] * $data['buy_sum']);

            $Arr = array(
                "order_no" => "sj".time().$this->userInfo["id"],
                "uid" => $this->userInfo["id"],
                "pid" => $data["pid"],
                "pname" => $package["pname"],
                "pimg" => $package["img"],
                "total_price" => $total_price,
                "buy_num" => $data["buy_sum"],
                "payway" => $data['pay_type'],
                "buy_time" => time(),
                "status" => 10,
            );

            $id = Db::name("PackageOrder")->insert($Arr,false,true);
            //acting 代金券
            if( $id ){
//                Db::name("userinfo")->where("user_id",$this->userInfo["id"])->update('jifen',);
                if(intval($data['pay_type']) === 1){
                    $this->redirect('Order/proof',array('id'=>$id));
                }
            }else{
                $this->error('订单创建失败');
            }
        }
    }


    //购买商品记录
    public function order_list(){

        $list = Db::name("PackageOrder")->where(array("status"=>["gt",0],"uid"=>$this->userInfo["id"]))->order('id desc')->select();

        $this->titleName = "我的商城订单";
        $this->assign("data",$list);
        return $this->fetch();
    }

###############################积分商城订单##################################################

    public function product_order(){
         $map  = input('param.');   
         dump($map);

    }


}
