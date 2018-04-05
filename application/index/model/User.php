<?php

namespace app\index\model;

use think\Db;
use think\Model;
class User extends BaseModel{


    public function userinfo()
    {
        return $this->hasOne('Userinfo');
    }



    public function getuserInfo($id,$filed="*"){

        $Arr = $this->alias("a")
            ->join("user_details b","a.id = b.uid","LEFT")
            ->field($filed)
            ->where("a.id",$id)
            ->find();
        if( empty($Arr) ){
            return null;
        }else{
            return $Arr->toArray();
        }
    }


}
?>