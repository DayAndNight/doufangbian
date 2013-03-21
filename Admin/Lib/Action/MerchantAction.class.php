<?php

Class MerchantAction extends Action{

	/*
		验证是否拥有管理员身份
	*/
	protected function checkUser(){
		$PublicAction=A('Public');
		$PublicAction->checkUser();
	}

/*************************用户操作****************************/
	/*
		@param groupid 查询组的id
		@param keyword 查询关键字
		@return allMerchants 查到的商家
	*/
	public function searchMerchant(){
		$groupId=$_REQUEST['groupid'];
		$keyword=$_REQUEST['keyword'];

		$Merchant=new MerchantModel();
		$allMerchants=null;
		$search_group=$_POST['search_group'];
		$search_keyword=trim($_POST['search_keyword']);
		$sql1=" SELECT * FROM dfb_merchant WHERE (name LIKE '%".$search_keyword."%' OR major LIKE '%".$search_keyword."%' OR introduction LIKE '%".$search_keyword."%') ";
		$sql2="";
		$sql3=" ORDER BY up DESC ";
		if($search_group==-1){//所有
		}else{
			$sql2=" AND (dfb_merchant.id IN (SELECT DISTINCT merchant_id FROM dfb_groupmerchant_map WHERE mgroup_id=".$search_group."))";
		}
		$sql=$sql1.$sql2.$sql3;
		$allMerchants=$Merchant->query($sql);
		$this->ajaxReturn($allMerchants,"查询成功",1);
	}


/****************************Pages ***************************/
	public function index(){
	 	$this->checkUser();//验证管理员
		$this->getGroups(null);
		$this->filterMerchants();
		$this->display();
	}
	public function add_merchant(){
	 	$this->checkUser();//验证管理员
		$this->getGroups(null);
		$this->display();
	}
	public function cat_manage(){
		$this->getCats();
		$this->display();
	}
	/*管理大组中的小组*/
	public function cat_details(){
		$catid=$_REQUEST['catid'];
		if($catid){
			$Cat=new MerchantCatModel();
			$category=$Cat->getCatGroups($catid,true);
			$selectedGroups=$category['selected_groups'];

			$unselectedGroups=$Cat->getCatGroups($catid,false);
			$this->assign("selectedGroups",$selectedGroups);
			$this->assign("unselectedGroups",$unselectedGroups);
			$this->assign("catid",$catid);
			$this->assign("catname",$category['name']);
			$this->display();
		}else{
			$this->redirect(__GROUP__."/Merchant/cat_manage");
		}
	}
	public function group_manage(){
		$this->getGroups(null);
		$this->display();
	}
	public function group_details(){
		$groupid=$_REQUEST['groupid'];
		if($groupid){
			$Group=new MerchantGroupModel();
			$group=$Group->getGroupMerchants($groupid,true);
			$selectedMerchants=$group['selected_merchants'];
			$unselectedMerchants=$Group->getGroupMerchants($groupid,false);
			$this->assign("selectedMerchants",$selectedMerchants);
			$this->assign("unselectedMerchants",$unselectedMerchants);
			$this->assign("groupid",$groupid);
			$this->assign("groupname",$group['name']);
			$this->display();
		}else{
			$this->redirect(__GROUP__."/Merchant/group_manage");
		}
	}
	public function edit_merchant(){
		if(empty($_REQUEST['id'])){
			$this->error("编辑项不存在!");
		}
		$Merchant=new MerchantModel();
		$condition['id']=trim($_REQUEST['id']);
		$merchant=$Merchant->where($condition)->find();
		if($merchant){
			$this->assign("merchant",$merchant);
		}else{
			$this->error();
		}
		$this->display();
	}
	public function merchant_details(){
		$merchantid=$_REQUEST['merchantid'];
		//test
		$MerchantComment=new MerchantCommentModel();
		$comments=$MerchantComment->getMerchantComments(6);
		if($merchantid){
			$Merchant=new MerchantModel();
			$merchant=$Merchant->find($merchantid);
			if($merchant){
				$this->assign("merchant",$merchant);
				$this->assign("comments",$comments);
				$this->display();
			}else{
				$this->redirect(__GROUP__."/Merchant/index");
			}
		}else{
			$this->redirect(__GROUP__."/Merchant/index");
		}
	}


/********************************** MerchantCat ****************************/

	protected function getCats(){
		$Cat=new MerchantCatModel();
		$cats=$Cat->select();
		$this->assign("merchantCats",$cats);
	}

	/* 添加大组 */
	public function addCat(){
		$catName=trim($_POST['name']);
		$Cat=new MerchantCatModel();
		$result=$Cat->getCatByName($catName);
		if($result){
			$this->error("该分类已经存在，不能重复添加");
		}else{
			$data['name']=$catName;
			$result= $Cat->add($data);
			if($result>0){//添加成功
				$this->redirect(__GROUP__."/Merchant/cat_manage");
			}else{
				$this->error("添加失败！");
			}
		}
	}

	/* 删除大组 */
	public function deleteCat($id){
	 	$this->checkUser();//验证管理员
		$Cat=new MerchantCatModel();
		$result=$Cat->delete($id);
		if($result>0){
			$this->redirect(__GROUP__."/Merchant/cat_manage");
		}else{
			$this->error("删除失败！",__GROUP__."/Merchant/cat_manage");
		}
	}

/********************************** MerchantGroup ****************************/

	/* 移出大组中的小组 */
	public function deleteCatGroups(){
	 	$this->checkUser();//验证管理员
		$catid=$_POST['catid'];
		$groupIds=$_POST['cat_group_ids'];
		if(!$catid||!$groupIds){
			$this->error("移除小组错误！！！");
		}else{
			$Catgroup=new CatgroupMapModel();
			$result=$Catgroup->deleteCatGroups($catid,$groupIds);
			if($result){
				$this->redirect("/Merchant/cat_details/catid/".$catid);
			}else{
				$this->error("移除小组失败！！！");
			}
		}
	}

	/* 将选中的小组添加进大组 */
	public function addCatGroups(){
	 	$this->checkUser();//验证管理员
		//号码的分类
		$catid=$_POST['catid'];
		$groupIds=$_POST['other_group_ids'];
		if(!$catid||!$groupIds){
			$this->error("添加小组失败！！！");
		}else{
			$Catgroup=new CatgroupMapModel();
			$result=$Catgroup->addCatGroups($catid,$groupIds);
			if($result){
				$this->redirect("/Merchant/cat_details/catid/".$catid );
			}else{
				$this->error("添加小组失败！！！");
			}
		}
	}
	/* 根据条件查询小组*/
	protected function getGroups($condition){
		$Group=new MerchantGroupModel();
		$merchantGroups=$Group->where($condition)->select();
		$this->assign('merchantGroups',$merchantGroups);
	}
	/* 添加小组 */
	public function addGroup(){
	 	$this->checkUser();//验证管理员
		$groupName=trim($_POST['name']);
		$Group=new MerchantGroupModel();
		$result=$Group->getGroupByName($groupName);
		if($result){
			$this->error("该分类已经存在，不能重复添加");
		}else{
			$data['name']=$groupName;
			$result= $Group->add($data);
			if($result>0){//添加成功
				$this->redirect(__GROUP__."/Merchant/group_manage");
			}else{
				$this->error("添加失败！");
			}
		}
	}
	/* 删除小组 */
	public function deleteGroup($id){
	 	$this->checkUser();//验证管理员
		$MerchantGroup=new MerchantGroupModel();
		$result=$MerchantGroup->delete($id);
		if($result>0){
		    $this->redirect(__GROUP__."/Merchant/group_manage");
		}else{
			$this->error("删除失败！",__GROUP__."/Merchant/group_manage");
		}
	}

/********************************** Merchant ****************************/
	/*根据关键字来查询商家*/
	protected function filterMerchants(){
		$Merchant=new MerchantModel();
		$allMerchants=null;
		if(isset($_POST['dosearch'])){
			$search_group=$_POST['search_group'];
			$search_keyword=trim($_POST['search_keyword']);
			$sql1=" SELECT * FROM dfb_merchant WHERE (name LIKE '%".$search_keyword."%' OR major LIKE '%".$search_keyword."%' OR introduction LIKE '%".$search_keyword."%') ";
			$sql2="";
			$sql3=" ORDER BY up DESC ";
			if($search_group==-1){//所有
			}else{
				$sql2=" AND (dfb_merchant.id IN (SELECT DISTINCT merchant_id FROM dfb_groupmerchant_map WHERE mgroup_id=".$search_group."))";
			}
			$sql=$sql1.$sql2.$sql3;
			$allMerchants=$Merchant->query($sql);
		}else{
			$Merchant=new MerchantModel();
			$allMerchants= $Merchant->order('up desc')->select();
		}
		$this->assign("allMerchants",$allMerchants);
	}

	/*删除商家*/
	public function deleteMerchant($id){
	 	$this->checkUser();//验证管理员
		$Merchant=new MerchantModel();
		$result=$Merchant->delete($id);
		if($result>0){
			$this->redirect(__GROUP__."/Merchant/index");
		}else{
			$this->error("删除商家失败！！！");
		}
	}
	/*从一个小组中移除选中的商家*/
	public function addGroupMerchants(){
	 	$this->checkUser();//验证管理员
		$groupid=$_POST['groupid'];
		$merchantIds=$_POST['other_merchant_ids'];
		if(!$groupid||!merchantIds){
			$this->error("添加商家错误！！！");
		}else{
			$GroupMerchant=new GroupmerchantMapModel();
			$result=$GroupMerchant->addGroupMerchants($groupid,$merchantIds);
			if($result){
				$this->redirect("/Merchant/group_details/groupid/".$groupid );
			}else{
				$this->error("添加商家失败！！！");
			}
		}
	}
	/*向一个小组中添加选中的商家*/
	public function deleteGroupMerchants(){
	 	$this->checkUser();//验证管理员
		$groupid=$_POST['groupid'];
		$merchantIds=$_POST['group_merchant_ids'];
		if(!$groupid||!$merchantIds){
			$this->error("移除商家错误！！！");
		}else{
			$GroupMerchant=new GroupmerchantMapModel();
			$result=$GroupMerchant->deleteGroupMerchants($groupid,$merchantIds);
			if($result){
				$this->redirect("/Merchant/group_details/groupid/".$groupid );
			}else{
				$this->error("移除商家失败！！！");
			}
		}
	}

	/*添加新的商家*/
	public function addMerchant(){
	 	$this->checkUser();//验证管理员
		if(!isset($_POST['dosubmit'])){
			return;
		}
		$name=trim($_POST['name']);
		$major=trim($_POST['major']);
		$introduction=trim($_POST['introduction']);
		$news=trim($_POST['news']);
		$address=trim($_POST['address']);
		$phone=trim($_POST['phone']);
		$website=trim($_POST['website']);

		$isrecommend=$_POST['isrecommend'];
		$status=$_POST['status'];
		if($isrecommend){
			$isrecommend=1;
		}else{
			$isrecommend=0;
		}
		if($status){
			$status=1;
		}else{
			$status=0;
		}
		$Merchant=new MerchantModel();
		$result=$Merchant->getMerchantByName($name);
		if($result){
			$this->error("该商家已经存在，不能重复添加");
		}else{
			$data['name']=$name;
			$data['major']=$major;
			$data['introduction']=$introduction;
			$data['news']=$news;
			$data['address']=$address;
			$data['phone']=$phone;
			$data['website']=$website;
			$data['isrecommend']=$isrecommend;
			$data['status']=$status;
			$data['up']=0;
			$effectId=$Merchant->add($data);
			if($effectId){//添加商家成功
				$this->redirect(__GROUP__."/Merchant/index");
			}else{
				$this->error("添加失败！");
			}
		}
	}
	/*修改商家*/
	public function updateMerchant(){
	 	$this->checkUser();//验证管理员
		if(!isset($_POST['dosubmit'])){
			return;
		}
		$id=$_POST['id'];
		$name=trim($_POST['name']);
		$major=trim($_POST['major']);
		$introduction=trim($_POST['introduction']);
		$news=trim($_POST['news']);
		$address=trim($_POST['address']);
		$phone=trim($_POST['phone']);
		$website=trim($_POST['website']);

		$isrecommend=$_POST['isrecommend'];
		$status=$_POST['status'];
		if($isrecommend){
			$isrecommend=1;
		}else{
			$isrecommend=0;
		}
		if($status){
			$status=1;
		}else{
			$status=0;
		}
		//号码的分类
		$type_ids=array();
		foreach ($_POST['type_ids'] as $tid) {
			array_push($type_ids,$tid);
		}
		if(!$id){
			$this->error("出错了");
		}

		$Merchant=new MerchantModel();
		$data['id']=$id;
		$data['name']=$name;
		$data['major']=$major;
		$data['introduction']=$introduction;
		$data['news']=$news;
		$data['address']=$address;
		$data['phone']=$phone;
		$data['website']=$website;
		$data['isrecommend']=$isrecommend;
		$data['status']=$status;
		$effectId=$Merchant->save($data);
		$this->redirect(__GROUP__."/Merchant/index");
	}

/***********************************Merchant Comments *******************/
	public function deleteMerchantComms(){
	 	$this->checkUser();//验证管理员
		$merchantid=$_POST['merchantid'];
		$commentIds=$_POST['select_comments'];
		if(!$merchantid||!$commentIds){
			$this->error("删除评论错误!!!");
		}else{
			$MerchantComment=new MerchantCommentModel();
			$result=$MerchantComment->deleteMerchantComms($commentIds);
			if($result){
				$this->redirect("/Merchant/merchant_details/merchantid/".$merchantid);
			}else{
				$this->error("删除评论失败！！！");
			}
		}
	}
}
?>