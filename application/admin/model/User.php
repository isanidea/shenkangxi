<?php

namespace app\admin\model;

use think\Db;
use think\Model;
class User extends BaseModel{



    public function get_pageList($where){
        return $this->alias("a")
            ->join("user_details b","a.id = b.uid","LEFT")
            ->field("a.id,a.username,a.phone,a.real_name,b.*")
            ->where($where)
            ->order("a.add_time desc")
            ->paginate();
    }

}
?>