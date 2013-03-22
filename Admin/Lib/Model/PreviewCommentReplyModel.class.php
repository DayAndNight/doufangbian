<?php
Class PreviewCommentReplyModel extends RelationModel{
	protected $_link=array(
       "user"=>array(
           	"mapping_type"=>BELONGS_TO,
          	"class_name"=>'DouUser',
          	"foreign_key"=>"uid",
    		"as_fields"=>"username"
       ),
       "comment"=>array(
           	"mapping_type"=>BELONGS_TO,
          	"class_name"=>'PreviewComment',
          	"foreign_key"=>"cid"
       )
     );
}
?>