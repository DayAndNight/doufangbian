<?php
Class GroupmerchantMapModel extends Model{
	public function addGroupMerchants($groupId,$merchantIds){
		foreach ($merchantIds as $mid) {
			$data['mgroup_id']=$groupId;
			$data['merchant_id']=$mid;
			$result=$this->add($data);
			if(!$result||$result==0){
				return false;
			}
		}
		return true;
	}

	public function deleteGroupMerchants($groupId,$merchantIds){
		foreach ($merchantIds as $mid) {
			$data['mgroup_id']=$groupId;
			$data['merchant_id']=$mid;
			$result=$this->where($data)->delete();
			if(!$result||$result==0){
				return false;
			}
		}
		return true;
	}
}