<?php
class IndexAction extends Action {
    // 框架首页
	 public function index(){
	 	$this->checkUser();
         $this->display();
	 }

	protected function checkUser(){
		if(!isset($_SESSION[C('USER_AUTH_KEY')])){
			$this->redirect(__GROUP__."/Public/login");
		}else{
		}
	}
}