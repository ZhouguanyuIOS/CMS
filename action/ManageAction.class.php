<?php
/**
 * Created by PhpStorm.
 * User: shuukanu
 * Date: 2018/6/22
 * Time: 下午1:30
 */
class ManageAction extends Action {

    public  function  __construct($_tpl)
    {
        parent::__construct($_tpl,new ManageModel());

        $this->_action();
        //展示页面
        $this->tpl->display('manage.tpl');
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
			case 'login':
				$this->login();
				break;
			case 'logout':
				$this->logout();
				break;
            default:
                Tool::alertBack('非法操作');
        }
    }
    //展示show
    private function show(){
       parent::page($this->model->getManageTotal());
        $this->tpl->asign('show',true);
        $this->tpl->asign('title','管理员列表');
        $this->tpl->asign('AllManage',$this->model->getAllManage());
    }
    //添加
    private  function  add(){
        if (isset($_POST['send'])){
            if (Validate::checkNull($_POST['admin_user'])) Tool::alertBack('用户名不得为空');
            if (Validate::checkLenth($_POST['admin_user'],2,'min'))Tool::alertBack('用户名不得小于两位');
            if (Validate::checkLenth($_POST['admin_user'],20,'max'))Tool::alertBack('用户名不得大于20位');
            if (Validate::checkNull($_POST['admin_pass'])) Tool::alertBack('密码不得为空');
            if (Validate::checkLenth($_POST['admin_pass'],6,'min'))Tool::alertBack('密码不得小于六位');
            if (Validate::checkEquals($_POST['admin_pass'],$_POST['admin_notpass'])) Tool::alertBack('警告：密码和密码确认必须一致');
            $this->model->admin_user=$_POST['admin_user'];
            if ($this->model->getOneManage()) Tool::alertBack("警告，此用户已经被注册");
            $this->model->admin_pass=sha1($_POST['admin_pass']);
            $this->model->level=$_POST['level'];
            $this->model->addManage()?Tool::alertLocation('恭喜你，新增成功','manage.php?action=show'):Tool::alertBack('很遗憾，新增管理员失败');
        }
        $this->tpl->asign('add',true);
        $this->tpl->asign('title','新增管理员');

        $_level= new  LevelModel();
        $this->tpl->asign('AllLevel',$_level->getAllLevel());

    }
    //修改
    private function update(){
        if(isset($_POST['send'])){
            $this->model->id=$_POST['id'];
            if (trim($_POST['admin_pass'])==''){
                $this->model->admin_pass=$_POST['pass'];
            }else{
                if (Validate::checkLenth($_POST['admin_pass'],6,'min')) Tool::alertBack('警告:密码不得小于六位');
                $this->model->admin_pass=sha1($_POST['admin_pass']);
            }
            //接受修改后的信息
            $this->model->level=$_POST['level'];
            $this->model->updateManage()?Tool::alertLocation('恭喜你，修改成功',$_POST['prev_url']):Tool::alertBack('很遗憾，修改失败');
        }
        if (isset($_GET['id'])){
            $this->model->id=$_GET['id'];
            //查询单个人的信息
            is_object($this->model->getOneManage())?true:Tool::alertBack('传值的id有误！') ;
            $this->tpl->asign('admin_user',$this->model->getOneManage()->admin_user);
            $this->tpl->asign('admin_pass',$this->model->getOneManage()->admin_pass);
            $this->tpl->asign('id',$this->model->getOneManage()->id);
            $this->tpl->asign('level',$this->model->getOneManage()->level);
            $this->tpl->asign('update',true);
            $this->tpl->asign('title','修改管理员');
            $this->tpl->asign('prev_url',PREV_URL);
            $_level= new  LevelModel();
            $this->tpl->asign('AllLevel',$_level->getAllLevel());
        }else{
            Tool::alertBack('非法操作');
        }
    }
    //删除
    private function delete(){
        $this->tpl->asign('delete',true);
        $this->tpl->asign('title','删除管理员');
        if (isset($_GET['id'])){
            $this->model->id=$_GET['id'];
            $this->model->deleteManage()?Tool::alertLocation('恭喜你，删除成功',PREV_URL):Tool::alertBack('很遗憾，删除管理员失败');
        }else{
            Tool::alertBack('非法操作');
        }
    }
    //登录
	private  function login(){
    	if (isset($_POST['send'])){
    		if (Validate::checkLenth($_POST['code'],4,'equals'))Tool::alertBack('警告:验证码必须是四位');
			if (Validate::checkEquals(strtolower($_POST['code']),$_SESSION['code']))Tool::alertBack('警告:验证码不正确');
			if (Validate::checkNull($_POST['admin_user'])) Tool::alertBack('用户名不得为空');
			if (Validate::checkLenth($_POST['admin_user'],2,'min'))Tool::alertBack('用户名不得小于两位');
			if (Validate::checkLenth($_POST['admin_user'],20,'max'))Tool::alertBack('用户名不得大于20位');
			if (Validate::checkNull($_POST['admin_pass'])) Tool::alertBack('密码不得为空');
			if (Validate::checkLenth($_POST['admin_pass'],6,'min'))Tool::alertBack('密码不得小于六位');
			//查询数据库验证
			$this->model->admin_user=$_POST['admin_user'];
			$this->model->admin_pass=sha1($_POST['admin_pass']);
			$this->model->last_ip=$_SERVER["REMOTE_ADDR"];
			$_login=$this->model->getloginManage();
			if ($_login){
				$_SESSION['admin']['admin_user']=$_login->admin_user;
				$_SESSION['admin']['level_name']=$_login->level_name;
				$this->model->setLoginCount();
				Tool::alertLocation(null,'admin.php');
			}else{
				Tool::alertBack('账户或密码错误!');
			}
		}
	}
	//退出登录
	private function logout(){
    	//
		Tool::unSession();
		Tool::alertLocation(null,'admin.login.php');

	}

}
