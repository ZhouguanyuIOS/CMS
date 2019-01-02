<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/13
 * Time: 上午11:03
 */
//模板类
class Templates{
    //通过一个数组动态的来接受变量
    private $_vars=array();
    //保存系统变量
    private $_config=array();
    //创建一个构造方法，来验证各个目录是否存在
    public function __construct()
    {
        if (!is_dir(TPL_C_DIR) ||!is_dir(TPL_DIR)||!is_dir(CACHE)){
            exit('ERROR，模板目录或编译目录或缓存目录不存在，请手动设置');
        }
        //保存系统变量
        $_sex=simplexml_load_file(ROOT_PATH.'/config/profile.xml');
        $_sex->asXML();
        $_taglib=$_sex->xpath('/root/taglib');
        foreach ($_taglib as $value){
           $this->_config["$value->name"]=$value->value;
        }
    }
    //asign（）方法用于注入变量
    //$_var用于同步模板里面的变量名例如index.php里面的name 那么index.tpl就是{name}
    //$_value 是index.php里面的name的值andy
    //$_var
    public function asign($_var,$_value){
        if (isset($_var) && !empty($_var)){
            //相当于$this->_vars['name']
            $this->_vars[$_var]=$_value;
        }else{
            exit('ERROR: 请设置模板变量');
        }
    }
    //display()方法
    public function  display($_file){
        //给include进来的tpl传一个模板操作得对象
        $_tpl = $this;
        //设置模板的路径
        $_tplFile= TPL_DIR.$_file;
       //判断模板是否存在
        if (!file_exists($_tplFile)){
            exit('ERROR，模板文件不存在，请手动设置');
        }
        //生成编译文件路径名
        $_parFile= TPL_C_DIR.md5($_file).$_file.'.php';
        //缓存文件
        $_cacheFile=CACHE.md5($_file).$_file.'.html';
        //当第二次运行相同文件的时候，直接运行相同文件，避开编译
        if (IS_CACHE){
            //载入缓存文件
            //缓存文件和编译文件都要存在
            if (file_exists($_cacheFile) && file_exists($_parFile)){
                //判断模板文件是否修改过
                //编译文件修改时间>=模板文件修改时间 并且 缓存文件修改时间>=编译文件修改时间
                if (filemtime($_parFile)>=filemtime($_tplFile) && filemtime($_cacheFile)>=filemtime($_parFile)){
                    include  $_cacheFile;
                    return;
                }
            }
        }
        // 不存在或者编译文件修改时间小于模板文件的修改时间，则重新生成新的编译文件
        if ( !file_exists($_parFile)|| filemtime($_parFile)<filemtime($_tplFile)){
            //获取模板文件的内容
            //先解析在生成编译文件
            require_once ROOT_PATH.'/includes/Parser.class.php';
            //引入模板解析类
            //传入模板文件路径
            $_parser=new Parser($_tplFile);
            $_parser->compile($_parFile);//传入编译文件路径
        }
        //载入编译文件
        include $_parFile;
        if (IS_CACHE){
            //获取缓冲区里面的数据并且创建缓存文件
            file_put_contents($_cacheFile,ob_get_contents());
            //清除缓冲区（清除编译文件加载的内容）
            ob_end_clean();
            include  $_cacheFile;
        }
    }
    //创建create方法用于header和footer这种模块模板解析使用而不需要生成缓存文件
    public function _create($_file){
        //设置模板的路径
        $_tplFile= TPL_DIR.$_file;
        //判断模板是否存在
        if (!file_exists($_tplFile)){
            exit('ERROR，模板文件不存在，请手动设置');
        }
        //生成编译文件路径名
        $_parFile= TPL_C_DIR.md5($_file).$_file.'.php';
        // 不存在或者编译文件修改时间小于模板文件的修改时间，则重新生成新的编译文件
        if ( !file_exists($_parFile)|| filemtime($_parFile)<filemtime($_tplFile)){
            //获取模板文件的内容
            //先解析在生成编译文件
            require_once ROOT_PATH.'/includes/Parser.class.php';
            //引入模板解析类
            //传入模板文件路径
            $_parser=new Parser($_tplFile);
            $_parser->compile($_parFile);//传入编译文件路径
        }
        //载入编译文件
        include $_parFile;
    }
}
?>