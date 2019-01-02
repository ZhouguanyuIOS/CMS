<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/13
 * Time: 下午1:20
 */
	$_c=$_GET['c'];
	echo  mysql_real_escape_string($_c);

?>
<form>
	<textarea name="c"></textarea>
	<input type="submit"/>
</form>
