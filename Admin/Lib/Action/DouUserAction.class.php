<?php
class DouUserAction extends Action {

	/*
		管理员用户模块首页
	*/
	public function index(){
	 	$this->checkUser();
	 	$this->filter_douusers();
        $this->display();
	}

	protected function checkUser(){
		$PublicAction=A('Public');
		$PublicAction->checkUser();
	}

	/*
		用户注册
		@param photo 头像文件
		@param username 用户名
		@param password 密码
		@param gender 性别
		@param phone 电话
		@param qq QQ
		@return res用户信息（成功）
	*/
	public function regist(){
		//$DouUser=M('DouUser');
		$DouUser=new DouUserModel();
		$username=$_REQUEST['username'];
		if ($DouUser->isExistUserName($username)==false) {
			if(!empty($_FILES)){
				import("ORG.Net.UploadFile");
				$upload = new UploadFile();
				$upload->maxsize = 3145728;
				$upload->allowExts = explode(',',"jpg,gif,jpeg,png");
				$upload->savePath = "./Public/image/"; //注意 目录为入口文件的相对路径
				$upload->thumb = true;
				$upload->imageClassPath = 'ORG.Util.Image';
				//生成一张缩略图
				$upload->thumbPrefix ='dou_'; 
				$upload->thumbMaxWidth = '100';
				$upload->thumbMaxHeight = '100';
				$upload->saveRule = uniqid;
				$upload->thumbRemoveOrigin = true;
				if(!$upload->upload()){
					$this->ajaxReturn("头像上传失败","注册失败",0);
				}else{
					$info = $upload->getUploadFileInfo();
					$photo= __ROOT__.'/Public/image/'.'dou_'.$info[0]['savename'];
					$data['photo']=$photo;
				}
			}
			$gender=$_REQUEST['gender'];
			$data['username']=$username;
			$data['password']=$_REQUEST['password'];
			$data['gender']=$_REQUEST['gender'];
			$data['phone']=$_REQUEST['phone'];
			$data['qq']=$_REQUEST['qq'];
			$data['cash']=0;
			$data['message']="快邀请周边的朋友加入吧";
			$data['status']=1;
			$resId=$DouUser->add($data);
			if ($resId!==false) {
				$res=$DouUser->find($resId);
				$params['token']=md5($res['id'].$res['username'].$res['password']);
				$DouUser->where('id='.$res['id'])->save($params);
				$res=$DouUser->find($resId);
				$this->ajaxReturn($res,"注册成功",1);
			}else{
				$this->ajaxReturn("","注册失败",0);
			}
		}else{
			$this->ajaxReturn("用户名已存在","注册失败",0);
		}
	}


	/*
		用户登录
		@param username 用户名
		@param password 密码
		@return douuser 用户信息
	*/
	public function login(){
		$username=$_REQUEST['username'];
		$password=$_REQUEST['password'];
	    $condition['username']=$username;
	    $DouUser=new DouUserModel();
	    $res=$DouUser->where($condition)->find();
	    if ($res===false || $res==null) {
	      	$this->ajaxReturn("用户名不存在","登录失败",0);
	    }else{
	      	if ($res->password==$password) {
	      		$this->ajaxReturn($res,"登录登录",1);
	      	}else{
	      		$this->ajaxReturn("密码错误","登录失败",0);
	      	}
	    }
	}

	/*
		用户注册
		@param photo 头像文件
		@param username 用户名
		@param password 密码
		@param gender 性别
		@param phone 电话
		@param qq QQ
		@return res用户信息（成功）
	*/
	public function restInfo(){
		$id=$_REQUEST['id'];
		$token=$_REQUEST['token'];
		$DouUser=new DouUserModel();
		if ($DouUser->authorize($id,$token)==true) {
			$user=$DouUser->find($id);
			if(!empty($_FILES)){
				import("ORG.Net.UploadFile");
				$upload = new UploadFile();
				$upload->maxsize = 3145728;
				$upload->allowExts = explode(',',"jpg,gif,jpeg,png");
				$upload->savePath = "./Public/image/"; //注意 目录为入口文件的相对路径
				$upload->thumb = true;
				$upload->imageClassPath = 'ORG.Util.Image';
				//生成一张缩略图
				$upload->thumbPrefix ='dou_'; 
				$upload->thumbMaxWidth = '100';
				$upload->thumbMaxHeight = '100';
				$upload->saveRule = uniqid;
				$upload->thumbRemoveOrigin = true;
				if(!$upload->upload()){
					$this->ajaxReturn("头像上传失败","注册失败",0);
				}else{
					$info = $upload->getUploadFileInfo();
					$photo= __ROOT__.'/Public/image/'.'dou_'.$info[0]['savename'];
					$data['photo']=$photo;
				}
			}
			$gender=$_REQUEST['gender'];
			$data['username']=$username;
			$data['password']=$_REQUEST['password'];
			$data['gender']=$_REQUEST['gender'];
			$data['phone']=$_REQUEST['phone'];
			$data['qq']=$_REQUEST['qq'];
			$data['cash']=0;
			$data['message']="快邀请周边的朋友加入吧";
			$data['status']=1;

			//获得旧的头像，如果用户信息修改成功则删除
			$oldphotopath=$user['photo'];
			$resId=$DouUser->add($data);
			if ($resId!==false) {
				$res=$DouUser->find($resId);
				$params['token']=md5($res['id'].$res['username'].$res['password']);
				$DouUser->where('id='.$res['id'])->save($params);
				$res=$DouUser->find($resId);

				//删除旧头像
				if ($res['photo']!=$oldphotopath) {
					$pos=strpos($oldphotopath,'/Public',0);
					$photopath='.'.substr($oldphotopath,$pos,strlen($oldphotopath));
					if( file_exists($photopath) ) {
			   			unlink($photopath);
			  		}
				}

				$this->ajaxReturn($res,"注册成功",1);
			}else{
				$this->ajaxReturn("","注册失败",0);
			}
		}else{
			$this->ajaxReturn("用户名已存在","注册失败",0);
		}
	}

	/*
		用户签到
		@param id 用户id
		@param token 验证key
		@return cash 豆币
	*/
	public function checkin(){
		$id=$_REQUEST['id'];
		$token=$_REQUEST['token'];
		$DouUser=new DouUserModel();
		if ($DouUser->authorize($id,$token)==true) {
			$user=$DouUser->find($id);
			if ((time()-strtotime($user['checkin']))>60*60) {
				$params['checkin']=date("Y-m-d H:i:s", time()); 
				$params['cash']=$user['cash']+5;
				$res=$DouUser->where("id=".$user['id'])->save($params);
				$user=$DouUser->find($id);
				$this->ajaxReturn($user['cash'],"签到成功",1);
			}else{
				$this->ajaxReturn("您上次签到的时间是".$user['checkin']."请一小时后在签到","签到失败",0);
			}
		}else{
			return;
			$this->ajaxReturn("用户验证失败，可尝试重新登录","签到失败",0);
		}
	}

	/*
		管理员添加用户
	*/
	public function save_douuser(){
	 	$this->checkUser();//验证
		$username=$_POST['username'];
		$DouUser=new DouUserModel();
		if ($DouUser->isExistUserName($username)==false) {
			if(!empty($_FILES)){
				import("ORG.Net.UploadFile");
				$upload = new UploadFile();
				//设置上传文件大小
				$upload->maxsize = 3145728;
				//设置上传文件类型
				$upload->allowExts = explode(',',"jpg,gif,jpeg,png");
				//设置附近上传目录
				$upload->savePath = "./Public/image/"; //注意 目录为入口文件的相对路径
				//设置需要生成缩略图他，仅对图片文件有效
				$upload->thumb = true;
				//设置引用图片类库包路径
				$upload->imageClassPath = 'ORG.Util.Image';
				//设置需要生成缩略图他的文件后缀
				//$upload->thumbPrefix ='m_,s_'; 
				//生成2张缩略图
				//设置缩略图最大宽度
				//$upload->thumbMaxWidth = '400,100';
				//设置缩略图最大高度
				//$upload->thumbMaxHeight = '400,100';

				//生成一张缩略图
				$upload->thumbPrefix ='dou_'; 
				$upload->thumbMaxWidth = '100';
				$upload->thumbMaxHeight = '100';
				//设置上传文件规则
				$upload->saveRule = uniqid;
				//删除原图
				$upload->thumbRemoveOrigin = true;
				if(!$upload->upload()){
					//捕获上传异常
					$this->error($upload->getErrorMsg());
				}else{
					//取得成功上传文件信息
					$info = $upload->getUploadFileInfo();
					$photo= __ROOT__.'/Public/image/'.'dou_'.$info[0]['savename'];
					$data['photo']=$photo;
				}
			}
			$data['username']=$username;
			$data['password']=$_REQUEST['password'];
			/*if ($_REQUEST['gender']=='0') {
				$data['gender']=0;//girl
			}else{
				$data['gender']=1;//boy
			}*/
			$data['gender']=$_REQUEST['gender'];
			$data['phone']=$_REQUEST['phone'];
			$data['qq']=$_REQUEST['qq'];
			$data['cash']=$_REQUEST['cash'];
			$data['savecash']=$_REQUEST['savecash'];
			$data['message']=$_REQUEST['message'];
			$data['status']=$_REQUEST['status'];
			$resId=$DouUser->add($data);
			if ($res!==false) {
				$user=$DouUser->find($resId);
				$params['token']=md5($user['id'].$user['username'].$user['password']);
				$DouUser->where($resId)->save($params);
				$this->redirect(__GROUP__."/DouUser/index");
			}else{
				$this->error('添加失败!');
			}
		}else{
			$this->error('用户名已存在!');
		}
	}

	/*
		管理删除用户
	*/
	public function delete_douuser(){
		$this->checkUser();//验证
		$id=$_GET['id'];
		$DouUser=D('DouUser');
		$user=$DouUser->find($id);
		//获取头像的路径用于删除
		$pos=strpos($user['photo'],'/Public',0);
		$photopath='.'.substr($user['photo'],$pos,strlen($user['photo']));
		if( file_exists($photopath) ) {
   			unlink($photopath);
  		}
		$res=$DouUser->delete($id);
		if ($res===false || $res==0) {
			$this->error("删除失败！",__GROUP__."/DouUser/index");
		}else{
			$this->redirect(__GROUP__."/DouUser/index");
		}
	}

	/*
		管理获得一个用户
	*/
	public function edit_douuser(){
		$this->checkUser();//验证
		$id=$_REQUEST['id'];
		$DouUser=new DouUserModel();
		$res=$DouUser->find($id);
		if ($res===false || $res==null) {
			$this->error("未找到用户！",__GROUP__."/DouUser/index");
		}else{
			$this->assign('douuser',$res);
			$this->display();
		}
	}

	/*
		管理修改用户
	*/
	public function update_douuser(){
		$this->checkUser();//验证
		if (!isset($_POST['dosubmit'])) {
			return;
		}
		$id=$_POST['id'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		if(!empty($_FILES) && $_POST['newphoto']=='on'){
			import("ORG.Net.UploadFile");
			$upload = new UploadFile();
			$upload->maxsize = 3145728;
			$upload->allowExts = explode(',',"jpg,gif,jpeg,png");
			$upload->savePath = "./Public/image/"; //注意 目录为入口文件的相对路径
			$upload->thumb = true;
			$upload->imageClassPath = 'ORG.Util.Image';
			$upload->thumbPrefix ='dou_'; 
			$upload->thumbMaxWidth = '100';
			$upload->thumbMaxHeight = '100';
			$upload->saveRule = uniqid;
			//删除原图
			$upload->thumbRemoveOrigin = true;
			if(!$upload->upload()){
				//捕获上传异常
				$this->error($upload->getErrorMsg());
			}else{
				//取得成功上传文件信息
				$info = $upload->getUploadFileInfo();
				$photo= __ROOT__.'/Public/image/'.'dou_'.$info[0]['savename'];
				$data['photo']=$photo;
			}
		}
		$DouUser=D('DouUser');
		$data['id']=$id;
		$data['username']=$username;
		$data['password']=$_REQUEST['password'];
		$data['gender']=$_REQUEST['gender'];
		$data['phone']=$_REQUEST['phone'];
		$data['qq']=$_REQUEST['qq'];
		$data['cash']=$_REQUEST['cash'];
		$data['savecash']=$_REQUEST['savecash'];
		$data['message']=$_REQUEST['message'];
		$data['status']=$_REQUEST['status'];
		$resId=$DouUser->add($data);
		$res=$DouUser->save($data);
		if ($res!==false) {
			$this->redirect(__GROUP__."/DouUser/index");
		}else{
			$this->error("未找到用户或者数据非法！",__GROUP__."/DouUser/index");
		}
	}

	/*
		发送广播
	*/
	public function send_broadcast(){
		$this->checkUser();//验证
		$message=$_POST['message'];
		$DouUser=new DouUserModel();
		$res=$DouUser->execute("UPDATE dfb_dou_user SET message='".$message."';");
		if ($res===false) {
			$this->error("发送失败！",__GROUP__."/DouUser/index");
		}else{
			$this->redirect(__GROUP__."/DouUser/index");
		}
	}

	protected function filter_douusers(){
		$this->checkUser();//验证
		$DouUser=new DouUserModel();
		$allDouUsers=null;
		if(isset($_POST['dosearch'])){
			$search_field=$_POST['search_field'];
			$search_keyword=trim($_POST['search_keyword']);
			if ($search_field=='id') {
				$sql=" SELECT * FROM dfb_dou_user WHERE id=".$search_keyword;
			}else{
				$sql=" SELECT * FROM dfb_dou_user WHERE ".$search_field." LIKE '%".$search_keyword."%'";
			}
			$allDouUsers=$DouUser->query($sql);
		}else{
			$allDouUsers=$DouUser->select();

			import("ORG.Util.Page");//导入分页类
	        $count=$DouUser->count();//得到总数
	        $p=new Page($count,15);//每页5条数据
	        $allDouUsers=$DouUser->limit($p->firstRow.','.$p->listRows)->select();   
	        $page=$p->show();
        	$this->assign('page',$page);
		}
		$this->assign('allDouUsers',$allDouUsers);
	}
}