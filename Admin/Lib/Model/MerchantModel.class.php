<?php
Class MerchantModel extends Model{
	/* protected $_link=array(
       "merchant_type"=>array(
           "mapping_type"=>MANY_TO_MANY,
           "foreign_key"=>"mid",//中间表的字段
           "relation_foreign_key"=>"tid",//中间表的字段
           "relation_table"=>"dfb_merchant_map"
       )
     );*/
	public function getMerchantByName($name){
		$condition['name']=$name;
		$result=$this->where($condition)->find();
		if($result&&$result!=null){
			return true;
		}else{
			return false;
		}
	}
}
?>