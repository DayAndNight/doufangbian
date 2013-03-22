<?php
Class PreviewCommentAction extends Action {
    // 框架首页
	 public function index(){
	 	$this->checkUser();
	 	$this->filter_previewcomments();
        $this->display();
	 }

	protected function checkUser(){
		$PublicAction=A('Public');
		$PublicAction->checkUser();
	}
	/******************用户*********************/
	/*
		用户获留言
		@param lastid 最后一条留言的ID
		@return res n条previewcomment
	*/
	public function getOldPreviewComment(){
		$lastid=$_REQUEST['lastid'];
		$PreviewComment=new PreviewComment();
		$previewcomments=$PreviewComment->limit($lastid,20)->relation(true)->select();
		if ($res==null) {
			$this->ajaxReturn("数据错误","获取失败",0);
		}else{
			$this->ajaxReturn($previewcomments,"获取成功",1);
		}
	}

	/*
		用户获取最新留言
		@param firstid 最近一条留言ID
		@return res n条previewcomment
	*/
	public function getLatestPreviewComment(){
		$lastid=$_REQUEST['lastid'];
		$PreviewComment=new PreviewComment();
		$previewcomments=$PreviewComment->where('id>'.$firstid)->relation(true)->select();
		if ($res==null) {
			$this->ajaxReturn("数据错误","获取失败",0);
		}else{
			$this->ajaxReturn($previewcomments,"获取成功",1);
		}
	}

	/*
		用户发表留言
		@param uid 用户id
		@param token 验证token
		@param firstid 最近一条记录的id
		@param content 留言内容
		@return res common实体
	*/
	public function commit(){
		$id=$_REQUEST['uid'];
		$token=$_REQUEST['token'];
		$DouUser=new DouUserModel();
		if ($DouUser->authorize($id,$token)==true) {
			$PreviewComment=D('PreviewComment');
			$data['content']=$_REQUEST['content'];
			$data['time']=date("Y-m-d H:i:s");
			$data['uid']=$id;
			$res=$PreviewComment->add($data);
			if ($res==false) {
				$this->ajaxReturn("数据错误","留言失败",0);
			}else{
				$firstid=$_REQUEST['firstid'];
				$previewcomments=$PreviewComment->where('id>'.$firstid)->relation(true)->select();
				$this->ajaxReturn($previewcomments,"留言成功",1);
			}
		}else{
			$this->ajaxReturn("用户验证失败","留言失败",0);
		}
	}


	/*
		用户获留言回复
		@param cid 所属留言ID
		@param lastid 最后一条留言的ID
		@return res n条previewcommentreply
	*/
	public function getOldPreviewCommentReply(){
		$lastid=$_REQUEST['lastid'];
		$PreviewCommentReply=new PreviewCommentReply();
		$previewcommentreplys=$PreviewCommentReply->where('cid='.$cid)->limit($lastid,20)->relation(true)->select();
		if ($res==null) {
			$this->ajaxReturn("数据错误","获取失败",0);
		}else{
			$this->ajaxReturn($previewcommentreplys,"获取成功",1);
		}
	}

	/*
		用户获取最新留言回复
		@param cid 所属留言ID
		@param firstid 最近一条留言回复ID
		@return res n条previewcommentreply
	*/
	public function getLatestPreviewCommentReply(){
		$lastid=$_REQUEST['lastid'];
		$PreviewCommentReply=new PreviewCommentReply();
		$previewcommentreplys=$PreviewCommentReply->where('cid='.$cid.' and id>'.$firstid)->relation(true)->select();
		if ($res==null) {
			$this->ajaxReturn("数据错误","获取失败",0);
		}else{
			$this->ajaxReturn($previewcommentreplys,"获取成功",1);
		}
	}

	/*
		用户发表留言回复
		@param uid 用户id
		@param cid 评论id
		@param token 验证token
		@param firstid 最近一条记录的id
		@param content 留言内容
		@return res common实体
	*/
	public function commitreply(){
		$id=$_REQUEST['uid'];
		$token=$_REQUEST['token'];
		$DouUser=new DouUserModel();
		if ($DouUser->authorize($id,$token)==true) {
			$PreviewComment=new PreviewCommentModel();
			$cid=$_REQUEST['cid'];
			$res=$PreviewComment->find($cid);
			if ($res==null ) {
				$this->ajaxReturn("未找到匹配留言","留言失败",0);
			}
			$PreviewCommentReply=new PreviewCommentReplyModel();
			$data['content']=$_REQUEST['content'];
			$data['time']=date("Y-m-d H:i:s");
			$data['uid']=$id;
			$data['cid']=$_REQUEST['cid'];
			$res=$PreviewComment->add($data);
			if ($res==false) {
				$this->ajaxReturn("数据错误","留言失败",0);
			}else{
				$firstid=$_REQUEST['firstid'];
				$previewcommentreplys=$PreviewCommentReply->where('cid='.$cid.' and id>'.$firstid)->relation(true)->select();
				$this->ajaxReturn($previewcommentreplys,"留言成功",1);
			}
		}else{
			$this->ajaxReturn("用户验证失败","留言失败",0);
		}
	}
	/******************管理员**********************/
	/*
		管理获得添加界面
	*/
	public function add_previewcomment(){
		$this->checkUser();
		$this->display();
	}

	/*
		管理添加配置
	*/
	public function save_previewcomment(){
		$this->checkUser();
		$DouUser=new DouUserModel();
		$res=$DouUser->find($_REQUEST['uid']);
		if ($res==null) {
			$this->error("用户不存在");
		}
		$PreviewComment=new PreviewCommentModel();
		$data['content']=$_REQUEST['content'];
		$data['time']=$_REQUEST['time'];
		$data['uid']=$_REQUEST['uid'];
		$res=$PreviewComment->add($data);
		if ($res==false) {
			$this->error("添加失败");
		}else{
			$this->redirect(__GROUP__."/PreviewComment/index");
		}
	}

	/*
		管理获得编辑界面
	*/
	public function edit_previewcomment($id){
		$this->checkUser();
		$PreviewComment=new PreviewCommentModel();
		$res=$PreviewComment->find($id);
		if ($res===false || $res==null) {
			$this->error("未找到留言！",__GROUP__."/PreviewComment/index");
		}else{
			$this->get_previewcommentreplys($id);
			$this->assign('previewcomment',$res);
			$this->display('edit_previewcomment');
		}
	}

	/*
		管理更新配置
	*/
	public function update_previewcomment(){
		$this->checkUser();
		$DouUser=new DouUserModel();
		$res=$DouUser->find($_REQUEST['uid']);
		if ($res==null) {
			$this->error("用户不存在");
		}
		$id=$_REQUEST['id'];
		$PreviewComment=new PreviewCommentModel();
		$data['content']=$_REQUEST['content'];
		$data['time']=$_REQUEST['time'];
		$data['uid']=$_REQUEST['uid'];
		$res=$Common->where($id)->save($data);
		if ($res!==false) {
			$this->redirect(__GROUP__."/PreviewComment/index");
		}else{
			$this->error("未找留言或者数据非法！",__GROUP__."/PreviewComment/index");
		}
	}

	/*
		管理删除配置
	*/
	public function delete_previewcomment(){
		$this->checkUser();//验证
		$id=$_GET['id'];
		$PreviewComment=new PreviewCommentModel();
		$res=$PreviewComment->delete($id);
		if ($res===false || $res==0) {
			$this->error("删除失败！",__GROUP__."/PreviewComment/index");
		}else{
			$this->redirect(__GROUP__."/PreviewComment/index");
		}
	}

	/*
		管理查找留言
	*/
	protected function filter_previewcomments(){
		$this->checkUser();//验证
		$PreviewComment=new PreviewCommentModel();
		$allPreviewComments=null;
		if(isset($_POST['dosearch'])){
			$search_field=$_POST['search_field'];
			$search_keyword=trim($_POST['search_keyword']);
			if ($search_field=='id' || $search_field=='uid') {
				$sql=" SELECT * FROM dfb_preview_comment WHERE ".$search_field."=".$search_keyword;
			}else{
				$sql=" SELECT * FROM dfb_preview_comment WHERE ".$search_field." LIKE '%".$search_keyword."%'";
			}
			$allPreviewComments=$PreviewComment->query($sql);
		}else{
			import("ORG.Util.Page");//导入分页类
	        $count=$PreviewComment->count();//得到总数
	        $p=new Page($count,15);//每页5条数据
	        $allPreviewComments=$PreviewComment->limit($p->firstRow.','.$p->listRows)->select();
	        $page=$p->show();
        	$this->assign('page',$page);
		}
		$this->assign('allPreviewComments',$allPreviewComments);
	}

	/***********留言回复*************/

	/*
		管理添加留言回复
	*/
	public function save_previewcommentreply(){
		$this->checkUser();
		$DouUser=new DouUserModel();
		$res=$DouUser->find($_REQUEST['uid']);
		if ($res==null) {
			$this->error("用户不存在");
		}
		$PreviewCommentReply=new PreviewCommentReplyModel();
		$data['content']=$_REQUEST['content'];
		$data['time']=date("Y-m-d H:i:s");
		$data['uid']=$_REQUEST['uid'];
		$data['cid']=$_REQUEST['cid'];
		$res=$PreviewCommentReply->add($data);
		if ($res==false) {
			$this->error("添加失败");
		}else{
			$this->success("添加成功");
		}
	}

	/*
		管理获得编辑界面
	*/
	public function edit_previewcommentreply(){
		$this->checkUser();
		$id=$_GET['id'];
		$PreviewCommentReply=new PreviewCommentReplyModel();
		$res=$PreviewCommentReply->find($id);
		if ($res===false || $res==null) {
			$this->error("未找回复信息！");
		}else{
			$this->assign('previewcommentreply',$res);
			$this->display();
		}
	}

	/*
		管理更新配置
	*/
	public function update_previewcommentreply(){
		$this->checkUser();
		$DouUser=new DouUserModel();
		$res=$DouUser->find($_REQUEST['uid']);
		if ($res==null) {
			$this->error("用户不存在");
		}
		$id=$_REQUEST['id'];
		$PreviewCommentReply=new PreviewCommentReplyModel();
		$data['content']=$_REQUEST['content'];
		$data['time']=$_REQUEST['time'];
		$data['uid']=$_REQUEST['uid'];
		$res=$PreviewCommentReply->where($id)->save($data);
		if ($res!==false) {
			$res=$PreviewCommentReply->find($id);
			$this->edit_previewcomment($res['cid']);
		}else{
			$this->error("未找留言或者数据非法！");
		}
	}

	/*
		管理删除回复
	*/
	public function delete_previewcommentreply(){
		$this->checkUser();//验证
		$id=$_GET['id'];
		$PreviewCommentReply=new PreviewCommentReplyModel();
		$res=$PreviewCommentReply->delete($id);
		if ($res===false || $res==0) {
			$this->error("删除失败！");
		}else{
			$this->success("删除成功");
		}
	}

	/*
		管理查找留言
	*/
	protected function get_previewcommentreplys($cid){
		$this->checkUser();//验证
		$PreviewCommentReply=new PreviewCommentReplyModel();
		import("ORG.Util.Page");//导入分页类
	    $count=$PreviewCommentReply->count();//得到总数
	    $p=new Page($count,15);//每页5条数据
	    $allPreviewCommentReplys=$PreviewCommentReply->where('cid='.$cid)->limit($p->firstRow.','.$p->listRows)->select();
	    $page=$p->show();
        $this->assign('page',$page);
		$this->assign('allPreviewCommentReplys',$allPreviewCommentReplys);
	}

}