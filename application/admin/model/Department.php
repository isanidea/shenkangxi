<?php

namespace app\admin\model;

use think\Db;
use think\Model;
class Department extends BaseModel{



    public function getAll(){
        return $this->statusWhere()->select();
    }



}
?>