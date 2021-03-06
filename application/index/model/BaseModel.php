<?php

namespace app\index\model;

use think\Db;
use think\Model;
class BaseModel extends Model{

    public function statusWhere($status=""){
        if( $status == "" ){
            return $this->where("status > 0 ");
        }else{
            return $this->where("status = ",$status);
        }
    }



    public function add_up_data($data){
        $Arr = [];
        foreach($data as $k=>$v){
            if( $k == "id" ){
                continue;
            }
            $Arr[$k] = $v;
        }
        if( isset($data["id"]) && !empty($data["id"]) ){

            $id = $this->save($Arr,["id"=>$data["id"]]);
            if( $id ){
                return $data["id"];
            }
        }else{
            return $this->insert($Arr,false,true);
        }
        return false;
    }

    public function getKeyValueArr($id,$key){
        return $this->where("id",$id)->column($key);
    }

    public function getAll(){
        return $this->statusWhere()->order("sort desc")->select();
    }



}
?>