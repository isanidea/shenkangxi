<?php
namespace app\admin\controller;
use app\common\controller\adminBase;
use think\Db;
use think\Session;

class Package extends adminBase
{

    public function index()
    {
        $where =["status"=>["gt",0]];

        $admin = app_model("admin","package");

        $list = $admin->getListPage($where);

        $this->assign("pagetotal",$this->getPageTotal($list));
        $this->assign("list",$list);

        return $this->fetch();
    }

    //商品编辑
    public function add(){

        $id = input('param.id');
        $Arr = [];
        if( !empty($id) ){
            $Arr = Db::name("package")->where("id",$id)->find();
        }

        $this->assign("Arr",$Arr);
        return $this->fetch("Package/edit");
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

                $this->redirect('package/add', ['id' => $id]);
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
            $info = $file->move(ROOT_PATH.'./public' . DS . 'Uploader/Package');

            if($info){
                $retArr = [
                    "code"=>0,
                    "msg" => array("imgUrl" => '/Uploader/Package/'.$info->getSaveName()),
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
