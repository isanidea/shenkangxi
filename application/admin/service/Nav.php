<?php
namespace app\admin\service;


use app\admin\model\AdminRole;
use app\admin\model\Menu;
use app\admin\model\Privilege;
use think\Cache;
use think\Db;
use think\Session;

class Nav{

    public $wholeMenu;

    public function __construct(){

       Cache::clear();

        $this->wholeMenu = Cache::remember("wholeMenu",function(){
            //获取
            $menu = new Menu();
            $list = $menu->getWholeMenuList();
            if($list){
                return collection($list)->toArray();
            }
        });

    }


    /*
     * 获取我的导航列表
     * */
    public function getMyNavList( $menuList = [] ){

        if( empty($menuList) ){

            $menuList = $this->getMyMenu();
        }

        $navArr = [];
        foreach($menuList as $k=>$v){
            if( $v["status"] == 10 ){
                $controller = ucfirst($v["controller"]);
                $navArr[$v["module_id"]]["name"] = $v["module_name"];

                if( !isset($navArr[$v["module_id"]]["controllers"]) || !in_array( $controller,$navArr[$v["module_id"]]["controllers"]) ){
                    $navArr[$v["module_id"]]["controllers"][] = $controller;
                }

                $navArr[$v["module_id"]]["list"][] = array(
                    "name" => $v["menu_name"],
                    "nav_controller" => $controller,
                    "nav_action" => $v["action"],
                    "url" => $controller."/".$v["action"]
                );
            }
        }
        return $navArr;
    }

    //获取我的角色
    public function getMyRole(){

        return Cache::remember("myroles_".UID,function(){
            //获取
            $adminRole = new AdminRole();
            return $adminRole->getRloes(UID);
        },60);
    }

    //获取我的权限菜单
    public function getMyMenu(){

        $user_info = session('user_auth');
        if( $user_info["isAdmin"] == 1 ){
            //超级权限 返回全部
            return $this->wholeMenu;
        }
        $roleArr = $this->getMyRole();


        $privilege = new Privilege();
        $menuIdArr = $privilege->getPrivilege($roleArr);

        $newList = [];
        foreach($this->wholeMenu as $k=>$v){
            if( in_array($v["id"],$menuIdArr) ){
                $newList[] = $v;
            }
        }
        return $newList;
    }

    //获取权限判断数组
    public function getAuthArr( $myMenuList = [] ){

        if( empty($myMenuList) ){

            $myMenuList = $this->getMyMenu();
        }
        $AuthArr = [];
        foreach($myMenuList as $k=>$v){
            $AuthArr[$k] = ucfirst($v["controller"])."/".$v["action"];
        }
        return $AuthArr;
    }

}
?>