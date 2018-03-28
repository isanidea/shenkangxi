<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use think\Db;
use think\Session;
use tool\json;

class product extends IndexBase
{
    public function index(){

        $list = Db::name('product')->where('status',10)->order('sort desc')->select();

        $this->titleName = "积分兑换商品列表";

        $this->assign('list',$list);

        return $this->fetch();
    }

    /**
    $data:
     * array (size=11)
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
     * @return [type] [description]
     */
    public function details()
    {
        $id = input('param.id');
        if( empty($id) ){
            $this->error("此商品已下架");
        }
        $data = Db::name('product')->where("id",$id)->find();
        if( empty($data) ){
            $this->error("此商品已下架");
        }

        $this->titleName = "商品详情";
        $this->assign('data',$data);
        return $this->fetch();
    }


    //订单提交
    public function package_order(){
        $pid = input("param.good_id");
       $count =  input('param.count');
//       if(intval($count) == 0 ){
//           $this->error("商品数量不能为0");
//       }
        if( isset($pid) && !empty($pid) ){
            $Arr = Db::name("package")->where(array("status"=>1,"id"=>$pid))->find();
            if( empty($Arr) ){
                $this->redirect('Package/index');
            }

            $addressList = Db::name("Address")->where(array("status"=>["gt",0],"user_id"=>$this->userInfo["id"]))->select();
            foreach($addressList as $k=>$v){
                $addressList[$k]["details"] = str_replace(">","",$v["details"]);
            }
            $total = $count * $Arr['sales_price'];
            $this->assign('total',$total);
            $this->assign("addressList",$addressList);
            $this->assign("Arr",$Arr);
        }else{
            $this->redirect('Package/index');
        }
        $this->titleName = "结算信息";
        return $this->fetch();
    }





}