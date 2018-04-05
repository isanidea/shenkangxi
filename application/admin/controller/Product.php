<?php
namespace app\admin\controller;
use app\common\controller\adminBase;
use think\Db;
use think\Session;

class Product extends adminBase
{

    public function index()
    {
        $where =["status"=>["gt",0]];

        $admin = app_model("admin","product");

        $list = $admin->getListPage($where);

        $this->assign("pagetotal",$this->getPageTotal($list));
        $this->assign("list",$list);
        /*
        [id] => 1
        [uid] => 1000
        [product_name] => 积分产品
        [stock] => 1000
        [img] => xxx
        [sort] => 90
        [product_details] => xxxxxxxxxxxxxxx
        [cost_jifen] => 100.00
        [sales_jifen] => 200.00
        [add_time] => 1522203243
        [status] => 10
         */
        return $this->fetch();
    }

    //商品编辑
    public function add(){

        $id = input('param.id');
        $Arr = [];
        if( !empty($id) ){
            $Arr = Db::name("product")->where("id",$id)->find();
        }

        $this->assign("Arr",$Arr);
        return $this->fetch("Product/edit");
    }

    //商品修改
    public function edit(){

        if( request()->isPost() ){

            $data=input('post.');
            unset($data["file"]);
            if( empty($data["id"]) ){
                $data["add_time"] = time();
            }
            $id = $this->insert_updata($data);
            if( $id ){
                $this->redirect('product/index', ['id' => $id]);
            }else{
                $this->error('编辑失败');
            }
        }

    }

    //套餐图片上传
    public function up_image(){

        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH.'./public' . DS . 'Uploader/Product');

            if($info){
                $retArr = [
                    "code"=>0,
                    "msg" => array("imgUrl" => '/Uploader/Product/'.$info->getSaveName()),
                ];
            }else{
                $retArr = [
                    "code"=>1,
                    "msg" => array("error" => $file->getError()),
                ];
                // 上传失败获取错误信息
//                echo $file->getError();
            }
            echo json_encode($retArr);
            exit();
        }
    }

}
