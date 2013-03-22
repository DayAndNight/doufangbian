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
</head>
<body>
	<div style="background:#FFFFFF;height:25px;margin-bottom:5px;width:100%;">
	<p>
		<a href="<?php echo U('index');?>"  target="main" title="管理留言" style="text-decoration:none;color:#333">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">管理留言</span>
		</a>
		<a href="<?php echo U('add_previewcomment');?>" style="text-decoration:none;" target="main" title="添加留言">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">添加留言</span>
		</a>
	</p>
</div>
<hr style="margin-right:10px;color:#EEEEEE;"/>
	<form name="previewcommentreply_form" method="post" action="<?php echo U('update_previewcommentreply');?>">
		<table>
			<tr>
				<td>
					<label for="content">内容</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					
					<textarea name="content" cols="30" rows="4" style="max-width: 300px;max-height:160px;" required><?php echo ($previewcommentreply["content"]); ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="time">时间</label>
				</td>
				<td>
					<input type="text" name="time" required value="<?php echo ($previewcommentreply["time"]); ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="uid">用户ID</label>
				</td>
				<td>
					<input type="text" name="uid" value="<?php echo ($previewcommentreply["uid"]); ?>" />
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="hidden" name="id" value="<?php echo ($previewcomment["id"]); ?>"/>
					<input type="submit" value="保 存" name="dosubmit"/>
					<input type="button" onClick="history.back()" value="取 消" />
				</td>
			</tr>
	</table>
</form>
</body>
</html>