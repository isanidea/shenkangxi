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

        return $this->field("xls_admin.*, xls_department.name as departmentName")
            ->join("xls_department","xls_department.id = xls_admin.department_id","RIGHT")
            ->where("xls_admin.isAdmin = 0 and xls_admin.status>0 AND xls_department.status > 0")
            ->order("xls_admin.id desc")
            ->paginate();
    }

    public function getList(){
        return $this->field("id,name")
            ->where("status = 10 AND isAdmin = 0")
            ->select();
    }
}
?>