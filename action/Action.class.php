<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/22
 * Time: 下午2:16
 */
class Action{
    //控制器基类
    protected $tpl;
    protected $model;
    protected  function  __construct(&$_tpl,&$_model)
    {
        $this->tpl=$_tpl;
        $this->model=$_model;
    }
    protected  function  page($total){

		$_page=new  Page($total,PAGE_SIZE);
		$this->model->limit= $_page->limit;
		$this->tpl->asign('page',$_page->showPage());
		$this->tpl->asign('num',($_page->page-1)*PAGE_SIZE);
	}


}