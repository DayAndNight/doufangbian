<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<!-- 管理大组中的小组 -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>豆方便管理系统</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="xmu.SwordBearer">
	<style type="text/css">
	body{
		font-family: "微软雅黑","宋体";
	}
	</style>
	<script type="text/javascript">
	function selectAll(elementName){
		var checkboxs=document.getElementsByName(elementName);
		for (i = 0; i < checkboxs.length; i++){
			checkboxs[i].checked = true;
		}
	}
	function notselectAll(elementName){
		var checkboxs=document.getElementsByName(elementName);
		for (i = 0; i < checkboxs.length; i++){
			checkboxs[i].checked = false;
		}
	}
	function checkSelect(elementName){
		var checkboxs=document.getElementsByName(elementName);
		var count=0;
		for (i = 0; i < checkboxs.length; i++){
			if(checkboxs[i].checked){
				count++;
			}
		}
		return count;
	}
	function deleteMerchantComms(){
		var count=checkSelect("select_comments[]");
		if(count>0){
			if(confirm("确定删除选中的评论吗?")){
				document.comments_form.action="__URL__/deleteMerchantComms";}
			else{
				return false;
			}
		}else{
			window.alert("请先选择要删除的评论!!!");
		}
	}
	</script>
</head>
<body>
	<div style="background:#FFFFFF;height:25px;margin-bottom:5px;width:100%;">
	<p>
		<a href="<?php echo U('index');?>"  target="main" title="管理商家" style="text-decoration:none;color:#333">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">管理商家</span>
		</a>
		<a href="<?php echo U('add_merchant');?>" style="text-decoration:none;" target="main" title="添加商家">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">添加商家</span>
		</a>
		<a href="<?php echo U('group_manage');?>" style="text-decoration:none;" target="main" title="分类管理">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">小组管理</span>
		</a>
		<a href="<?php echo U('cat_manage');?>" style="text-decoration:none;" target="main" title="分类管理">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">大组管理</span>
		</a>
	</p>
</div>
<hr style="margin-right:10px;color:#EEEEEE;"/>
	<span>
		商家详情> <b><?php echo ($merchant["name"]); ?></b>
	</span>
	<br/>
	<br/>
	<div style="max-width:600px;">
		<span> <b>主营:</b>
			<?php echo ($merchant["major"]); ?>
		</span>
		<br/>
		<br/>
		<span>
			<b>电话:</b>
			<?php echo ($merchant["phone"]); ?>
		</span>
		<br/>
		<br/>
		<span>
			<b>网址:</b> <i><a href="<?php echo ($merchant["website"]); ?>" target="_blank"><?php echo ($merchant["website"]); ?></a></i> 
		</span>
		<br/>
		<br/>
		<span>
			<b>地址:</b>
			<?php echo ($merchant["address"]); ?>
			<a href="http://map.baidu.com/?newmap=1&ie=utf-8&s=s%26wd%3D<?php echo ($merchant["address"]); ?>" target="_blank">(地图)</a>
		</span>
		<br/>
		<br/>
		<b>最新资讯:</b>
		<?php echo ($merchant["news"]); ?>
		<br/>
		<br/>
		<span>
			<b>简介:</b>
			<?php echo ($merchant["introduction"]); ?>
		</span>
		<br/>
		<br/>
	</div>
	<form name="comments_form" method="post">
		<span>
			<a href="">用户评论</a>
		</span>
		<table name="tbl_comments" width="600px" style="background:#E0EEEE;border:1px solid black">
			<?php if(is_array($comments)): $i = 0; $__LIST__ = $comments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					<td align="center" width="50px"><?php echo ($vo['user_id']); ?></td>

					<td>
						<label><?php echo ($vo["time"]); ?></label>
						<br/>
						<?php echo ($vo["content"]); ?>
					</td>
					<td align="center" width="50px">
						<input type="checkbox"  value="<?php echo ($vo['id']); ?>" name="select_comments[]"/>
					</td>
				</tr><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
		<span>
			<input type="button" id="selectBtn" value="全选"  onclick="selectAll('select_comments[]')"/>
			<input type="button" value="取消"  onclick="notselectAll('select_comments[]')"/>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="hidden" value="<?php echo ($merchant["id"]); ?>" name="merchantid"/>
			<input type="submit" value="删除" onclick="deleteMerchantComms()"/>
		</span>
	</form>
</body>
</html>