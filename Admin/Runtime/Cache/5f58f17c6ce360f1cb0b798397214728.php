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
	function delete_previewcomment(previewcomment_id)
	{
		if(confirm("确定删除该记录吗?")){
		  return document.douuser_form.action="__URL__/delete_previewcomment/id/"+previewcomment_id;
		}else{
			return false;
		}
	}
	function edit_previewcomment(previewcomment_id)
	{
		return document.douuser_form.action="__URL__/edit_previewcomment/id/"+previewcomment_id;
	}
</script>
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
	<form action="<?php echo U('index');?>" method="post">
		<span>
			<select name="search_field">
				<option value="id">ID</option>
				<option value="content">内容</option>
				<option value="time">时间</option>
				<option value="uid">用户ID</option>
			</select>
		</span>
		<span>
			<label for="search_keyword">关键字</label>
			<input type="text" name="search_keyword"/>
		</span>
		<input type="submit" value="搜索"  name="dosearch"/>
	</form>
	<form name="douuser_form">
		<?php if(empty($allPreviewComments)): ?><h3>暂时没有用户！</h3>
			<?php else: ?>
			<table cellspacing="0" style="font-size: 16px;width:800px;">
				<thead style="background:#C0C0C0;">
					<tr>
						<th width="50" align="center">ID</th>
						<th align="center">内容</th>
						<th align="center">时间</th>
						<th align="center">用户ID</th>
						<th align="center">管理</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($allPreviewComments)): $i = 0; $__LIST__ = $allPreviewComments;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr  class="tr_merchant_info">
							<td align="center"><?php echo ($vo["id"]); ?></td>
							<td align="center"><?php echo ($vo["content"]); ?></td>
							<td align="center"><?php echo ($vo["time"]); ?></td>
							<td align="center"><?php echo ($vo["uid"]); ?></td>
							<td align="center">
								<input  type="submit" value="编辑"  onclick="edit_previewcomment(<?php echo ($vo["id"]); ?>)" />
								<input  type="submit" value="删除" onClick="delete_previewcomment(<?php echo ($vo["id"]); ?>)"/>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					<tr>
		              <td height="40" colspan="6" align="center" valign="middle"><?php echo ($page); ?></td>
		            </tr>
				</tbody>
			</table><?php endif; ?>
	</form>
</body>
</html>