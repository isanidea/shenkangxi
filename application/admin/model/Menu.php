<?php

namespace app\admin\model;

use think\Db;
use think\Model;
class Menu extends BaseModel{









    //获取全部列表
    public function getWholeMenuList(){

        return $this->field("xls_menu.*")
            ->where("xls_menu.status>0 AND xls_module.status>0")
            ->join("xls_module","xls_module.id = xls_menu.module_id","RIGHT")
            ->order("xls_module.sort desc, xls_menu.sort desc")
            ->select();
    }


}
?>