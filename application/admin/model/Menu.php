<?php

namespace app\admin\model;

use think\Db;
use think\Model;
class Menu extends BaseModel{









    //获取全部列表
    public function getWholeMenuList(){

        return $this->field("skx_menu.*")
            ->where("skx_menu.status>0 AND skx_module.status>0")
            ->join("skx_module","skx_module.id = skx_menu.module_id","RIGHT")
            ->order("skx_module.sort desc,skx_menu.sort desc")
            ->select();
    }


}
?>