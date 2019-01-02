<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/22
 * Time: 下午1:30
 */
class LevelAction extends Action {
    public  function  __construct($_tpl)
    {
		Validate::chenckSession();

		parent::__construct($_tpl,new LevelModel());
        $this->_action();
        //展示页面
        $this->tpl->display('level.tpl');
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
    	parent::page($this->model->getLevelTotal());
        $this->tpl->asign('show',true);
        $this->tpl->asign('title','等级列表');
        $this->tpl->asign('AllLevel',$this->model->getAllLimitLevel());
    }
    //添加
    private  function  add(){
        if (isset($_POST['send'])){
            if (Validate::checkNull($_POST['level_name'])) Tool::alertBack('等级名称不得为空');
            if (Validate::checkLenth($_POST['level_name'],2,'min'))Tool::alertBack('等级名称不得小于两位');
            if (Validate::checkLenth($_POST['level_name'],20,'max'))Tool::alertBack('等级名称不得大于20位');
            if (Validate::checkLenth($_POST['level_info'],200,'max'))Tool::alertBack('等级描述不得大于200位');
            $this->model->level_name=$_POST['level_name'];
            if ($this->model->getOneLevel())Tool::alertBack('警告：此等级名称已有');
            $this->model->level_info=($_POST['level_info']);
            $this->model->addLevel()?Tool::alertLocation('恭喜你，新增等级成功','level.php?action=show'):Tool::alertBack('很遗憾，新增等级失败');
        }
        $this->tpl->asign('add',true);
        $this->tpl->asign('title','新增等级');
    }
    //修改
    private function update(){
        if(isset($_POST['send'])){
            $this->model->id=$_POST['id'];
            //接受修改后的信息
            $this->model->level_name=$_POST['level_name'];
            $this->model->level_info=$_POST['level_info'];
            $this->model->updateLevel()?Tool::alertLocation('恭喜你，修改等级成功',$_POST['prev_url']):Tool::alertBack('很遗憾，修改等级失败');
        }
        if (isset($_GET['id'])){
            $this->model->id=$_GET['id'];
            //查询单个人的信息
            is_object($this->model->getOneLevel())?true:Tool::alertBack('等级传值的id有误！') ;
            $this->tpl->asign('level_name',$this->model->getOneLevel()->level_name);
            $this->tpl->asign('id',$this->model->getOneLevel()->id);
            $this->tpl->asign('level_info',$this->model->getOneLevel()->level_info);
            $this->tpl->asign('update',true);
            $this->tpl->asign('title','修改等级');
			$this->tpl->asign('prev_url',PREV_URL);
        }else{
            Tool::alertBack('非法操作');
        }
    }
    //删除
    private function delete(){
        $this->tpl->asign('delete',true);
        $this->tpl->asign('title','删除等级');
        if (isset($_GET['id'])){
            $this->model->id=$_GET['id'];
            $_manage=new  ManageModel();
            $_manage->level= $_GET['id'];
            if ($_manage->getOneManage())Tool::alertBack('警告：此等级已有管理员使用！无法删除！请先删除相关用户！');
            $this->model->deleteLevel()?Tool::alertLocation('恭喜你，删除等级成功',PREV_URL):Tool::alertBack('很遗憾，删除管理员失败');
        }else{
            Tool::alertBack('非法操作');
        }
    }
}