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
	<form method="post" action="<?php echo U('addMerchant');?>">
		<table style="width:400px;" >
			<tr>
				<td>
					<label for="name">名称</label>
				</td>
				<td>
					<input type="text" name="name" required style="width:300px;"/>
				</td>
			</tr>
			<tr>
				<td >
					<label for="major">主营:</label>
				</td>
				<td >
					<input name="major" type="text" required  style="width:300px;"/> 
				</td>
			</tr>
			<tr>
				<td>
					<label for="address">地址：</label>
				</td>
				<td>
					<input type="text" name="address" required style="width:300px;"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="phone">电话：</label>
				</td>
				<td>
					<input type="text" name="phone" required 	style="width:300px;"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="website">网址：</label>
				</td>
				<td>
					<input type="text" name="website" required style="width:300px;"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="introduction">商家简介:</label>
				</td>
				<td>
					<textarea name="introduction" rows="4" style="width: 300px;max-height:160px;" required></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="news">最新动态:</label>
				</td>
				<td>
					<textarea name="news" rows="4" style="width: 300px;max-height:160px;" ></textarea>
				</td>
			</tr>
			
			<tr>
				<td>
					
				</td>
				<td>
					<span><input type="checkbox" name="isrecommend" checked/>
					<label for="isrecommend">推荐</label></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<span><input type="checkbox" name="status" checked />
					<label for="status">用户可见</label></span>
				</td>
			</tr>
			<tr><td colspan="2" align="center"><input type="submit" value="提交" name="dosubmit"></td></tr>
		</table>
	</form>
</body>
</html>