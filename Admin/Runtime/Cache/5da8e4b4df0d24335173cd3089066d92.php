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
	function delete_common(common_id)
	{
		if(confirm("确定删除该记录吗?")){
		  return document.common_form.action="__URL__/delete_common/id/"+common_id;
		}else{
			return false;
		}
	}
	function edit_common(common_id)
	{
		return document.common_form.action="__URL__/edit_common/id/"+common_id;
	}
</script>
</head>
<body>
	<div style="background:#FFFFFF;height:25px;margin-bottom:5px;width:100%;">
	<p>
		<a href="<?php echo U('index');?>"  target="main" title="管理配置" style="text-decoration:none;color:#333">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">管理配置</span>
		</a>
		<a href="<?php echo U('add_common');?>" style="text-decoration:none;" target="main" title="添加配置">
			<span style="margin-right:5px;margin-top:5px;margin-left:10px;padding: 3px;font-size:12px;background-color:#618d01;color:#fff;">添加配置</span>
		</a>
	</p>
</div>
<hr style="margin-right:10px;color:#EEEEEE;"/>
	<form name="common_form">
		<?php if(empty($allCommons)): ?><h3>暂时没有配置！</h3>
			<?php else: ?>
			<table cellspacing="0" style="font-size: 16px;width:800px;">
				<thead style="background:#C0C0C0;">
					<tr>
						<th width="50" align="center">ID</th>
						<th align="center">资讯网址</th>
						<th align="center">支持数</th>
						<th align="center">地区编号</th>
						<th align="center">管理</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($allCommons)): $i = 0; $__LIST__ = $allCommons;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr  class="tr_merchant_info">
							<td align="center"><?php echo ($vo["id"]); ?></td>
							<td align="center"><a href="<?php echo ($vo["url"]); ?>" target="blank"><?php echo ($vo["url"]); ?></a></td>
							<td align="center"><?php echo ($vo["up"]); ?></td>
							<td align="center"><?php echo ($vo["areacode"]); ?></td>
							<td align="center">
								<input  type="submit" value="编辑"  onclick="edit_common(<?php echo ($vo["id"]); ?>)" />
								<input  type="submit" value="删除" onClick="delete_common(<?php echo ($vo["id"]); ?>)"/>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table><?php endif; ?>
	</form>
</body>
</html>