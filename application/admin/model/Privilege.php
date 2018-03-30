<?php

namespace app\admin\model;

use think\Db;
use think\Model;
class Privilege extends BaseModel{




    public function getPrivilege($roleArr){

        return $this->where("role_id","in",$roleArr)->column('menu_id');
    }

}
?>