<?php

namespace app\admin\model;

use think\Db;
use think\Model;
class AdminRole extends BaseModel{




    public function getRloes($uid){

        return $this->where("admin_id",$uid)->column('role_id');
    }

}
?>