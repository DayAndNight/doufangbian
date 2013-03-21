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
	function update_douuser()
	{
		if (document.getElementsByName("newphoto")[0].checked) {
			var fileupload = document.getElementsByName("photo")[0];
            var filename = fileupload.value;
           	if(filename == ""){
             	alert('请上传头像后在保存，或选择不替换头像！');
             	return false;
           	}           
		};
		if(confirm("确定要修改记录吗?")){
		  	return document.douuser_form.action="__URL__/update_douUser";
		}
	}
</script>
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
	<form name="douuser_form" method="post" action="" enctype="multipart/form-data">
		<table>
			<tr>
				<td>
					<label for="username">名称</label>
				</td>
				<td>
					<input type="text" name="username" required value="<?php echo ($douuser["username"]); ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="password">密码</label>
				</td>
				<td>
					<input type="text" name="password" required value="<?php echo ($douuser["password"]); ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="photo">头像</label>
				</td>
				<td>
					<input type="file" name="photo" />
				</td>
				<td>
					<input type="checkbox" name="newphoto">替换</input>
				</td>
			</tr>
			<tr>
				<td>
					<label for="gender">性别</label>
				</td>
				<td>
					<select type="text" name="gender" required>
						<option value="0" <?php if($douuser['gender']==0) echo("selected");?>>女</option>
						<option value="1" <?php if($douuser['gender']==1) echo("selected");?>>男</option>
					</select>
				</td>
			</tr>
		</tr>
			<tr>
				<td>
					<label for="phone">电话</label>
				</td>
				<td>
					<input type="text" name="phone" value="<?php echo ($douuser["phone"]); ?>" />
				</td>
			</tr>
			<tr>
				<td>
					<label for="qq">QQ</label>
				</td>
				<td>
					<input type="text" name="qq" value="<?php echo ($douuser["qq"]); ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="cash">豆币</label>
				</td>
				<td>
					<input type="text" name="cash" value="<?php echo ($douuser["cash"]); ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="message">留言</label>
				</td>
				<td>
					<textarea name="message" cols="30" rows="4" style="max-width: 300px;max-height:160px;" required><?php echo ($douuser["message"]); ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="status">状态</label>
				</td>
				<td>
					<select type="text" name="status" required>
						<option value="1" <?php if($douuser['status']==1) echo("selected");?>>正常</option>
						<option value="0" <?php if($douuser['status']==0) echo("selected");?>>禁用</option>
					</select>
				</td>
			</tr>
		<tr>
			<td colspan="2">
				<input type="hidden" name="id" value="<?php echo ($douuser["id"]); ?>"/>
				<input type="submit" value="保 存" name="dosubmit" onClick="update_douuser();">
				<input type="button" onClick="history.back()" value="取 消" />
			</td>
		</tr>
	</table>
</form>
</body>
</html>