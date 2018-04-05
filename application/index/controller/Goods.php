<?php
namespace app\index\controller;

use app\common\controller\IndexBase;
use think\Db;
use think\Session;
use tool\json;

class Goods extends IndexBase
{

    public function index(){

        $list = Db::name('goods')->where('status',10)->order('sort desc')->select();

        $this->titleName = "小商品";
        $this->assign('list',$list);

        return $this->fetch();
    }

    /*
    'id' => int 1
  'goods_name' => string '小商品' (length=9)
  'cost_price' => string '10.00' (length=5)
  'sales_price' => string '20.00' (length=5)
  'img' => string 'xxx' (length=3)
  'goods_detais' => string '' (length=0)
  'stock' => int 1000
  'status' => int 1
  'sort' => int 1
  'add_time' => int 1522229304
     */
    public function details()
    {
        $id = input('param.id');
        if( empty($id) ){
            $this->error("此商品已下架");
        }
        $data = Db::name('goods')->where("id",$id)->find();
        if( empty($data) ){
            $this->error("此商品已下架");
        }

        $this->titleName = "商品详情";
        $this->assign('data',$data);
        return $this->fetch();
    }








}
