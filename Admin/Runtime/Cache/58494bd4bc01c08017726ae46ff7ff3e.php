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
		<a href="<?php echo U('index');?>"  target="main" title="管理用户" style="text-decoration:none;color:#333">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">管理用户</span>
		</a>
		<a href="<?php echo U('add_douuser');?>" style="text-decoration:none;" target="main" title="添加用户">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">添加用户</span>
		</a>
		<a href="<?php echo U('broadcast');?>" style="text-decoration:none;" target="main" title="添加用户">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">发送广播</span>
		</a>
	</p>
</div>
<hr style="margin-right:10px;color:#EEEEEE;"/>
	<form method="post" action="<?php echo U('send_broadcast');?>">
		<table>
			<tr>
				<td>
					<label for="message">留言</label>
				</td>
			</tr>
			<tr>
				<td>
					<textarea name="message" cols="30" rows="4" style="max-width: 300px;max-height:160px;" required></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<input type="submit" value="提交" name="dosubmit">
					<input type="button" onClick="history.back()" value="取 消" />
				</td>
			</tr>
		</table>
	</form>
</body>
</html>