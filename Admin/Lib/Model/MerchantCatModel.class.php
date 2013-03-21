<?php
Class MerchantCatModel extends RelationModel{
  protected $_link=array(
    "selected_groups"=>array(
      "mapping_type"=>MANY_TO_MANY,
      "class_name"=>"MerchantGroup",
      "foreign_key"=>"cat_id",//中间表的字段
      "relation_foreign_key"=>"cgroup_id",//中间表的字段
      "relation_table"=>"dfb_catgroup_map"
       )
    );
  public function getCatGroups($catId,$isSelected){
    if($isSelected){//查找属于大组的小组
        $condition['id']=$catId;
        $category=$this->where($condition)->relation(true)->find();
        return $category;
      }else{//查找不属于大组的小组
        $sql="SELECT * FROM dfb_merchant_group WHERE id NOT IN (SELECT DISTINCT cgroup_id FROM dfb_catgroup_map WHERE cat_id=".$catId.")";
        $Group=new MerchantGroupModel();
        $unselectedGroups=$Group->query($sql);
        return $unselectedGroups;
      }
     }

  public function getCatByName($catName){
    $condition['name']=$catName;
    $result=$this->where($condition)->find();
    if(!$result)
    if($result>0){
      return true;
    }else{
      return false;
    }
  }
}
?>