<?php
Class DouUserModel extends RelationModel{
  public function isExistUserName($username){
    $condition['username']=$username;
    $res=$this->where($condition)->find();
    if ($res===false || $res==null) {
      return false;
    }else{
      return true;
    }
  }

  public function authorize($id,$token){
    $res=$this->find($id);
    if ($res===false || $res==null) {
      return false;
    }else{
      if (md5($res['id'].$res['username'].$res['password'])==$token) {
        return true;
      }else{
        return false;
      }
    }
  }
}
?>