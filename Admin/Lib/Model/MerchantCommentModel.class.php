<?php
Class MerchantCommentModel extends Model{

	public function getMerchantComments($merchantId){
		$condition["merchant_id"]=$merchantId;
		return $this->where($condition)->order("time desc")->select();
	}

	public function deleteMerchantComms($commentIds){
		foreach ($commentIds as $cid) {
			$result=$this->delete($cid);
			if($result==0){
				return false;
			}
		}
		return true;
	}
}
?>