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
	function delete_previewcommentreply(previewcommentreply_id)
	{
		if(confirm("确定删除该记录吗?")){
		  document.previewcommentreply_form.action="__URL__/delete_previewcommentreply/id/"+previewcommentreply_id;
		  document.previewcommentreply_form.submit();
		}
	}
	function edit_previewcommentreply(previewcommentreply_id)
	{
		document.previewcommentreply_form.action="__URL__/edit_previewcommentreply/id/"+previewcommentreply_id;
		document.previewcommentreply_form.submit();
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
	<form name="previewcomment_form" method="post" action="<?php echo U('update_previewcomment');?>">
		<table>
			<tr>
				<td>
					<label for="content">内容</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					
					<textarea name="content" cols="30" rows="4" style="max-width: 300px;max-height:160px;" required><?php echo ($previewcomment["content"]); ?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="time">时间</label>
				</td>
				<td>
					<input type="text" name="time" required value="<?php echo ($previewcomment["time"]); ?>"/>
				</td>
			</tr>
			<tr>
				<td>
					<label for="uid">用户ID</label>
				</td>
				<td>
					<input type="text" name="uid" value="<?php echo ($previewcomment["uid"]); ?>" />
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
	<h4>添加回复</h4>
	<form method="post" action="<?php echo U('save_previewcommentreply');?>">
		<table>
			<tr>
				<td>
					<label for="content">内容</label>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<textarea name="content" cols="30" rows="4" style="max-width: 300px;max-height:160px;" required></textarea>
				</td>
			</tr>
			<tr>
				<td>
					<label for="uid">用户ID</label>
				</td>
				<td>
					<input type="text" name="uid" required/>
				</td>
				<td>
					<input type="hidden" name="cid" value="<?php echo ($previewcomment["id"]); ?>"/>
					<input type="submit" value="提交" name="dosubmit">
				</td>
			</tr>
		</table>
	</form>
	<form name="previewcommentreply_form" method="post">
	<?php if(empty($allPreviewCommentReplys)): ?><h3>暂时没有回复！</h3>
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
					<?php if(is_array($allPreviewCommentReplys)): $i = 0; $__LIST__ = $allPreviewCommentReplys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr  class="tr_merchant_info">
							<td align="center"><?php echo ($vo["id"]); ?></td>
							<td align="center"><?php echo ($vo["content"]); ?></td>
							<td align="center"><?php echo ($vo["time"]); ?></td>
							<td align="center"><?php echo ($vo["uid"]); ?></td>
							<td align="center">
								<input  type="button" value="编辑"  onClick="edit_previewcommentreply(<?php echo ($vo["id"]); ?>)" />
								<input  type="button" value="删除" onClick="delete_previewcommentreply(<?php echo ($vo["id"]); ?>)"/>
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