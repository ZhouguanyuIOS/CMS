<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/13
 * Time: 上午11:03
 */
class Parser{
    //保存模板内容
    private  $_tpl;
    //构造方法，获取模板文件里面的内容
    public  function __construct($_tplFile)
    {
        if (!$this->_tpl= file_get_contents($_tplFile)){
            echo 'ERROR:模板文件读取错误';
        };
    }
    //私有的解析方法
    //解析普通变量
    private function parVar(){
        $_patten='/\{\$([\w]+)\}/';
        if(preg_match($_patten,$this->_tpl)){
            $this->_tpl=preg_replace($_patten,"<?php echo \$this->_vars['$1'];?>",$this->_tpl);
        }
    }
    //解析if语句
    private function parIf(){
        $_pattenEnd='/\{\/if\}/';
        $_pattenStart='/\{if\s+\$([\w]+)\}/';
        $_pattenElse='/\{else\}/';
        if(preg_match($_pattenStart,$this->_tpl)){
           if (preg_match($_pattenEnd,$this->_tpl)){
               $this->_tpl=preg_replace($_pattenStart,"<?php if(\$this->_vars['$1']){?>",$this->_tpl);
                $this->_tpl=preg_replace($_pattenEnd,"<?php }?>",$this->_tpl);
               if (preg_match($_pattenElse,$this->_tpl)) {
                   $this->_tpl=preg_replace($_pattenElse,"<?php }else{?>",$this->_tpl);
               }
            }else{
               exit('ERROR:if 语句没有关闭');
           }
        }
    }
    //解析注释语句
    private function parCommon(){
        $_patten='/{#}(.*){#}/';
        if(preg_match($_patten,$this->_tpl)){
            $this->_tpl=preg_replace($_patten,"<?php /*$1*/?>",$this->_tpl);
        }
    }
    //解析foreach语句
    private function parForeach(){
        $_pattenForeach='/\{foreach\s+\$([\w]+)\(([\w]+),([\w]+)\)\}/';
        $_pattenEndForeach='/\{\/foreach\}/';
        $_pattenVar='/\{@([\w]+)([\w\-\>\+]*)\}/';
        if(preg_match($_pattenForeach,$this->_tpl)){
            if (preg_match($_pattenEndForeach,$this->_tpl)){
                $this->_tpl=preg_replace($_pattenForeach,"<?php foreach (\$this->_vars['$1'] as \$$2=>\$$3){?>",$this->_tpl);
                $this->_tpl=preg_replace($_pattenEndForeach,"<?php }?>",$this->_tpl);
                if (preg_match($_pattenVar,$this->_tpl)) {
                    $this->_tpl=preg_replace($_pattenVar,"<?php echo  \$$1$2?>",$this->_tpl);
                }
            }else{
                exit('ERROR:forach 语句没有关闭');
            }
        }
    }
    //解析include方法
    private function parInclude(){
        $_pattenInclude='/\{include\s+file=(\"|\')([\w\.\-\/]+)(\"|\')\}/';
        if(preg_match_all($_pattenInclude,$this->_tpl,$_file)){
            foreach ($_file[2] as $value){
                if (!file_exists('templates/'.$value)){
                    exit('ERROR:包含文件出错');
                }
                $this->_tpl=preg_replace($_pattenInclude,"<?php \$_tpl->_create('$2') ;?>",$this->_tpl);
            }
        }
    }
    //解析系统变量名
    private function parConfig(){
        $_pattenConfig='/<!--\{([\w]+)\}-->/';
        if(preg_match($_pattenConfig,$this->_tpl,$_file)){
            $this->_tpl=preg_replace($_pattenConfig,"<?php echo \$this->_config['$1'];?>",$this->_tpl);
        }
    }
    //对外公共方法
    public function compile($_parFile){
        //在生成编译文件之前，先解析模板文件
        $this->parInclude();
        $this->parVar();
        $this->parIf();
        $this->parForeach();
        $this->parCommon();
        $this->parConfig();
        //生成编译文件
        if (!file_put_contents($_parFile,$this->_tpl)){
            echo 'ERROR:编译文件生成出错';
        }
    }
}
?>