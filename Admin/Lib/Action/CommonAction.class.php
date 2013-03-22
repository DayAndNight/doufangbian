<?php
class CommonAction extends Action {
    // 框架首页
	 public function index(){
	 	$this->checkUser();
	 	$Common=D('Common');
	 	$commons=$Common->select();
	 	$this->assign('allCommons',$commons);
        $this->display();
	 }

	protected function checkUser(){
		$PublicAction=A('Public');
		$PublicAction->checkUser();
	}
	/******************用户*********************/
	/*
		用户获取地区配置
		@param areacode 地区编码
		@return res common实体
	*/
	public function getcommon(){
		$areacode=$_REQUEST['areacode'];
		$Common=D('Common');
		$res=$Common->where("areacode='".$areacode."'")->find();
		if ($res==null) {
			$this->ajaxReturn("地区编码不匹配","获取失败",0);
		}else{
			$this->ajaxReturn($res,"获取成功",1);
		}
	}

	/*
		用户获取地区配置
		@param areacode 地区编码
		@return res common实体
	*/
	public function up(){
		$areacode=$_REQUEST['areacode'];
		$Common=D('Common');
		$res=$Common->where("areacode='".$areacode."'")->find();
		if ($res==null) {
			$this->ajaxReturn("地区编码不匹配","操作失败",0);
		}else{
			$data['up']=$res['up']+1;
			$Common->where('id='.$res['id'])->save($data);
			$res=$Common->find($res['id']);
			$this->ajaxReturn($res,"操作成功",1);
		}
	}

	/******************管理员**********************/
	/*
		管理获得添加界面
	*/
	public function add_common(){
		$this->checkUser();
		$this->display();
	}

	/*
		管理添加配置
	*/
	public function save_common(){
		$this->checkUser();
		$Common=D('Common');
		$data['url']=$_REQUEST['url'];
		$data['up']=$_REQUEST['up'];
		$data['areacode']=$_REQUEST['areacode'];
		$isExist=$Common->where("areacode='".$_REQUEST['areacode']."'")->find();
		if ($isExist!=null) {
			$this->error("地区编码已存在");
		}
		$res=$Common->add($data);
		if ($res==false) {
			$this->error("添加失败");
		}else{
			$this->redirect(__GROUP__."/Common/index");
		}
	}

	/*
		管理获得编辑界面
	*/
	public function edit_common($id){
		$this->checkUser();
		$Common=D('Common');
		$res=$Common->find($id);
		if ($res===false || $res==null) {
			$this->error("未找配置！",__GROUP__."/Common/index");
		}else{
			$this->assign('common',$res);
			$this->display();
		}
	}

	/*
		管理更新配置
	*/
	public function update_common(){
		$this->checkUser();
		$id=$_REQUEST['id'];
		$Common=D('Common');
		$data['url']=$_REQUEST['url'];
		$data['up']=$_REQUEST['up'];
		$data['areacode']=$_REQUEST['areacode'];
		$isExist=$Common->where("areacode='".$_REQUEST['areacode']."' and id<>".$id )->find();
		if ($isExist!=null) {
			$this->error("地区编码已存在");
		}
		$res=$Common->where($id)->save($data);
		if ($res!==false) {
			$this->redirect(__GROUP__."/Common/index");
		}else{
			$this->error("未找配置或者数据非法！",__GROUP__."/Common/index");
		}
	}

	/*
		管理删除配置
	*/
	public function delete_common(){
		$this->checkUser();//验证
		$id=$_GET['id'];
		$Common=D('Common');
		$res=$Common->delete($id);
		if ($res===false || $res==0) {
			$this->error("删除失败！",__GROUP__."/Common/index");
		}else{
			$this->redirect(__GROUP__."/Common/index");
		}
	}
}