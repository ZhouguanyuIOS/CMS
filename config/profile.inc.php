<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/19
 * Time: 下午4:20
 */

//模板配置信息
//数据库配置文件
//主机ip
define('DB_HOST','localhost');
//账号
define('DB_USER','root');
//密码
define('DB_PASS','root');
//数据库
define('DB_NAME','cms');
//系统配置文件
//sql转义功能是否打开了
define('GPC',get_magic_quotes_gpc());
//管理员每页显示个条数
define('PAGE_SIZE',5);
//记录上一页的路径
define('PREV_URL',$_SERVER["HTTP_REFERER"]);

//模板文件目录
define('TPL_DIR',ROOT_PATH.'/templates/');
//编译文件目录
define('TPL_C_DIR',ROOT_PATH.'/templates_c/');
//缓存文件目录
define('CACHE',ROOT_PATH.'/cache/');


?>