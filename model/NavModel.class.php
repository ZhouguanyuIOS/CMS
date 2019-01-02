<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/21
 * Time: 上午10:24
 */
//导航实体类

class  NavModel extends Model {
    //构造方法，初始化
//    private $nav_name;//导航名称
//
//    private $nav_info;//导航描述
//    private $id;//
//	private $pid;//子类
//	private $sort;//排序
	private $limit;//分页限制

    //拦截器（_Set）私有的变量能否取到值
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name=$value;
    }
    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $name;
    }
	//获取导航总记录
	public function getNavTotal(){
		$_sql="SELECT COUNT(*) FROM cms_nav";
		return parent::total($_sql);
	}

    //查询所有等级带limit
	public  function  getAllNav(){

		$_sql="SELECT 
                     id,
                      nav_name,
                      nav_info
              FROM 
                cms_nav
                $this->limit";
		return parent::all($_sql);

	}



}
?>