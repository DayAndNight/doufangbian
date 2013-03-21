<?php
Class PhoneAction extends Action{
	/*显示index.html*/
	public function index(){
		$this->search_phones_by_type();
		$this->getPhoneTypes();
		$this->display();
	}
	/*显示phone_type.html*/
	public function phone_type(){
		$this->getPhoneTypes();
		$this->display();
	}
	public function add_phone(){
		$this->getPhoneTypes();
		$this->display();
	}
	public function edit_phone(){
		$this->getPhoneTypes();

		if(empty($_REQUEST['id'])){
			$this->error("编辑项不存在!");
		}
		$Phone=new PhoneModel();
		$phone=$Phone->where(array('id'=>trim($_REQUEST['id'])))->find();
		if($phone){
			$this->assign("vo",$phone);
		}else{
			$this->error();
		}
		$this->display();
	}
	
	protected function search_phones_by_type(){
		$tid=$_POST['search_type'];
		$search_keyword=trim($_POST['search_keyword']);
		$search_keynum=trim($_POST['search_keynum']);

		$sql1="";
		$sql2="";
		$sql3="";

		 if($tid!=null&&$tid!=-1){//所有分类
		 	$sql1="SELECT dfb_phone.* FROM dfb_phone,dfb_phone_map WHERE dfb_phone.id=dfb_phone_map.pid AND dfb_phone_map.tid=".$tid;
		 }
		 if($search_keyword!=null&&$search_keyword!=""){
		 	$sql2=" AND dfb_phone.name LIKE %"+$search_keyword+"% OR dfb_phone.address LIKE %".$search_keyword."%";
		 }
		 if($search_keynum!=null&&$search_keynum!=""){
		 	$sql3=" AND dfb_phone.phone LIKE %".$search_keynum."%";
		 }
		 $search_sql=$sql1.$sql2.$sql3;

		 var_dump($sql1);
		 
		 $Phone =new PhoneModel();
		 $phones=$Phone->query($search_sql);
		 $this->assign("allPhones",$phones);
	}

	protected function filter_phone(){
		
		$sub_condition=array();
		if(isset($search_keyword)&&!empty($search_keyword)){
			$sub_condition['name'] =array('like','%'.$search_keyword.'%');
			$sub_condition['address'] =array('like','%'.$search_keyword.'%');
			$sub_condition['_logic']="or";
		}
		$condition=array();
		if($search_keynum!=null&&$search_keynum!=""){
			$condition['phone']=array('like','%'.$search_keynum.'%');
		}
		$this->getPhones($sub_condition);
	}
	protected function getPhones($condition){
		$Phones=new PhoneModel();
		$allPhones= $Phones->where($condition)->relation(true)->select();
		$this->assign("allPhones",$allPhones);
	}

	protected function getPhoneTypes(){
		$PhoneType=new PhoneTypeModel();
		$phoneTypes= $PhoneType->select();
		$this->assign('phoneTypes',$phoneTypes);
	}

	public function addPhoneType(){
		$name=$_POST['name'];
		$PhoneType=new PhoneTypeModel();
		$result=$PhoneType->getPhoneType($name);
		if($result){
			$this->error("该分类已经存在，不能重复添加");
		}else{
			$result=$PhoneType->addPhoneType($name);
			if($result){//添加成功
				$this->redirect(__GROUP__."/Phone/phone_type");
			}else{
				$this->error("添加失败！",__GROUP__."/Public/index");
			}
		}
	}

	public function deletePhoneType($id){
		$PhoneType=new PhoneTypeModel();
		$result=$PhoneType->delete($id);
		if($result){
			$this->redirect(__GROUP__."/Phone/phone_type");
		}else{
			$this->error("删除失败！",__GROUP__."/Phone/phone_type");
		}
	}

	


	public function deletePhone($id){
		$Phone=new PhoneModel();
		$result=$Phone->delete($id);
		if($result){
			$this->redirect(__GROUP__."/Phone/index");
		}else{
			$this->error("删除失败！");
		}
	}

	public function addPhone(){
		$name=$_POST['name'];
		$address=$_POST['address'];
		$phone=$_POST['phone'];
		$isrecommend=$_POST['isrecommend'];
		//号码的分类
		$type_ids=array();
		foreach ($_POST['type_ids'] as $i) {
			array_push($type_ids,$i);
		}
		$up=0;
		if($isrecommend){
			$isrecommend=1;
		}else{
			$isrecommend=0;
		}
		$Phone=new PhoneModel();
		$condition['phone']=$phone;
		$result=$Phone->getPhone($condition);
		if($result){
			$this->error("该号码已经存在，不能重复添加");
		}else{
			$data['name']=$name;
			$data['address']=$address;
			$data['phone']=$phone;
			$data['isrecommend']=$isrecommend;
			$data['up']=$up;
			$data['callnum']=0;
			$effectId=$Phone->addPhone($data);
			if($effectId){//添加号码成功
				$PhoneMap=new PhoneMapModel();
				foreach ($type_ids as $id) {
					$result=$PhoneMap->insert($id,$effectId);
					if(!$result||$result==null){//添加分组成功
						$this->error("添加分组失败！");
					}
				}
				$this->redirect(__GROUP__."/Phone/index");
			}else{
				$this->error("添加失败！");
			}
		}
	}

	public function updatePhone(){

	}
}
?>