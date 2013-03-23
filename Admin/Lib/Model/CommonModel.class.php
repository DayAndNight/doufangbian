<?php
Class CommonModel extends Model{
  public function isExistAreacode($areacode){
    $condition['areacode']=$areacode;
    $res=$this->where($condition)->find();
    if ($res===false || $res==null) {
      return false;
    }else{
      return true;
    }
  }
}
?>