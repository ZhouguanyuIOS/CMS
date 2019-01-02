<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/21
 * Time: 上午10:24
 */
//管理员实体类
//做数据层操作
class  ManageModel extends Model {
    //构造方法，初始化
    private $admin_user;
	private $last_ip;
    private $admin_pass;
    private $level;
    private $id;
    private $limit;
    //拦截器（_Set）私有的变量能否取到值
    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->$name= $value;
    }
    public function __get($name)
    {
        // TODO: Implement __get() method.
        return $name;
    }
    //查询单个管理员
    public  function  getOneManage()
    {
        $_sql="SELECT 
                      id,
                      admin_user,
                      admin_pass,
                      level
              FROM 
                      cms_mangage
              WHERE 
                  id='$this->id'
                OR
                 admin_user='$this->admin_user'
                OR 
                  level='$this->level'
               LIMIT 1";
        return parent::one($_sql);
    }
    //查询所有管理员
    public  function  getAllManage(){

        $_sql="SELECT 
                      m.id,
                      m.admin_user,
                      m.login_count,
                      m.last_ip,
                      l.level_name,
                      m.last_time
              FROM 
                cms_mangage m,
                cms_level l
              WHERE 
                m.level=l.id
              ORDER BY
                 m.id DESC 
              $this->limit";
        return parent::all($_sql);

    }
    //查询登录管理员
	public  function getloginManage(){
		$_sql="SELECT 
						  m.admin_user,
						  l.level_name
					FROM 
						  cms_mangage m,
						  cms_level l
					WHERE 
						  m.admin_user='$this->admin_user' 
					AND 
						  m.admin_pass='$this->admin_pass'
					AND 
						  m.level=l.id
					 LIMIT 1";
		return parent::one($_sql);
	}
    //新增管理员
    public  function  addManage(){
        $_sql="INSERT INTO  cms_mangage(
                          admin_user,
                          admin_pass,
                          level,
                          reg_time
                       )
                    VALUES(
                      '$this->admin_user',
                      '$this->admin_pass',
                      '$this->level',
                      NOW()
                    )";
       return parent::aud($_sql);

    }
    //修改管理员
    public  function  updateManage(){

        $_sql="UPDATE  
                          cms_mangage
                    SET
                          admin_pass='$this->admin_pass)',
                          level='$this->level'
                    WHERE
                        id='$this->id'
                    LIMIT 1";
        return parent::aud($_sql);

    }
    //删除管理员
    public  function  deleteManage(){

        $_sql="DELETE FROM cms_mangage WHERE id='$this->id' LIMIT 1";
        return parent::aud($_sql);
    }


    //获取管理员总记录
    public function getManageTotal(){
        $_sql="SELECT COUNT(*) FROM cms_mangage";
       return parent::total($_sql);
    }

    //设置管理员登录统计，次数，ip，时间
	//
	public  function  setLoginCount(){
    	$_sql="UPDATE 
					  cms_mangage 
				  SET 
				  	  login_count=login_count+1,
				  	  last_ip='$this->last_ip',
				  	  last_time=NOW()
				  WHERE 
				  admin_user='$this->admin_user'
				  LIMIT 1";
    	return parent::aud($_sql);
	}


}
?>