<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/21
 * Time: 上午10:24
 */
//管理员实体类
//做数据层操作
class  LevelModel extends Model {
    //构造方法，初始化
    private $level_name;//等级名称

    private $level_info;//等级描述
    private $id;//等级

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
    //查询单个
    public  function  getOneLevel(){
        $_sql="SELECT 
                      id,
                      level_name,
                      level_info
                FROM 
                      cms_level
                 WHERE 
                  id='$this->id'
                OR 
                  level_name='$this->level_name'
            
               LIMIT 1";
        return parent::one($_sql);
    }
    //查询所有等级不带limit
    public  function  getAllLevel(){

        $_sql="SELECT 
                     id,
                      level_name,
                      level_info
              FROM 
                cms_level 
              ORDER BY
                 id 
                 DESC 
                ";
        return parent::all($_sql);

    }
    //查询所有等级带limit
	public  function  getAllLimitLevel(){

		$_sql="SELECT 
                     id,
                      level_name,
                      level_info
              FROM 
                cms_level 
              ORDER BY
                 id 
                 DESC 
                $this->limit";
		return parent::all($_sql);

	}
    //新增
    public  function  addLevel(){
        $_sql="INSERT INTO  cms_level(
                      level_name,
                      level_info
                       )
                    VALUES(
                      '$this->level_name',
                      '$this->level_info'
                    )";
       return parent::aud($_sql);

    }
    //修改管理员
    public  function  updateLevel(){

        $_sql="UPDATE  
                          cms_level
                    SET
                         level_name ='$this->level_name',
                          level_info='$this->level_info'
                    WHERE
                        id='$this->id'
                    LIMIT 1";
        return parent::aud($_sql);

    }
    //删除管理员
    public  function  deleteLevel(){
        $_sql="DELETE FROM cms_level WHERE id='$this->id' LIMIT 1";
        return parent::aud($_sql);
    }
    //获取等级总记录
    public function getLevelTotal(){
        $_sql="SELECT COUNT(*) FROM cms_level";
        return parent::total($_sql);
    }
}
?>