<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/13
 * Time: 上午10:52
 */
global $_tpl;
require dirname(__FILE__)."/init.inc.php";
//声明一个变量
$_tpl->asign('title','标头');
//载入tpl文件
$_tpl->display('index.tpl');
?>