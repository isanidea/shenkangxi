<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
use think\Session;
use \think\Request;

class Goods extends adminBase
{
	public function index(){
        $list = Db::name('goods')->select();
        $this->assign('list',$list);
		return $this->fetch();
	}
    

	public function add(){
        if(request()->isPost()){
            $data = input('post.');
            $data['addtime'] = time();
            $result = Db::name('goods')->insert($data);
//            var_dump($result);exit;
            if(!empty($result)){
                $this->redirect("Goods/index");
            }else{
                $this->error("添加失败");
            }
        }
	    return $this->fetch();
    }

    public function upload(){
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . '../public' . DS . 'Uploader/Goods');

            if($info){
                $retArr = [
                    "code"=>0,
                    "msg" => array("imgUrl" => '/Uploader/Goods/'.$info->getSaveName()),
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

    public function edit(){
        $id = input('param.');
        $data = Db::name('goods')->where($id)->select();
        if(request()->isPost()){
            $data = input('post.');
            $data['addtime'] = time();
            $result = Db::name('goods')->update($data);
//            var_dump($result);exit;
            if(!empty($result)){
                $this->redirect("Goods/index");
            }else{
                $this->error("修改失败");
            }
        }
//        dump($data);exit;
        $this->assign('data',$data);
        return $this->fetch("goods/edit");
    }

    public function delete(){
        $id = input('param.');
//        var_dump($id);exit;
        $result = Db::name('goods')->where($id)->delete();
        if(!empty($result)){
            $this->redirect("goods/index");
        }else{
            $this->error("删除失败");
        }
    }



	






}