<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;

class Index extends adminBase
{


    public function index()
    {
        $time = strtotime( date("Y-m-d",time()) );

        //今天总收入
        $today_income[0] = Db::name("PackageOrder")->where(array("pay_time"=>["EGT",$time],"status"=>['gt',14]))->sum("price");
        $today_income[1] = Db::name("ActivationOrders")->where(array("pay_time"=>["EGT",$time],"status"=>['gt',14]))->sum("price");
        $Arr["today_income"] = $today_income[0] + $today_income[1];

        //今天总支出
        $today_pay[0] = Db::name("ProceedsLog")->where(array("c_time"=>["EGT",$time]))->sum("total_money");
        $today_pay[1] = Db::name("StaticProceeds")->where(array("c_time"=>["EGT",$time]))->sum("total_money");
        $Arr["today_pay"] =  $today_pay[0] +  $today_pay[1];

        //总收入
        $tatol_income[0] = Db::name("PackageOrder")->where(array("status"=>['gt',14]))->sum("price");
        $tatol_income[1] = Db::name("ActivationOrders")->where(array("status"=>['gt',14]))->sum("price");
        $Arr["tatol_income"] = $tatol_income[0] + $tatol_income[1];

        //总支出
        $tatol_pay[0] = Db::name("ProceedsLog")->sum("total_money");
        $tatol_pay[1] = Db::name("StaticProceeds")->sum("total_money");
        $Arr["tatol_pay"] =  $tatol_pay[0] +  $tatol_pay[1];


        $this->assign("Arr",$Arr);
        return $this->fetch();
    }


}
