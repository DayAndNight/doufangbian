<?php
Class MerchantGroupModel extends RelationModel{
	protected $_link=array(
    "selected_merchants"=>array(
      "mapping_type"=>MANY_TO_MANY,
      "class_name"=>"Merchant",
      "foreign_key"=>"mgroup_id",//中间表的字段
      "relation_foreign_key"=>"merchant_id",//中间表的字段
      "relation_table"=>"dfb_groupmerchant_map"
       )
    );

	public function getGroupByName($typeName){
		$condition['name']=$typeName;
		$result=$this->where($condition)->find();
		if($result&&$result!=null){
			return true;
		}else{
			return false;
		}
	}
	/* 查询某一小组下的所有商家 */
	public function getGroupMerchants($groupId,$isSelected){
	if($isSelected){//查找属于大组的小组
        $condition['id']=$groupId;
        $group=$this->where($condition)->relation(true)->find();
       
        return $group;
      }else{//查找不属于大组的小组
        $sql="SELECT * FROM dfb_merchant WHERE id NOT IN (SELECT DISTINCT merchant_id FROM dfb_groupmerchant_map WHERE mgroup_id=".$groupId.")";
        $Merchant=new MerchantModel();
        $unselectedMerchants=$Merchant->query($sql);
        // print_r($unselectedMerchants);
        return $unselectedMerchants;
      }
     }
}
?>