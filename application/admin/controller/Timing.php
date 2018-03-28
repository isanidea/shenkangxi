<?php
namespace app\admin\controller;

use app\common\controller\Base;
use think\Db;
class Timing extends Base
{

    function index(){

        $proceeds = app_service("common","Proceeds");
        $pd = $proceeds->release_static();

        if( $pd ){
            $pdzt = 0;
        }else{
            $pdzt = 1;
        }

        $this->assign("pdzt",$pdzt);
        return $this->fetch();
    }


}
