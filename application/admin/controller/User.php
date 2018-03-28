<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
use think\Session;
use \think\Request;

class User extends adminBase
{
	public function index(){

        $map = input("param.");

        $where = " status >= 0 ";
        if(!empty($map["account"])){
            $where .= " AND account = '".$map["account"]."'";
            $Arr["account"] = $map["account"];
        }
        if(!empty($map["level"])){
            $where .= " AND level = ".$map["level"];
            $Arr["level"] = $map["level"];
        }
        if(!empty($map["level"])){
            $where .= " AND results >= ".$map["results"];
            $Arr["results"] = $map["results"];
        }
        if( !empty($map["start_time"]) ){

            $Arr["start_time"] = $map["start_time"];
            $where .= " AND addtime >= ".strtotime($map["start_time"]);
        }
        if( !empty($map["end_time"]) ){
            if( empty($map["start_time"]) ){
                $time = time() - (60*60*24*7);
                $where .= " AND addtime >= ".$time;
            }
            $Arr["end_time"] = $map["end_time"];
            $where .= " AND addtime <= ".strtotime($map["end_time"]);
        }


		$user = Db::name('user')
            ->where($where)
            ->paginate();

        $page = $user->render();
        $this->assign('page', $page);
		$this->assign('user',$user);
        $this->assign('Arr',$Arr);
		return $this->fetch();
	}

    //会员详情
    public function details(){

        $id = input('param.id');
        if( empty($id) ){
            $this->error("错误数据");
        }
        $Arr = Db::name('User')->where('id',$id)->find();


        $this->assign('Arr',$Arr);
        return $this->fetch();
    }

	public function edit(){
		$id = input('param.id');
		$data = Db::name('user')->where('id',$id)->find();

		if(request()->isAjax()){
		    $d = input('post.');
            $list = Db::name('user')->where('id',$d['id'])->update($d);
            if(!empty($list)){
                $arr = [
                    'result' => '0',
                    'msg' => '修改成功',
                ];
            }else{
                $arr = [
                    'result' => '1004',
                    'msg' => '修改失败',
                ];
            }
            $this->json_return($arr);
        }

		$this->assign('data',$data);
		return $this->fetch();
	}

//	public function delete(){
//		$id = input('param.');
////		var_dump($id);exit;
//		$result = Db::name('user')->where($id)->delete();
//		if(!empty($result)){
//		    $this->redirect("user/index");
//        }else{
//		    $this->error("删除失败");
//        }
//
//	}

	










}