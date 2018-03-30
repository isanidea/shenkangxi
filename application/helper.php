<?php
use think\exception\ClassNotFoundException;


if (!function_exists('app_model')) {
    /**
     * 模型实例化助手函数
     * 
     */
    function app_model($module_name,$controller_name)
    {
        $class = '\\app\\'.$module_name.'\\model\\' . ucwords($controller_name);
        
        if (class_exists($class)) {
               return new $class();
        } else {
                throw new ClassNotFoundException('class not exists:' . $class, $class);
        }
    }
}
if (!function_exists('app_service')) {
    /**
     * osc service助手函数
     * 
     */
    function app_service($module_name,$service_name)
    {

        $class = '\\app\\'.$module_name.'\\service\\' . ucwords($service_name);

        if (class_exists($class)) {
               return new $class();
        } else {
                throw new ClassNotFoundException('class not exists:' . $class, $class);
        }
    }
}

?>