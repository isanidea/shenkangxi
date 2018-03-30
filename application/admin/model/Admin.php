<?php

namespace app\admin\model;

use think\Db;
use think\Model;
class Admin extends BaseModel{




    public function roles()
    {
        return $this->hasMany('AdminRole')->field("role_id");
    }


    public function getPageList(){

        return $this->field("admin.*, department.name as departmentName")
            ->join("skx_department","skx_department.id = skx_admin.department_id","RIGHT")
            ->where("admin.isAdmin = 0 and admin.status>0 AND department.status > 0")
            ->order("admin.id desc")
            ->paginate();
    }

    public function getList(){
        return $this->field("id,name")
            ->where("status = 10 AND isAdmin = 0")
            ->select();
    }
}
?>