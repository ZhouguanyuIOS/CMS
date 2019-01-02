<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/20
 * Time: 下午4:14
 */
//验证类
class Validate{
    //是否为空
    static  public function checkNull($_date){

       if (trim($_date)=='')return true;
       return false;
    }
    //长度是否合法
    static  public function checkLenth($_date,$_length,$_flag){
        if ($_flag=='min'){
            return mb_strlen(trim($_date),'utf-8')<$_length ? true:false;
        }elseif ($_flag=='max'){
            return mb_strlen(trim($_date),'utf-8')>$_length ? true:false;
        } elseif($_flag=='equals'){
			return mb_strlen(trim($_date),'utf-8')==$_length? false:true;
		}else{
            Tool::alertBack('参数传递错误，必须是min，max');
        }
    }
    //数据是否一致
    static  public function checkEquals($_date,$_otherDate){
       return trim($_date) != trim($_otherDate)? true:false;
    }
    //session验证
	static public function chenckSession(){
    	if (!isset($_SESSION['admin']))Tool::alertBack('警告：非法登录 !');
	}


}
?>