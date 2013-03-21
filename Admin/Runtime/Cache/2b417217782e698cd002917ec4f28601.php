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
	<div id="form">
		<form method="post" action="__URL__/checkLogin" id="myform">
			<div>
				<span class="legend">
					<h2>管理员登录</h2>
				</span>
				<table style="vertical-align:top;">
					<tr>
						<td>
							<label for="username">用户名：</label>
						</td>
						<td>
							<input name="username" id="adminName"type='text'style="width:180px" />
						</td>
					</tr>
					<tr>
						<td >
							<label for="password" >密  码：</label>
						</td>
						<td>
							<input name="password" id="adminPwd"type='password'style="width:180px" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<span>
								<input type="checkbox" value="isremember" name="isremember" selected="true"/>
								<label for="isremember">记住密码</label>
							</span>
						</td>
					</tr>
				</table>
				<input type="hidden" name="nid" value="{#vo.id}" id="nid"/>
				<input type="submit" name="dosubmit" value="登录"/>
			</div>
		</form>
	</div>
</body>
</html>