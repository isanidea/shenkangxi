<?php

namespace app\common\service;

use app\admin\model\Brokerage;//佣金业务配置表类
use think\Db;
use app\index\model\Jifen;

/**
 * @收收益分配
 */
class Proceeds
{
    private $reg;//注册
    private $up_lever_price;//升级所需金额
    private $zhitui;
    private $share;
    private $team_sell;
    private $special;
    private $pyji;
    private $conditions;
//    private $admin_up_arr = [];
    /**
     * Proceeds constructor
     */
    public function __construct()
    {
        //获取
//        $M = new Brokerage();
//        $list = $M->select();
        $list = Db::name("Brokerage")->select();


        foreach ($list as $k => $v) {

            if ($v["type"] == "reg") {

                $this->reg[$v['key']] = $v["value"];
            }
            if ($v["type"] == "zhitui") {

                $this->zhitui[$v['key']] = $v["value"];
            }
            if ($v["type"] == "share") {
                $this->share[$v['key']] = $v["value"];
            }
            if ($v["type"] == "team_sell") {
                $this->team_sell[$v['key']] = $v["value"];
            }
            if ($v["type"] == "special") {
                $this->special[$v['key']] = $v["value"];
            }

            if ($v["type"] == "pyji") {
                $this->pyji[$v['key']] = $v["value"];
            }

            if ($v["type"] == "conditions") {
                $this->conditions[$v['key']] = $v["value"];
            }
            if ($v["type"] == "up_lever_price") {
                $this->up_lever_price[$v['key']] = $v["value"];
            }
        }


    }
    /**
     * [register_proceeds description]注册积分+积分明细更改
     * @return [type] [description]
     */
    public function register_update_jifen($uid,$pid){

        Db::name('user_details')->where('id',$uid)->setDec('jifen',$this->reg['reg_1']);
        Db::name('user_details')->where('id',$pid)->setDec('jifen',$this->reg['reg_2'],2);

        $add_data = [
            [
                'uid'=>$uid,
                'jifen'=>$this->reg['reg_1'],
                'type' => 5,
                'add_time'=>time()
            ],[
                'uid'=>$pid,
                'jifen'=>$this->reg['reg_2'],
                'type' => 5,
                'add_time'=>time()
            ]
        ];
        $jifen = new  Jifen();
        $jifen->saveAll($add_data);
        return true;
    }
    /**
     * [zhitui_jifen description] 直推积分
     * @return [type] [xmlrpc_parse_method_descriptions(xml)
     */
     public function zhitui_jifen($order_id){

        //判断订单状态
        //获取订单信息
        //uid,price,获取用户信息
        //lever,订单购买金额
        //if  lever=2    else  订单金额+已经金额  >680
        //如果升级了，上面返利pid
        //消费积分返利,积分完成了
        //如果本用户升级到v2，判断上级有没有可以升级的，pid->
        //根据订单增加每个用户的业绩，然后递归增加业绩！如果递归到经理，增加当月的团队业绩，
        $orderInfo = Db::name('package_order')->field('status,total_price,uid')->where('id',$order_id)->find();
        if(empty($orderInfo)){
            return false;
        }
        if( $orderInfo['status'] != 20){
          return false;
         }             
         //订单总金额
         /**
          * $orderInfo:
          * 'status' => int 20
            'total_price' => string '30000' (length=5)
            'uid' => int 10000
          */
//         $order_total_price = $orderInfo['total_price'];
         //通过用户id拿到用户的等级和金额cash
          $userInfo = $this->get_user_info($orderInfo['uid']);


         /**
          $userInfo:
          * array (size=13)
            'id' => int 1
            'uid' => int 10000
            'pid' => int 0
            'username' => string 'wangbo' (length=6)
            'manage_lever' => int 1
            'lever' => int 1
            'total_yeji' => string '0.00' (length=4)
            'total_profit' => string '0.00' (length=4)
            'jifen' => string '0.00' (length=4)
            'bonus' => string '0.00' (length=4)
            'cash' => string '0.00' (length=4)
            'status' => int 1
            'add_time' => int 1521623612
          */
          if(empty($userInfo)){
            return false;
          }  
//          $user_lever = $userInfo['lever'];
//          $user_manage_lever = $userInfo['manage_lever'];
//          $user_old_price = $userInfo['cash'];
//          $pid = $userInfo['pid'];
//          //用户金额+订单金额
//          $user_now_price = intval($user_old_price) + intval($order_total_price);
          // if($user_lever == 0 && $user_total_price < $this->up_lever_price['up_v1']){
          //     return false;
          // }
          // if($user_lever == 0 && $user_total_price < $this->up_lever_price['up_v2']){
          //     return false;
          // }
          /*
          v1>v0的话，等级改为v1,然后积分返利!
          v2>v1的话，等级改为v2,然后积分返利！
          v2>v0的话，等级改为v2,然后积分返利！
           */

         //先修改购买人信息
         $total_money = $userInfo["cash"] + $orderInfo["total_price"];
         $newUser = [
             "cash" =>$total_money
         ];

         $admin_pd = false;//判断管理是否需要生级
         if( $userInfo["lever"] != 2 ){
             //
             $get_lever = $this->get_user_lever($total_money);

             if( $userInfo["lever"] < $get_lever ){
                 //升级
                 $newUser["lever"] = $get_lever;
             }
             if( $get_lever == 2 ){
                 $admin_pd = true;
             }
         }
         //购买者积分
         $key_lv = "g_v_".$userInfo["lever"];
         $get_buy_jf = $orderInfo["total_price"] * $this->share[$key_lv] / 100;
         if( !empty($get_buy_jf) ){

             $newUser["jifen"] = $userInfo["jifen"] + $get_buy_jf;

             $this->_add_jifen_log($userInfo["uid"],$get_buy_jf,10);
         }
         //
//         Db::name("UserDetails")->where("uid",$userInfo["uid"])->update($newUser);

         //积分奖励

         if($userInfo['pid'] == 0){
          return ture;
         }
         $this->jifen_up($userInfo['pid'],$orderInfo['total_price']);

         //分享消费
         $this->share_sell($userInfo["pid"],$orderInfo["total_price"]);
         //管理升级
         if( $admin_pd ){
             $this->admin_up($userInfo["pid"]);
         }
         //添加业绩
         $this->add_yeji($userInfo['pid'],$orderInfo['total_price']);


     }

     //积分奖励
     private function jifen_up($pid,$price){
        /*
          只有推送人v0才会吃掉积分,v1,v2都是55% 
         */ 
       $userInfo = $this->get_user_info($pid);
       if( $userInfo['lever'] == 0 ){
          return true; 
       }
       $zhitui_jifen_one = $price * ($this->zhitui['z_one']/100);
       Db::name("user_details")->where("uid",$pid)->setInc("jifen",$zhitui_jifen_one);
       $userInfo_two = $this->get_user_info($userInfo['pid']);
       if($userInfo_two['lever'] == 0){
        return true;
       }
       $zhitui_jifen_two = $price * ($this->zhitui['z_two']/100); 
       Db::name("user_details")->where("uid",$userInfo['pid'])->setInc("jifen",$zhitui_jifen_two);
     }


    //添加业绩 父pid  $price 订单总金额
    private function add_yeji($pid,$price){

        if( empty($pid) ){
            return true;
        }
        Db::name("user_details")->where("uid",$pid)->setInc("cash",$price);
        $userInfo = $this->get_user_info($pid);
        $this->add_yeji($userInfo["pid"],$price);

    }

    //管理升级
    private function admin_up($pid,$vip=1,$jl=0,$zj=0){

        if( empty($pid) ){
            return true;
        }
        $userInfo = $this->get_user_info($pid);
        if( empty($userInfo) ){
            return true;
        }
        $new_user = [];

        if( $zj == 1 ){
            $new_user["zj_num"] = $userInfo["zj_num"] + 1;
            if( $userInfo["manage_lever"] == 3 ){
                //如他为 总监
                if( $new_user["zj_num"] == 3 ){
                    //生到总监
                    $new_user["manage_lever"] = 4;
                }
            }
        }

        if( $jl == 1 ){
            $new_user["jl_num"] = $userInfo["jl_num"] + 1;
            if( $userInfo["manage_lever"] == 2 ){
                //如他为 总监
                if( $new_user["jl_num"] == 3 ){
                    //生到总监
                    $new_user["manage_lever"] = 3;
                    $zj = 1;
                }
            }
        }

        $new_vip = $userInfo["vip_num"] + 1;
        $new_user["vip_num"] = $new_vip;//
        if( $userInfo["manage_lever"] == 1 ){
            if( $new_vip >=3 ){
                $new_user["manage_lever"] = 2;
                $jl = 1;
            }
        }

        Db::name("user_details")->where("id",$userInfo["id"])->update($new_user);
        $this->admin_up($userInfo["pid"],$vip,$jl,$zj);

    }

    //分享消费
    private function share_sell($uid,$price){

        $userInfo = $this->get_user_info($uid);
        if( empty($userinfo) ){
            return true;
        }
        $key_lv = "z_v_".$userInfo["lever"];
        $get_sell_jf = $price * $this->share[$key_lv] / 100;

        $new_user = [
            "total_jifen" => $userInfo["total_jifen"] + $get_sell_jf,
            "jifen" => $userInfo["jifen"] + $get_sell_jf
        ];
        Db::name("UserDetails")->where("uid",$userInfo["uid"])->update($new_user);
        $this->_add_jifen_log($userInfo["uid"],$get_sell_jf,10);
    }


     /**
      * [get_user_lever description]
      * @param  [type] $total_price [description]
      * @return [type]              [description]
      */
     public function get_user_lever($total_price){

        $lv = 0;

        if( $total_price >= $this->up_lever_price["up_v2"] ){

          $lv = 2;
        }elseif( $total_price >= $this->up_lever_price["up_v1"] ){
          $lv = 1;
        }
        return $lv;
     }


     //获取用户信息  
     /**
      * @param  [type] $uid [description]
      * @return [type]      [description]
      */
     private function get_user_info($uid){

        return  Db::name('user_details')
        ->where('uid',$uid)->find();

     }

    //添加积分记录
    private function _add_jifen_log($uid,$jifen,$type){

        $arr = [
            "uid" => $uid,
            "jifen" => $jifen,
            "type" => $type,
            "add_time" => time()
        ];
        $jifen  = new Jifen();
        $add_res = $jifen ->save($arr);
        if($add_res){
           return true; 
        }else{
            return false;
        }

    }






























   }
