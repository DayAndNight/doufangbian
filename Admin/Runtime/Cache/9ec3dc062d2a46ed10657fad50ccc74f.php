<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<style type="text/css">
	body{
		font-family: "微软雅黑","宋体";
	}
	</style>
</head>
<body>
	<div style="float:left;">
		<h1>豆方便管理系统</h1>
	</div>
	<div style="float:right;">
		<span>
			<span>你好,<?php echo ($_SESSION[C('loginUserName')]); ?></span>
			<a href="__GROUP__/Public/logout" target="_top">注销</a>
			<a href="__GROUP__/Index/index" target="_parent">首页</a>
		</span>
	</div>
</body>