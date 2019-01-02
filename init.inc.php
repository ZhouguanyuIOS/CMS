<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/13
 * Time: 下午5:42
 */

//开启session
session_start();
//设置utf-8编码
header('Content-Type:text/html;charset=utf-8');
//网站根目录
define('ROOT_PATH',dirname(__FILE__));
//引入配置信息
require ROOT_PATH.'/config/profile.inc.php';

//自动加载类
function __autoload($_className){
    if (substr($_className,-6)=='Action'){
        require ROOT_PATH.'/action/'.$_className.'.class.php';
    }elseif (substr($_className,-5)=='Model'){
        require ROOT_PATH.'/model/'.$_className.'.class.php';
    }else{
        require ROOT_PATH.'/includes/'.$_className.'.class.php';
    }
}
//缓存机制
require  'cache.inc.php';
//实例化模板类
$_tpl=new Templates();
?>