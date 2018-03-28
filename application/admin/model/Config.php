<?php

namespace app\admin\model;

use think\Db;
use think\Model;
class Config extends BaseModel{



    public function getList($field,$type,$ds=true){

        if( $ds ){
            $data = $this->field($field)
                ->where(array("extend_value"=>$type,"status"=>["gt","0"]))
                ->select();
        }else{
            $data = $this->field($field)
                ->where(array("extend_value"=>$type,"status"=>["gt","0"]))
                ->find();
        }
        return $data;
    }


}
?>