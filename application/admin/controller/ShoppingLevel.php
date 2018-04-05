<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
class ShoppingLevel extends adminBase
{


    public function index()
    {
        $list = Db::name("ShoppingLevel")->select();
        $this->assign("list",$list);
        return $this->fetch();
    }

    public function edit(){
        if( request()->isPost() ){
            $data=input('post.');

            $id = $this->insert_updata($data);
            if( $id ){

                $this->redirect('ShoppingLevel/index');
            }else{
                $this->error('编辑失败');
            }
        }else{

            $id=input("param.id");
            // if( empty($id) ){

            //     return $this->success('请选择消费级别',url('ShoppingLevel/index'));
            // }
            $Arr = Db::name("ShoppingLevel")->where("id",$id)->find();
            $this->assign("Arr",$Arr);


            $this->assign("submitUrl",url("ShoppingLevel/edit"));
            return $this->fetch();
        }
    }

}
