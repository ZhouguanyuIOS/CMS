<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/8/1
 * Time: 下午3:01
 */
require substr(dirname(__FILE__),0,-7).'/init.inc.php';
$_vc=new ValidateCode();
$_vc->doimg();
$_SESSION['code']=$_vc->getCode();
?>