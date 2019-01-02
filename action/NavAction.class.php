<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/22
 * Time: 下午1:30
 */
class NavAction extends Action {
    public  function  __construct($_tpl)
    {
		Validate::chenckSession();

		parent::__construct($_tpl,new NavModel());
        $this->_action();
        //展示页面
        $this->tpl->display('nav.tpl');
    }
    private  function  _action(){
        //业务流程控制器
        switch ($_GET['action']){
            case 'show':
                $this->show();
                break;
            case 'add':
                $this->add();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
               $this->delete();
                break;
            default:
				Tool::alertBack('非法操作');
        }
    }
    //展示show
    private function show(){
    	parent::page($this->model->getNavTotal());
        $this->tpl->asign('show',true);
        $this->tpl->asign('title','导航列表');
        $this->tpl->asign('AllNav',$this->model->getAllNav());
    }
    //添加
    private  function  add(){
		$this->tpl->asign('add',true);
		$this->tpl->asign('title','新增导航');
    }
    //修改
    private function update(){

    }
    //删除
    private function delete(){

    }
}