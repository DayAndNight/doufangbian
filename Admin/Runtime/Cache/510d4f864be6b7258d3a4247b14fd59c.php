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
	function delete_merchant(merchant_id)
	{
		if(confirm("确定删除该记录吗?")){
		  return document.merchant_form.action="__URL__/deleteMerchant/id/"+merchant_id;
		}else{
			return false;
		}
	}
	function edit_merchant(merchant_id)
	{
		return document.merchant_form.action="__URL__/edit_merchant/id/"+merchant_id;
	}
	/*function display(id){
        var traget=document.getElementById(id);
         if(traget.style.display=="none"){
         	traget.style.display="";
         }else{
         	traget.style.display="none";
         }
    }*/
</script>
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
	<form action="<?php echo U('index');?>" method="post">
		<span>
			<select name="search_group">
				<option value="-1">所有分类</option>
				<?php if(is_array($merchantGroups)): $i = 0; $__LIST__ = $merchantGroups;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pType): $mod = ($i % 2 );++$i;?><option value="<?php echo ($pType['id']); ?>"><?php echo ($pType['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
		</span>
		<span>
			<label for="search_keyword">关键字</label>
			<input type="text" name="search_keyword"/>
		</span>
		<input type="submit" value="搜索"  name="dosearch"/>
	</form>
	<form name="merchant_form">
		<?php if(empty($allMerchants)): ?><h3>暂时没有商家！</h3>
			<?php else: ?>
			<table cellspacing="0" style="font-size: 16px;width:800px;">
				<thead style="background:#C0C0C0;">
					<tr>
						<th width="50" align="center">ID</th>
						<th align="center">名称</th>
						<th align="center">主营</th>
						<th  align="center">顶</th>
						<th  align="center">用户可见</th>
						<th align="center">管理</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($allMerchants)): $i = 0; $__LIST__ = $allMerchants;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr  class="tr_merchant_info">
							<td align="center"><?php echo ($vo['id']); ?></td>
							<td align="center">
								<a href="<?php echo U(merchant_details);?>/merchantid/<?php echo ($vo['id']); ?>" target="main"><?php echo ($vo['name']); ?></a>
								<?php if(($vo['isrecommend'] == 1)): ?><img src="__PUBLIC__/admin/images/recommend.gif" title="推荐商家"/>
									<?php else: endif; ?>
							</td>
							<td align="center"><?php echo ($vo["major"]); ?></td>
							<td align="center"><?php echo ($vo['up']); ?></td>
							<td align="center">
								<?php if($vo["status"] == 1): ?>是
									<?php else: ?>
									否<?php endif; ?>
							</td>
							<td align="center">
								<input  type="submit" value="编辑"  onclick="edit_merchant(<?php echo ($vo['id']); ?>)" />
								<input  type="submit" value="删除" onClick="delete_merchant(<?php echo ($vo['id']); ?>)"/>
							</td>
						</tr><?php endforeach; endif; else: echo "" ;endif; ?>
				</tbody>
			</table><?php endif; ?>
	</form>
</body>
</html>