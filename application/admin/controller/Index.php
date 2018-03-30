<?php
namespace app\admin\controller;

use app\common\controller\adminBase;
use think\Db;
class Index extends adminBase
{


    public function index()
    {

//        echo "fdsfsdf";
//        exit();

        return $this->fetch();
    }


}
