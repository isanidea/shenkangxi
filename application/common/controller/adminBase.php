<?php
/**
 *
 * Created by PhpStorm.
 * User: 854225951
 * Date: 2017/4/10
 * Time: 16:06
 */
namespace app\common\controller;

use think\Db;
use think\Session;

class adminBase extends Base{

    public $headerName;
    public $admin_info = [];

    public function _initialize() {
        parent::_initialize();

        if( Session::has("user_auth") ){
            $user_info = Session::get("user_auth");
            if( empty($user_info) ){

                $this->redirect('admin/Login/login');
            }
            $this->admin_info = $user_info;
        }else{
            $this->redirect('admin/Login/login');
        }


        define("UID",$user_info["uid"]);

        $Nav = app_service("admin","nav");

        $this->myMenuList = $Nav->getMyMenu();
        $navList = $Nav->getMyNavList($this->myMenuList);
        $AuthArr = $Nav->getAuthArr($this->myMenuList);



        if( $this->_noAuthValidate( $user_info["isAdmin"] ) ){

            if( !in_array(ucfirst( $this->controller )."/".$this->action,$AuthArr) ){

                return $this->success('对不起！你的权限不够。',url('Index/index'));
            }
        }

        $this->assign("userName",$user_info["username"]);
        $this->assign("navList",$navList);

    }


    public function fetch($template = '', $vars = [], $replace = [], $config = []){

        $this->assign( "headerName",$this->_getHeaderName() );
        $this->assign( "navArr",["nav_controller"=>ucfirst($this->controller),"nav_action"=>$this->action]);
        return parent::fetch($template, $vars, $replace, $config);
    }

    private function _getHeaderName(){

        if( empty($this->headerName)){

            foreach($this->myMenuList as $k=>$v){
                if( $v["controller"] == $this->controller && $v["action"] == $this->action ){

                    return $v["module_name"]."->".$v["menu_name"];
                    break;
                }

            }
        }
        return $this->headerName;
    }


    //修改排序
    public function saveSort(){

        if( request()->isAjax() ){

            $data=input('post.');
            $retArr = [];

            if( !isset($data["id"]) ){

                $this->dataError = json_encode($data);
            }
            if( !isset($data["sort"]) || !preg_match("/^[1-9][0-9]*$/",$data["sort"]) ){

                $this->dataError = json_encode($data);
            }
            if( !empty($this->dataError) ){
                $retArr["result"] = 1;
                $retArr["msg"] = $this->controller." ".$this->action." dataError";
                $this->json_return($retArr);
            }

            $mobile = app_model("admin",$this->controller);

            $pd = $mobile->update($data)->where("id",$data["id"]);

            if( $pd ){

                $this->json_return();
            }else{

                $this->json_return(2,"save error");
            }
        }
    }

    //删除
    public function delete(){

        if( request()->isAjax() ){

            $data=input('post.');
            $Arr["status"] = 0;

            $sum = Db::name($this->controller)->where("id=".$data["id"])->update($Arr);

            if($sum){

                $this->json_return(0,"删除成功");
            }else{

                $this->json_return(4,"删除失败");
            }
        }
    }

    //插入 更新
    public function insert_updata($data=[]){

        if( empty($data) ) {

            $data=input('post.');
        }
        // $result = $this->validate($data,$this->controller);
        // if($result!==true){
        //     $retArr = [
        //         "result" => 1,
        //         "msg" => $result,
        //     ];
        //     $this->dataError = "uid=".UID."|".json_encode($retArr);
        //     $this->json_return(1,"非法数据");
        // }
        $id = app_model("admin",$this->controller)->add_up_data($data);
        if( !$id ){

            $this->dataError = "uid=".UID."|".json_encode($data);
        }
        return $id;
    }

    //不需要验证的方法
    private function _noAuthValidate($isAdmin){
        
        if( $isAdmin == 1 ){
            return false;
        }
        $Arr = [
            "Index/index",
            "Admin/savepasswd",
            "Admin/quitlogin"
        ];

        if( in_array(ucfirst( $this->controller )."/".$this->action,$Arr) ) {
            return false;
        }
        return true;
    }



    //获取分页总数
    public function getPageTotal($data){
        return json_decode(json_encode($data),true)["total"];
    }

}

