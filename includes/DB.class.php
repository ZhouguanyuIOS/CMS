<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/20
 * Time: 下午4:14
 */
//数据库连接类
class DB{
    static public  function  getDB(){
        //使用过程化操作数据库
        $_mysqli=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if (mysqli_connect_error()){
            echo '数据库连接错误！错误代码：'.mysqli_connect_error();
            exit();
        }
        //设置编码集
        $_mysqli->set_charset('utf8');
        return $_mysqli;
    }
    //清理
    //特别注意，销毁数据集和关闭数据库连接的时候，采用传引用地址的方法
    //$_result,$_db 不管是按值还是地址都可以清理关闭。
    //而$_result,$_db对象必须直接在创建页清理，否则必须按照传地址的方法进行清理
    static public  function  unDB(&$_result,&$_db){
        //清理结果集
        if (is_object($_result)){
            $_result->free();
            //销毁结果集对象
            $_result=null;
        }
        if (is_object($_db)) {
            //关闭数据库
            $_db->close();
            //销毁对象句柄
            $_db=null;
        }
    }
}
?>