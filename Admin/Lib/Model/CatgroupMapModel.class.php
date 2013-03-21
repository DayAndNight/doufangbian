<?php
Class CatgroupMapModel extends Model{
	public function addCatGroups($catId,$groupIds){
		foreach ($groupIds as $gid) {
			$data['cat_id']=$catId;
			$data['cgroup_id']=$gid;
			$result=$this->add($data);
			if(!$result||$result==0){
				return false;
			}
		}
		return true;
	}

	public function deleteCatGroups($catId,$groupIds){
		foreach ($groupIds as $gid) {
			$data['cat_id']=$catId;
			$data['cgroup_id']=$gid;
			$result=$this->where($data)->delete();
			if(!$result||$result==0){
				return false;
			}
		}
		return true;
	}
}
?>