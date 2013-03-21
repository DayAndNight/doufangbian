<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>豆方便管理系统</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="xmu.SwordBearer">
	<style type="text/css">
	body{
		font-family: "微软雅黑","宋体";
	}
	</style>
	<script language="Javascript">
	function request_focus(){
		document.getElementById("input_name").focus();
	}
	function delete_group(merchant_id)
	{
		if(confirm("确定删除该商家分类吗?")){
		  return document.group_form.action="__URL__/deleteGroup/id/"+merchant_id;
		}else{
			return false;
		}
	}
</script>
</head>
<body onload="request_focus()">
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
	<form method="post" action="<?php echo U('addGroup');?>">
		<label for="name">小组名称:</label>
		<input type="text" id="input_name" name="name" style="min-width:180px;" required/>
		<input type="submit" value="添加"/>
	</form>
	<form name="group_form">
		<table cellspacing="0" style="width:400px;">
			<thead  style="background:#C0C0C0;">
				<tr>
					<th width="50" align="center">ID</th>
					<th width="200" align="center">名称</th>
					<th width="100" align="center">管理</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($merchantGroups)): $i = 0; $__LIST__ = $merchantGroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
						<td align="center"><?php echo ($vo['id']); ?></td>
						<td align="center">
							<a href="<?php echo U('group_details');?>/groupid/<?php echo ($vo['id']); ?>" target="main"><?php echo ($vo['name']); ?></a>
						</td>
						<td align="center">
							<input type="submit" value="删除" onclick="delete_group(<?php echo ($vo['id']); ?>)"/>
						</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</form>
</body>
</html>