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
	function delete_douuser(douuser_id)
	{
		if(confirm("确定删除该记录吗?")){
		  return document.douuser_form.action="__URL__/delete_douuser/id/"+douuser_id;
		}else{
			return false;
		}
	}
	function edit_douuser(douuser_id)
	{
		return document.douuser_form.action="__URL__/edit_douuser/id/"+douuser_id;
	}
	function display(id){
        var traget=document.getElementById(id);
         if(traget.style.display=="none"){
         	traget.style.display="";
         }else{
         	traget.style.display="none";
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
	<form action="<?php echo U('index');?>" method="post">
		<span>
			<select name="search_field">
				<option value="id">用户ID</option>
				<option value="username">用户名</option>
				<option value="phone">电话</option>
				<option value="qq">QQ</option>
				<option value="message">留言</option>
				<option value="status">状态</option>
			</select>
		</span>
		<span>
			<label for="search_keyword">关键字</label>
			<input type="text" name="search_keyword"/>
		</span>
		<input type="submit" value="搜索"  name="dosearch"/>
	</form>
	<form name="douuser_form">
		<?php if(empty($allDouUsers)): ?><h3>暂时没有用户！</h3>
			<?php else: ?>
			<table cellspacing="0" style="font-size: 16px;width:800px;">
				<thead style="background:#C0C0C0;">
					<tr>
						<th width="50" align="center">ID</th>
						<th align="center">用户名</th>
						<th align="center">性别</th>
						<th align="center">电话</th>
						<th align="center">豆币</th>
						<th align="center">状态</th>
						<th align="center">管理</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($allDouUsers)): $i = 0; $__LIST__ = $allDouUsers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr  class="tr_merchant_info">
							<td align="center"><?php echo ($vo["id"]); ?></td>
							<td align="center"><?php echo ($vo["username"]); ?></td>
							<td align="center">
								<?php if($vo["gender"] == 0 ): ?>女
    								<?php else: ?> 男<?php endif; ?>
							</td>
							<td align="center"><?php echo ($vo["phone"]); ?></td>
							<td align="center"><?php echo ($vo["cash"]); ?></td>
							<td align="center">
								<?php if($vo["status"] == 0 ): ?>禁用
    								<?php else: ?>正常<?php endif; ?>
							</td>
							<td align="center">
								<input  type="submit" value="编辑"  onclick="edit_douuser(<?php echo ($vo['id']); ?>)" />
								<input  type="submit" value="删除" onClick="delete_douuser(<?php echo ($vo['id']); ?>)"/>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table><?php endif; ?>
	</form>
</body>
</html>