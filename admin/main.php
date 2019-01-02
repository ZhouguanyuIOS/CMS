<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/19
 * Time: 下午4:27
 */

require substr(dirname(__FILE__),0,-6).'/init.inc.php';
global  $_tpl;
Validate::chenckSession();
$_tpl->display('main.tpl');
?>