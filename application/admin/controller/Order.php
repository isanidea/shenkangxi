<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Cache;
use think\Db;

class Order extends adminBase
{
    public function index(){

        $map = input("param.");

        if( empty($map["status"]) ){
            $where = " p.status >= 0 ";
        }else{
            $where = " p.status = ".$map["status"];
        }


        if( !empty($map["start_time"]) ){

            $where .= " AND p.addtime >= ".strtotime($map["start_time"]);
        }
        if( !empty($map["end_time"]) ){
            if( empty($map["start_time"]) ){
                $time = time() - (60*60*24*7);
                $where .= " AND p.addtime >= ".$time;
            }
            $where .= " AND p.addtime <= ".strtotime($map["end_time"]);
        }

        if(!empty($map["ordernumber"])){
            $where = " p.ordernumber = '".$map["ordernumber"]."'";
        }

//            $count = Db::name("points_order")->alias("u")
//                ->where($where)
//                ->count();

        $lists = Db::name('User')
            ->alias('u')
            ->join('xls_points_order p','u.id = p.user_id','right')
            ->join('xls_goods g','g.id=p.goods_id')
            ->field("p.*,nickname,account,g.name")
            ->where($where)
            ->paginate();

        $page = $lists->render();
        $this->assign('page', $page);
        $this->assign("list",$lists);
        return $this->fetch();
    }


    public function edit(){
        $id = input('param.');

        $data = Db::table('xls_points_order')
            ->alias("po")
            ->join("xls_goods g","g.id=po.goods_id")
            ->join("xls_address a","a.id=po.address_id")
            ->join("xls_user u","u.id=po.user_id")
            ->where("po.id=".$id['id'])
            ->field("u.nickname,u.account,u.realname,a.name,a.mobile,a.postcode,a.details,g.name,po.id,po.remark,po.logistics,po.logi_number")
            ->find();
        $addr = str_replace('>',' ',$data['details']);

        if(request()->isAjax()){
            $d = input('post.');
            $d = array(
                'send_time' => time(),
                'status' => 10
            );
            $dd = input('post.id');
            $result = Db::name('points_order')->where('id',$dd)->update($d);
            if($result){
                $arr = [
                    'result' => 0,
                    'msg' => '发货成功',
                ];
            }else{
                $arr = [
                    'result' => 1007,
                    'msg' => '发货失败',
                ];
            }
            $this->json_return($arr);
        }

        $this->assign('data',$data);

        $this->assign('addr',$addr);
        return $this->fetch();
    }

    public function detail(){
        $id = input('param.');

        $data = Db::table('xls_points_order')
            ->alias("po")
            ->join("xls_goods g","g.id=po.goods_id")
            ->join("xls_address a","a.id=po.address_id")
            ->join("xls_user u","u.id=po.user_id")
            ->where("po.id=".$id['id'])
            ->field("u.nickname,u.account,u.realname,a.name,a.mobile,a.postcode,a.details,g.name,po.id,po.remark,po.logistics,po.logi_number")
            ->find();
        $addr = str_replace('>',' ',$data['details']);

        $this->assign('data',$data);

        $this->assign('addr',$addr);
        return $this->fetch();
    }


//    public function search(){
//
//        if(request()->isGet()){
//            $d = input('param.');
//            $start_time = strtotime($d['start_time']);
//            $end_time = strtotime($d['end_time']);
//
//            $where = Db::name('points_order')->whereTime('addtime', 'between', [$start_time,$end_time])->select();
//            dump($where);exit;
//
//            $count = Db::name("points_order")->alias("a")->where($where)->count();
//
//        }
//        $this->assign('addr',$count);
//        return $this->fetch();
//
//    }







}
