<?php

namespace app\admin\model;

use think\Cache;
use think\Db;
use think\Model;
class Brokerage extends BaseModel{






    public function getList($field,$type,$ds=true){
        if( $ds ){
            $data = $this->field($field)
                ->where(array("type"=>$type))
                ->select();
        }else{
            $data = $this->field($field)
                ->where(array("type"=>$type))
                ->find();
        }
        Cache::rm('Brokerage');
        return $data;
    }





}
?>