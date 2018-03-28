<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Cache;
use think\Db;
class Package extends adminBase
{

    public $statusName = [
        "5" => "未支付",
        "10" => "已上传凭证",
        "15" => "已付款",
        "20" => "已发货",
    ];

    public function index()
    {

        $list = Db::name("package")->select();

        $this->assign("list",$list);
        return $this->fetch();
    }


    //修改
    public function edit(){

        if( request()->isPost() ){
            $data=input('post.');
            unset($data["file"]);
            $id = $this->insert_updata($data);
            if( $id ){

                $this->redirect('Package/edit', ['id' => $data["id"]]);
            }else{
                $this->error('编辑失败');
            }
        }else{

            $id=input("param.id");
            if( isset($id) && !empty($id)){
                $packageList = [];
                $Arr = Db::name("Package")->where("id",$id)->find();
                $this->assign("Arr",$Arr);
            }else{
                $packageList = Db::name("package")->field("id,lv_name")->select();
            }

            $this->assign("packageList",$packageList);
            $this->assign("submitUrl",url("Package/edit"));
            return $this->fetch();
        }
    }

    //套餐图片上传
    public function up_image(){

        $file = request()->file('file');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . '../public' . DS . 'Uploader/Package');

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

    //套餐订单列表
    public function order(){

        if( request()->isAjax() ){

            $map = input("param.");

            if( empty($map["status"]) ){
                $where = " a.status > 0 ";
            }else{
                $where = " a.status = ".$map["status"];
            }

            if( !empty($map["start_time"]) ){

                $where .= " AND a.start_time >= ".strtotime($map["start_time"]);
            }
            if( !empty($map["end_time"]) ){
                if( empty($map["start_time"]) ){
                    $time = time() - (60*60*24*7);
                    $where .= " AND a.start_time >= ".$time;
                }
                $where .= " AND a.start_time <= ".strtotime($map["end_time"]);
            }

            if( !empty($map["order_code"]) ){

                $where = "a.order_code = '".$map["order_code"]."'";
            }


            $count = Db::name("PackageOrder")->alias("a")
                ->where($where)
                ->count();


            $limitForm = ( $map["page"] -1 )* $map["limit"];
            $list = Db::name("PackageOrder")->alias("a")
                ->join("xls_user b","a.user_id = b.id","left")
                ->field("a.id, a.order_code, a.user_id, a.lv_name, a.price, a.start_time, a.pay_type, a.integral, a.order_type, a.status, b.nickname")
                ->where($where)
                ->order("a.id desc")
                ->limit($limitForm,$map["limit"])
                ->select();
            $data = [];
            foreach($list as $k=>$v){
                $data[$k]["id"] = $v["id"];
                $data[$k]["order_code"] = $v["order_code"];
                $data[$k]["user_id"] = $v["user_id"];
                $data[$k]["lv_name"] = $v["lv_name"];
                $data[$k]["price"] = $v["price"];
                $data[$k]["start_time"] = date('y-m-d H:i:s', $v["start_time"]);
                $data[$k]["pay_type"] = $v["pay_type"] == 1 ? "线下" : "线上";
                $data[$k]["integral"] = $v["integral"];
                $data[$k]["order_type"] = $v["order_type"] == 5 ? "购买会员" : "会员生级";
                $data[$k]["statusName"] = $this->statusName[$v["status"]];
                $data[$k]["nickname"] = $v["nickname"];
                $data[$k]["statusVal"] = $v["status"];
            }

            $retArr = [
                "code"=>0,
                "msg" => "",
                "count" => $count,
                "data" => $data
            ];
            echo json_encode($retArr);
            exit();
        }else{
            $map = input('param.');
            $url = '/admin/Package/order';
            $Arr = [];
            if( empty($map["status"]) ){
                $url.="?status=0";
            }else{
                $url.="?status=".$map["status"];
                $Arr["status"] = $map["status"];
            }
            if( !empty($map["order_code"]) ){
                $url.="&order_code=".$map["order_code"];
                $Arr["order_code"] = $map["order_code"];
            }

            if( !empty($map["start_time"]) ){
                $url.="&start_time=".$map["start_time"];
                $Arr["start_time"] = $map["start_time"];
            }
            if( !empty($map["end_time"]) ){
                $url.="&end_time=".$map["end_time"];
                $Arr["end_time"] = $map["end_time"];
            }

            $this->assign("Arr",$Arr);
            $this->assign("url",$url);
        }
        return $this->fetch();
    }

    //订单详情
    public function order_details(){

        $id = input('param.id');

        $Arr = Db::name("PackageOrder")->alias("a")
            ->join("xls_user b","a.user_id = b.id","left")
            ->join("xls_address c","c.id = a.address_id","left")
            ->field("a.*,b.nickname,c.name, c.mobile, c.postcode, c.details")
            ->where("a.id",$id)
            ->find();
        $Arr["details"] = str_replace(">","",$Arr["details"]);
        $Arr["statusName"] = $this->statusName[$Arr["status"]];

        $this->assign("Arr",$Arr);
        return $this->fetch();
    }

    //确认支付
    public function affirm_puy(){

        if( request()->isAjax() ) {

            $map = input("post.");
            if( !isset($map["id"]) && empty($map["id"])  ){

                $this->dataError = json_encode($map);
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }

            $Arr = Db::name("PackageOrder")->field("package_id,status")->where("id",$map["id"])->find();
            if( empty($Arr) || $Arr["status"] == 15 ){
                $this->dataError = json_encode($map);
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }
            $pid = Db::name("PackageOrder")->where("id",$map["id"])->update(["status"=>15,"pay_time"=>time()]);
            if( $pid ){
                //支付完成操作
                $proceeds = app_service("common","Proceeds");
                $proceeds->buy_proceeds($map["id"],"gw");

                Db::name("Package")->where(array('id'=>$Arr['package_id']))->setInc('buy_sum');

                $retArr["result"] = 0;
                $retArr["msg"] = "操作成功";
            }else{
                $retArr["result"] = 3;
                $retArr["msg"] = "操作失败";
            }
            $this->json_return($retArr);
        }
    }

    //修改发货
    public function save_status(){
        if( request()->isAjax() ){

            $data=input('post.');
            $Arr["status"] = $data["status"] ? $data["status"] : 20;

            $sum = Db::name("PackageOrder")->where("id=".$data["id"])->update($Arr);
            if($sum){
                $retArr["result"] = 0;
            }else{
                $retArr["result"] = 4;
                $retArr["msg"] = "save_status error";
                $this->dataError = "uid=".UID."|".json_encode($retArr);
            }
            $this->json_return($retArr,"status");
        }
    }

    //订单删除
    public function order_del(){

        if( request()->isAjax() ) {

            $map = input("post.");
            if( !isset($map["id"]) && empty($map["id"])  ){

                $this->dataError = json_encode($map);
            }
            if( !isset($map["status"]) ){

                $this->dataError = json_encode($map);
            }else{
                $status = $map["status"];
            }
            if( !empty($this->dataError) ){
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }

            $Arr = Db::name("PackageOrder")->field("status")->where("id",$map["id"])->find();
            if( empty($Arr) || empty($Arr["status"]) ){
                $this->dataError = json_encode($map);
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }
            $pid = Db::name("PackageOrder")->where("id",$map["id"])->update(["status"=>$status]);
            if( $pid ){
                $retArr["result"] = 0;
                $retArr["msg"] = "操作成功";
            }else{
                $retArr["result"] = 3;
                $retArr["msg"] = "操作失败";
            }
            $this->json_return($retArr);
        }
    }




}
