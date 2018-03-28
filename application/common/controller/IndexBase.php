<?php
namespace app\common\controller;
use think\Db;
use think\Session;
class IndexBase extends  Base{

    public $titleName;
    public $userInfo;

    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub

        //判断是是否登录
        if( Session::has("userInfo") ){

            $user_info = Session::get("userInfo");
            if( empty($user_info) ){

                $this->redirect('index/Login/index');
            }

            $this->userInfo = $user_info;
//print_r($user_info);
//            exit();
        }else{

            $this->redirect('index/Login/index');
        }


    }



    public function fetch($template = '', $vars = [], $replace = [], $config = []){

        $this->assign( "titleName", $this->titleName );
        return parent::fetch($template, $vars, $replace, $config);
    }
}