<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use tool\TransmitSms;
use think\Db;
use think\Session;
use app\common\service\Proceeds;
use tool\Json;


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
               $info = $file ->move(ROOT_PATH.'public'.DS.'Uploader/Shopping/proof');
               if($info){
                   $imgUrl = '/Uploader/Shopping/proof/'.$info->getSaveName();
                   Db::name("PackageOrder")->where("id",$map["id"])->update(array("proof"=>$imgUrl,"status"=>10));
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
                'sales_price'=>$package['sales_price'],
                "total_price" => $total_price,
                "buy_num" => $data["buy_sum"],
                "payway" => $data['pay_type'],
                "buy_time" => time(),
                "status" => 6,
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

    /**
        //获取的参数
        array (size=2)
      'count' => string '4' (length=1)
      'product_id' => string '1' (length=1)
    //地址信息：
        'id' => int 20
      'user_id' => int 10000
      'name' => string '王波' (length=6)
      'phone' => string '15755654664' (length=11)
      'postcode' => string '246511' (length=6)
      'details' => string '湖北 黄石市 下陆区 4323423范德萨范德萨发 反倒是' (length=65)

    $data: 产品信息
        array (size=12)
      'id' => int 1
      'uid' => int 1000
      'product_name' => string '积分产品' (length=12)
      'stock' => int 1000
      'img' => string 'xxx' (length=3)
      'sort' => int 90
      'product_details' => string 'xxxxxxxxxxxxxxx' (length=15)
      'cost_jifen' => string '100.00' (length=6)
      'sales_jifen' => string '200.00' (length=6)
      'add_time' => int 1522203243
      'status' => int 10
      'buy_num' => string '4' (length=1)
     */
    public function product_order(){
         if( request()->isPost() ){
            $map = input('post.');
            $data = Db::name('product')->where('id',$map['product_id'])->find();
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

    /**
     *
        获取的参数：
     array (size=6)
      'remark' => string '' (length=0)
          'pay_type' => string '1' (length=1)
      'address_id' => string '19' (length=2)
      'product_id' => string '1' (length=1)
      'buy_sum'     => string '4' (length=1)
      'total_pric   e' => string '800' (length=3)*
        *
     */
    public function product_pay(){
         $render_json = new Json();
         if( request()->isPost() ) {
            $data = input('post.');

            if( !isset($data["product_id"]) || empty($data['product_id']) || !isset($data["address_id"]) || empty($data["address_id"]) || !isset($data["buy_sum"]) || empty($data["buy_sum"]) ){
                $render_json->status = 1;
                $render_json->msg = "参数有误";
                $render_json->tojson();
            }

            $product = Db::name("product")->where(array("id"=>$data["product_id"],"status"=>10))->find();

            if( empty($product) ){
                $render_json->status = 2;
                $render_json->msg = "商品不存在";
                $render_json->tojson();
            }


            $total_jifen = $product["sales_jifen"] * $data["buy_sum"];
            $uid = $this->userInfo['id'];
            /*
            id' => int 10000
              'username' => string 'wangbo' (length=6)
              'last_login_time' => int 1522123418
             */
            $userInfo = Db::name('user_details')->where('uid',$uid)->find();
            /* userInfo:
            array (size=17)
                  'id' => int 1
                  'uid' => int 10000
                  'pid' => int 0
                  'username' => string 'wangbo' (length=6)
                  'manage_lever' => int 1
                  'lever' => int 1
                  'total_yeji' => string '0.00' (length=4)
                  'total_profit' => string '0.00' (length=4)
                  'jifen' => string '0.00' (length=4)
                  'jifen_total' => string '0.00' (length=4)
                  'vip_num' => int 0
                  'jl_num' => int 0
                  'zj_num' => int 0
                  'bonus' => string '0.00' (length=4)
                  'cash' => string '0.00' (length=4)
                  'status' => int 1
                  'add_time' => int 1521623612
             */
           if( $total_jifen >  $userInfo["jifen"]  ){
                $render_json->status = 3;
                $render_json->msg = "积分不够";
                $render_json->tojson();

           }
            $update_jifen = Db::name('user_details')->where('uid',$this->userInfo['id'])->setDec('jifen',$total_jifen);
            if(empty($update_jifen)){
                $render_json->status = 4;
                $render_json->msg = "扣除积分失败";
                $render_json->tojson();
            }
            $Arr = array(
                "order_no" => "jf".time().$this->userInfo["id"],
                "uid" => $this->userInfo["id"],
                "product_id" => $product["id"],
                "product_name" => $product["product_name"],
                'product_jifen'=>$product['sales_jifen'],
                "total_jifen" => $total_jifen,
                "buy_num" => $data["buy_sum"],
                "payway" => $data['pay_type'],
                "add_time" => time(),
                "f_time"=>time(),
                "status" => 6,//待审核
            );
            /*
            'order_no' => string 'jf152291857210000' (length=17)
            'uid' => int 10000
            'product_id' => int 1
            'product_name' => string '积分产品' (length=12)
            'total_jifen' => float 400
            'product_num' => string '2' (length=1)
            'payway' => string '1' (length=1)
            'add_time' => int 1522918572
            'f_time' => int 1522918572
            'status' => int 10
             */

            $id = Db::name("productOrder")->insert($Arr,false,true);
            //acting 代金券
            if( $id ){
                $render_json->status = 0;
                $render_json->msg = "订单创建成功";
                $this->redirect('product_order_list');
                $render_json->tojson();
                }else{
                $render_json->status = 5;
                $render_json->msg = "订单创建失败";
                $render_json->tojson();
            }
          }
    }

    /*
    'order_id' => int 17
  'order_no' => string 'jf152222442410000' (length=17)
  'uid' => int 10000
  'product_id' => int 1
  'product_name' => string '积分产品' (length=12)
  'product_num' => int 4
  'product_jifen' => string '0.00' (length=4)
  'total_jifen' => string '800.00' (length=6)
  'payway' => int 1
  'add_time' => int 1522224424
  'status' => int 1
     */
    public function product_order_list(){

        $list = Db::name("productOrder")->where(array("status"=>["gt",0],"uid"=>$this->userInfo["id"]))->order('id desc')->select();
        $this->titleName = "我的商城订单";
        $this->assign("data",$list);
        return $this->fetch();

    }


    ###################################小商品########################3
    /*
      'count' => string '7' (length=1)
      'goods_id' => string '1' (length=1)
     */
    public function goods_order(){
           if( request()->isPost() ){
            $map = input('post.');
             $goods_info = Db::name('goods')->where('id',$map['id'])->find();
            $address = Db::name("address")->where('user_id',$this->userInfo["id"])->select();
            foreach($address as $k=>$v){
                $address[$k]["details"] = str_replace(">"," ",$v["details"]);
            }
//            $acting = Db::name("userinfo")->where("user_id",$this->userInfo["id"])->value("acting");
            $this->titleName = "订单确认";
            $goods_info["buy_num"] = $map["count"];
//            $this->assign("acting",$acting);
           $this->assign("address",$address);
            $this->assign('data',$goods_info);
            return $this->fetch();
        }else{
            $this->error("订单错误");
        }
    }

    /*
    'remark' => string '' (length=0)
      'pay_type' => string '1' (length=1)
      'address_id' => string '19' (length=2)
      'id' => string '1' (length=1)
      'buy_sum' => string '3' (length=1)
      'total_price' => string '60' (length=2)
     */
    public function goods_pay(){
        //插入订单
        $map = input('param.');
        if($map['pay_type'] == 1){
            $goods_info = Db::name("goods")->where(array("id"=>$map["id"],"status"=>10))->find();
            $total_price = $map['buy_sum']*$goods_info['sales_price'];

            $Arr = array(
                "order_no" => "sj".time().$this->userInfo["id"],
                "uid" => $this->userInfo["id"],
                "goods_id" => $goods_info["id"],
                "address_id"=>$map['address_id'],
                'goods_price'=>$goods_info['sales_price'],
                "goods_name" => $goods_info["goods_name"],
                "total_price" => $total_price,
                "buy_num" => $map["buy_sum"],
                "payway" => $map['pay_type'],
                "add_time" => time(),
                "status" => 6,//待支付
            );

            $id = Db::name("goodsOrder")->insert($Arr,false,true);
            if($id){
                    $this->redirect('Order/goods_proof',array('id'=>$id));
                }
            }

        }


    public function goods_proof(){
          $map = input("param.");
        if( empty($map["id"])){
            $this->error("错误数据");
        }
        $price = Db::name("goodsOrder")->where("id",$map["id"])->value("total_price");

        //收款人信息
        $Arr = $this->configArr;

        $Arr["price"] = $price;
        $Arr["id"] = $map["id"];
        $this->titleName = "线下支付";
        $this->assign("Arr",$Arr);
        return $this->fetch();
    }
    /*
     * 上传凭证提交处
     */
    public function goods_up_proof(){
        if( request()->isPost()){
            $map = input('post.');
           $file =  $this->request->file('file');
           if($file){
               $info = $file ->move(ROOT_PATH.'public'.DS.'Uploader/goods/proof');
               if($info){
                   $imgUrl = '/Uploader/goods/proof/'.$info->getSaveName();

                   Db::name("goodsOrder")->where("id",$map["id"])->update(array("proof"=>$imgUrl,"status"=>10));
                   $this->redirect('Order/goods_order_list');
               }else{
                   $this->error("上传支付凭证失败");
               }
           }
        }
    }

    public function goods_order_list(){

        $list = Db::name("goodsOrder")->where(array("status"=>["gt",0],"uid"=>$this->userInfo["id"]))->order('id desc')->select();
        $this->titleName = "我的商城订单";
        $this->assign("data",$list);
        return $this->fetch();

    }













}
