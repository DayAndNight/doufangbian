<?php

Class PublicAction extends Action{
	public function checkUser(){
		if(!isset($_SESSION[C('USER_AUTH_KEY')])){
			$this->error("没有登录",__GROUP__."/Public/login");
		}else{
		}
	}
	public function login()
	{
		if(isset($_SESSION[C('USER_AUTH_KEY')])){
			$this->redirect(__GROUP__."/Index/index");
		}else{
			$this->display();
		}
	}

	public function main(){
		//获取一些参数
		$this->display();
	}
	public function checkLogin(){
		//生成认证条件
		$data=array();
		$data['username']=trim($_POST['username']);
		$data['password']=trim($_POST['password']);

		$User=new UserModel();
		$result=$User->where($data)->find();

		if($result&&$result!=null){//登录成功
			$_SESSION[C('USER_AUTH_KEY')]=$result;
			$_SESSION[C('loginUserName')]=trim($_POST['username']);
			$this->redirect(__GROUP__."/Index/index");
		}else{//登录失败
			$this->error("登录失败!");
		}
	}
	public function logout(){
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
			$this->redirect(__GROUP__."/Public/login");
        }else {
        	$this->redirect(__GROUP__."/Index/index");
        }
    }

}

?>